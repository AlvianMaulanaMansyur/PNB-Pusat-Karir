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
            [
                'username'   => 'employee2',
                'password'   => Hash::make('password123'),
                'email'      => 'employee2@example.com',
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

        $employees = [
            [
                'user_id' => 3,
                'salutation' => 'Mr.',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'suffix' => '',
                'phone' => '+628123456789',
                'country' => 'Indonesia',
                'city' => 'Jakarta',
                'highest_education' => 'S1',
                'main_skill' => 'Web Development',
                'current_or_previous_industry' => 'IT',
                'current_or_previous_job_type' => 'Full-time',
                'current_or_previous_position' => 'Software Engineer',
                'employment_status' => 'Employed',
                'years_of_experience' => 5,
                'availability' => 'Immediately',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 4,
                'salutation' => 'Ms.',
                'first_name' => 'Sari',
                'last_name' => 'Putri',
                'suffix' => '',
                'phone' => '+628987654321',
                'country' => 'Indonesia',
                'city' => 'Surabaya',
                'highest_education' => 'S2',
                'main_skill' => 'Data Analysis',
                'current_or_previous_industry' => 'Finance',
                'current_or_previous_job_type' => 'Part-time',
                'current_or_previous_position' => 'Data Analyst',
                'employment_status' => 'Unemployed',
                'years_of_experience' => 3,
                'availability' => 'Within 1 Month',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Tambah data lain sesuai kebutuhan
        ];

        DB::table('employees')->insert($employees);

        $jobListings = [
            [
                'employer_id' => 1,
                'slug' => Str::slug('Software Engineer'),
                'nama_lowongan' => 'Software Engineer',
                'deskripsi' => 'Kami mencari Software Engineer yang handal dan berpengalaman.',
                'posisi' => 'admin',
                'kualifikasi' => 'Admin',
                'jenislowongan' => 'Full Time',
                'deadline' => Carbon::now()->addMonth()->toDateString(),
                'poster' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employer_id' => 1,
                'slug' => Str::slug('Marketing Specialist'),
                'nama_lowongan' => 'Marketing Specialist',
                'deskripsi' => 'Posisi Marketing Specialist untuk mengembangkan strategi pemasaran.',
                'posisi' => 'admin',
                'kualifikasi' => 'admin',
                'jenislowongan' => 'Freelance',
                'deadline' => Carbon::now()->addWeeks(3)->toDateString(),
                'poster' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('job_listings')->insert($jobListings);

        $now = Carbon::now();



        $slug = 'app-' . substr(md5(2), 0, 8);
        $applications = [

            
            [
                'job_id' => 1,
                'slug' => 'app-' . substr(md5('1-1'), 0, 8),
                'employee_id' => 1,
                'applied_at' => $now->subDays(10),
                'status' => 'pending',
                'cover_letter' => 'Saya sangat tertarik dengan posisi ini dan memiliki pengalaman yang relevan.',
                'cv_file' => 'cv_john_doe.pdf',
                'employer_notes' => null,
                'interview_status' => 'not_scheduled',
                'interview_date' => null,
            ],
            [
                'job_id' => 2,
                'slug' => 'app-' . substr(md5('2-2'), 0, 8),
                'employee_id' => 2,
                'applied_at' => $now->subDays(7),
                'status' => 'reviewed',
                'cover_letter' => 'Pengalaman saya di bidang data analysis membuat saya kandidat yang cocok.',
                'cv_file' => 'cv_sari_putri.pdf',
                'employer_notes' => 'Kandidat menunjukkan potensi yang bagus.',
                'interview_status' => 'scheduled',
                'interview_date' => $now->addDays(3),
            ],
            [
                'job_id' => 2,
                'slug' => 'app-' . substr(md5('2-1'), 0, 8),
                'employee_id' => 1,
                'applied_at' => $now->subDays(20),
                'status' => 'rejected',
                'cover_letter' => 'Berharap bisa berkontribusi dalam tim Anda.',
                'cv_file' => 'cv_john_doe.pdf',
                'employer_notes' => 'Tidak memenuhi kriteria teknis.',
                'interview_status' => 'not_scheduled',
                'interview_date' => null,
            ],
        ];

        DB::table('job_applications')->insert($applications);

        
    }
}
