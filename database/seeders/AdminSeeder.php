<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'username' => 'Super Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin123'), // hashed password
                'role' => 'admin',
                'is_active' => '1',
            ]
        );
    }
}
