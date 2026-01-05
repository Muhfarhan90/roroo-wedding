<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Mimin Roro 1',
                'email' => 'Miminroro1@gmail.com',
                'password' => Hash::make('Fatimah95'),
            ],
            [
                'name' => 'Mimin Roro 2',
                'email' => 'Miminroro2@gmail.com',
                'password' => Hash::make('Fatimah95'),
            ],
            [
                'name' => 'Mimin Roro 3',
                'email' => 'Miminroro3@gmail.com',
                'password' => Hash::make('Fatimah95'),
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                array_merge($userData, ['email_verified_at' => now()])
            );
        }
    }
}
