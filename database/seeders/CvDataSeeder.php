<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CvDataSeeder extends Seeder
{
    public function run()
    {
        // Create or get existing user
        $userId = DB::table('users')
            ->where('email', 'employee1@example.com')
            ->value('id');

        // Dapatkan employee_id dari tabel employees
        $employeeId = DB::table('employees')
            ->where('user_id', $userId) // Asumsi ada kolom user_id di tabel employees
            ->value('id');

        // Insert CVs
        $cv1Id = DB::table(table: 'cvs')->insertGetId([
            'employee_id' => $employeeId,
            'title' => 'CV Web Developer Profesional',
            'slug' => Str::slug('CV Web Developer Profesional') . '-' . uniqid(),
            'status' => 'completed',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Personal Information
        DB::table('cv_personal_information')->insert([
            'cv_id' => $cv1Id,
            'full_name' => 'Aditya Pratama',
            'phone_number' => '081234567890',
            'email' => 'aditya.p@example.com',
            'linkedin_url' => 'https://linkedin.com/in/adityapratama',
            'portfolio_url' => 'https://adityap.dev',
            'address' => 'Jl. Kebon Jeruk No. 45, Jakarta Barat, 11530',
            'summary' => 'Seorang pengembang web berpengalaman dengan lebih dari 5 tahun pengalaman...',
            'profile_photo' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Work Experiences
        DB::table('cv_work_experiences')->insert([
            [
                'cv_id' => $cv1Id,
                'company_name' => 'PT. Inovasi Digital Indonesia',
                'position' => 'Senior Web Developer',
                'location' => 'Jakarta Selatan',
                'company_profile' => 'Perusahaan teknologi yang fokus pada solusi perangkat lunak enterprise.',
                'start_month' => 'Januari',
                'start_year' => 2022,
                'end_month' => null,
                'end_year' => null,
                'currently_working' => true,
                'portfolio_description' => '- Memimpin tim pengembangan back-end...',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'cv_id' => $cv1Id,
                'company_name' => 'Startup Kreatif Solusi',
                'position' => 'Fullstack Developer',
                'location' => 'Bandung',
                'company_profile' => 'Startup di bidang pengembangan aplikasi mobile dan web.',
                'start_month' => 'Maret',
                'start_year' => 2019,
                'end_month' => 'Desember',
                'end_year' => 2021,
                'currently_working' => false,
                'portfolio_description' => '- Mengembangkan fitur-fitur baru...',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        // Education
        DB::table('cv_educations')->insert([
            'cv_id' => $cv1Id,
            'school_name' => 'Institut Teknologi Bandung',
            'location' => 'Bandung',
            'start_month' => 'Agustus',
            'start_year' => 2015,
            'graduation_month' => 'Juni',
            'graduation_year' => 2019,
            'degree_level' => 'S1 Teknik Informatika',
            'description' => 'Mempelajari struktur data, algoritma...',
            'gpa' => 3.92,
            'gpa_max' => 4.00,
            'activities' => 'Asisten Dosen mata kuliah...',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Other Experiences
        DB::table('cv_other_experiences')->insert([
            [
                'cv_id' => $cv1Id,
                'category' => 'Skill',
                'year' => null,
                'description' => 'PHP (Laravel, Lumen), JavaScript...',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'cv_id' => $cv1Id,
                'category' => 'Penghargaan',
                'year' => 2018,
                'description' => 'Juara 1 Lomba Aplikasi Web Tingkat Nasional',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        $this->command->info('CV data seeded successfully!');
    }
}
