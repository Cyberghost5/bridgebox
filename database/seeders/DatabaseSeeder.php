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
                'name' => 'Amina Yusuf',
                'email' => 'amina.yusuf@bridgebox.edu',
                'role' => 'admin',
            ],
            [
                'name' => 'Chinedu Okoro',
                'email' => 'chinedu.okoro@bridgebox.edu',
                'role' => 'teacher',
            ],
            [
                'name' => 'Zainab Bello',
                'email' => 'zainab.bello@bridgebox.edu',
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
