<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\DemoAcademicSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'BridgeBox Admin',
                'email' => 'admin@bridgebox.local',
                'role' => 'admin',
            ],
            [
                'name' => 'BridgeBox Teacher',
                'email' => 'teacher@bridgebox.local',
                'role' => 'teacher',
            ],
            [
                'name' => 'BridgeBox Student',
                'email' => 'student@bridgebox.local',
                'role' => 'student',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'role' => $user['role'],
                    'password' => Hash::make('BridgeBox@123'),
                ]
            );
        }

        $this->call(DemoAcademicSeeder::class);
    }
}
