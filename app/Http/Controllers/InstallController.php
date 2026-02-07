<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use App\Models\Section;

class InstallController extends Controller
{
    public function show(): View|RedirectResponse
    {
        if ($this->isInstalled()) {
            return redirect()->route('landing');
        }

        return view('install', [
            'sections' => $this->defaultSections(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        if ($this->isInstalled()) {
            return redirect()->route('landing');
        }

        if (!Schema::hasTable('users') || !Schema::hasTable('sections')) {
            return back()->withErrors([
                'install' => 'Database tables are missing. Please run migrations first.',
            ]);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'sections' => ['required', 'array', 'min:1'],
            'sections.*' => ['string'],
        ]);

        $admin = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => User::ROLE_ADMIN,
            'is_active' => true,
            'password' => Hash::make($data['password']),
        ]);

        $this->seedSelectedSections($data['sections']);
        $this->writeLock($admin->email);

        return redirect()->route('login', ['role' => 'admin']);
    }

    private function defaultSections(): array
    {
        return [
            ['name' => 'Creche', 'slug' => 'creche', 'description' => 'Creche section'],
            ['name' => 'Kindergarten', 'slug' => 'kindergarten', 'description' => 'Kindergarten section'],
            ['name' => 'Primary', 'slug' => 'primary', 'description' => 'Primary section'],
            ['name' => 'Junior Secondary', 'slug' => 'junior-secondary', 'description' => 'Junior secondary section'],
            ['name' => 'Senior Secondary', 'slug' => 'senior-secondary', 'description' => 'Senior secondary section'],
            ['name' => 'University', 'slug' => 'university', 'description' => 'University section'],
        ];
    }

    private function seedSelectedSections(array $selectedSlugs): void
    {
        $sections = collect($this->defaultSections())
            ->keyBy('slug')
            ->only($selectedSlugs)
            ->values();

        foreach ($sections as $section) {
            Section::updateOrCreate(
                ['slug' => $section['slug']],
                [
                    'name' => $section['name'],
                    'description' => $section['description'],
                ]
            );
        }
    }

    private function isInstalled(): bool
    {
        return file_exists($this->lockPath());
    }

    private function writeLock(string $email): void
    {
        $path = $this->lockPath();
        $dir = dirname($path);

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $payload = [
            'installed_at' => now()->toIso8601String(),
            'admin_email' => $email,
        ];

        file_put_contents($path, json_encode($payload));
    }

    private function lockPath(): string
    {
        return storage_path('app/installed.lock');
    }
} 
