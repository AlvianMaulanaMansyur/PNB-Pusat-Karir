<?php

namespace Database\Seeders;

use App\Models\employers;
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
        $slug = 'employer-' . substr(md5(2), 0, 8);
        
        DB::table('employers')->insert([
            'user_id' => 2,
            'slug' => $slug,
            'company_name' => 'PT Maju Jaya Abadi',
            'business_registration_number' => '1234567890',
            'industry' => 'Teknologi Informasi',
            'company_website' => 'https://majujaya.co.id',
            'organization_type' => 'Startup',
            'staff_strength' => '51-200',
            'country' => 'Indonesia',
            'city' => 'Denpasar',
            'company_profile' => 'PT Maju Jaya Abadi adalah perusahaan IT yang bergerak di bidang pengembangan perangkat lunak dan layanan digital.',
            'salutation' => 'Bapak',
            'first_name' => 'Andi',
            'last_name' => 'Santoso',
            'suffix' => '',
            'job_title' => 'HR Manager',
            'department' => 'Human Resource',
            'phone' => '081234567890',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
