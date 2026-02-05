(() => {
    const container = document.querySelector('[data-refresh-url]');
    if (!container) {
        return;
    }

    const refreshUrl = container.dataset.refreshUrl;
    const interval = parseInt(container.dataset.refreshInterval || '0', 10);
    const autoRefresh = container.dataset.autoRefresh !== 'off';

    if (!refreshUrl || !autoRefresh || Number.isNaN(interval) || interval <= 0) {
        return;
    }

    const updateTile = (key, value) => {
        const target = document.querySelector(`[data-status="${key}"]`);
        if (!target) {
            return;
        }
        target.textContent = value ?? 'Unknown';
    };

    const applyStatus = (data) => {
        if (!data) {
            return;
        }
        updateTile('server', data.server);
        updateTile('hotspot', data.hotspot);
        updateTile('devices', data.devices);
        updateTile('app_health', data.app_health);
        updateTile('storage', data.storage);
        updateTile('power', data.power);
        updateTile('uptime', data.uptime);
        updateTile('last_update', data.last_update);
    };

    const fetchStatus = async () => {
        try {
            const response = await fetch(refreshUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                credentials: 'same-origin',
            });

            if (!response.ok) {
                return;
            }

            const payload = await response.json().catch(() => null);
            applyStatus(payload);
        } catch (error) {
            // Silent failure for offline-friendly behavior.
        }
    };

    fetchStatus();
    window.setInterval(fetchStatus, interval);
})();