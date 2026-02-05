<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Symfony\Component\Process\Process;

class SystemStatusService
{
    private const CACHE_KEY = 'admin.system_status';
    private const CACHE_TTL_SECONDS = 7;

    public function snapshot(): array
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL_SECONDS, function () {
            return [
                'server' => $this->getServerStatus(),
                'hotspot' => $this->getHotspotStatus(),
                'devices' => $this->getConnectedDevices(),
                'app_health' => $this->getAppHealth(),
                'storage' => $this->getStorage(),
                'power' => $this->getPowerHealth(),
                'uptime' => $this->getUptime(),
                'last_update' => $this->getLastUpdate(),
            ];
        });
    }

    private function getServerStatus(): string
    {
        $nginxActive = $this->isServiceActive(['nginx']);
        $phpActive = $this->isServiceActive(['php-fpm', 'php8.2-fpm', 'php8.1-fpm', 'php8.0-fpm']);

        if ($nginxActive === null && $phpActive === null) {
            return 'Unknown';
        }

        if ($nginxActive && $phpActive) {
            return 'Running';
        }

        return 'Stopped';
    }

    private function getHotspotStatus(): string
    {
        $output = $this->runCommand('nmcli -t -f NAME,TYPE,DEVICE,ACTIVE con show --active');
        if ($output === null) {
            return 'Unknown';
        }

        $lines = array_filter(explode("\n", trim($output)));
        foreach ($lines as $line) {
            $parts = explode(':', $line);
            $name = $parts[0] ?? '';
            $type = $parts[1] ?? '';
            $active = $parts[3] ?? '';

            if ($active === 'yes' && ($name === 'Hotspot' || $type === 'wifi')) {
                return $name ? "On · {$name}" : 'On';
            }
        }

        return 'Off';
    }

    private function getConnectedDevices(): string
    {
        $output = $this->runCommand('iw dev wlan0 station dump');
        if ($output === null) {
            return 'Unknown';
        }

        $count = 0;
        foreach (explode("\n", $output) as $line) {
            if (str_starts_with(trim($line), 'Station')) {
                $count++;
            }
        }

        return (string) $count;
    }

    private function getAppHealth(): string
    {
        $queue = config('queue.default', 'sync');
        $queueLabel = $queue === 'sync' ? 'Queue: sync' : "Queue: {$queue}";

        $logPath = storage_path('logs/laravel.log');
        if (is_file($logPath)) {
            $lastError = date('Y-m-d H:i', filemtime($logPath));
            return "{$queueLabel} · Last error: {$lastError}";
        }

        return "{$queueLabel} · Last error: none";
    }

    private function getStorage(): string
    {
        $path = base_path();
        $free = @disk_free_space($path);
        $total = @disk_total_space($path);

        if ($free === false || $total === false) {
            return 'Unknown';
        }

        return sprintf('%s free / %s total', $this->formatBytes($free), $this->formatBytes($total));
    }

    private function getPowerHealth(): string
    {
        $volts = $this->runCommand('vcgencmd measure_volts');
        $throttled = $this->runCommand('vcgencmd get_throttled');

        if ($volts === null && $throttled === null) {
            return 'Unknown';
        }

        $voltsValue = 'voltage: n/a';
        if ($volts) {
            $voltsValue = trim(str_replace('volt=', '', $volts));
        }

        $throttledValue = 'throttled: n/a';
        if ($throttled) {
            $throttledValue = trim(str_replace('throttled=', '', $throttled));
        }

        return "{$voltsValue} · {$throttledValue}";
    }

    private function getUptime(): string
    {
        $procUptime = '/proc/uptime';
        if (is_file($procUptime)) {
            $contents = trim((string) file_get_contents($procUptime));
            $seconds = (int) floor((float) explode(' ', $contents)[0]);
            return $this->formatDuration($seconds);
        }

        $output = $this->runCommand('uptime -p');
        return $output ? trim($output) : 'Unknown';
    }

    private function getLastUpdate(): string
    {
        $versionPath = base_path('VERSION');
        if (is_file($versionPath)) {
            $version = trim((string) file_get_contents($versionPath));
            return $version !== '' ? $version : 'unknown';
        }

        return 'unknown';
    }

    private function isServiceActive(array $serviceNames): ?bool
    {
        foreach ($serviceNames as $service) {
            $output = $this->runCommand("systemctl is-active {$service}");
            if ($output === null) {
                continue;
            }

            $status = trim($output);
            if ($status === 'active') {
                return true;
            }

            if (in_array($status, ['inactive', 'failed', 'deactivating'], true)) {
                return false;
            }
        }

        return null;
    }

    private function runCommand(string $command): ?string
    {
        try {
            $process = Process::fromShellCommandline($command);
            $process->setTimeout(2);
            $process->run();

            if (!$process->isSuccessful()) {
                return null;
            }

            return trim($process->getOutput());
        } catch (\Throwable $exception) {
            return null;
        }
    }

    private function formatBytes(float $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $index = 0;
        while ($bytes >= 1024 && $index < count($units) - 1) {
            $bytes /= 1024;
            $index++;
        }

        return sprintf('%.1f %s', $bytes, $units[$index]);
    }

    private function formatDuration(int $seconds): string
    {
        $days = intdiv($seconds, 86400);
        $hours = intdiv($seconds % 86400, 3600);
        $minutes = intdiv($seconds % 3600, 60);

        $parts = [];
        if ($days > 0) {
            $parts[] = $days . 'd';
        }
        if ($hours > 0) {
            $parts[] = $hours . 'h';
        }
        $parts[] = $minutes . 'm';

        return implode(' ', $parts);
    }
}