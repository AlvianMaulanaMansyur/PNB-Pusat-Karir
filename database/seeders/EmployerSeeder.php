<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EmployerSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'username'   => 'admin',
                'password'   => Hash::make('password123'),
                'email'      => 'admin@example.com',
                'role'       => 'admin',
                'is_active'  => 1,
                'created_at' => Carbon::now(),
                'last_login' => Carbon::now(),
            ],
            [
                'username'   => 'employer1',
                'password'   => Hash::make('password123'),
                'email'      => 'employer1@example.com',
                'role'       => 'employer',
                'is_active'  => 1,
                'created_at' => Carbon::now()->subDays(3),
                'last_login' => Carbon::now()->subDay(),
            ],
            [
                'username'   => 'employee1',
                'password'   => Hash::make('password123'),
                'email'      => 'employee1@example.com',
                'role'       => 'employee',
                'is_active'  => 1,
                'created_at' => Carbon::now()->subWeek(),
                'last_login' => null,
            ],
        ]);
    }
}
