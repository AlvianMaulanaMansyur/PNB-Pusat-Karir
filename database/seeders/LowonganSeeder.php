<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LowonganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::job_listings()->insert([
            [
                'slug' => 'software-engineer',
                'employer_id' => 1,
                'nama_lowongan' => 'Software Engineer',
                'deskripsi' => 'We are looking for a Software Engineer to join our team.',
                'posisi' => 'Full-time',
                'kualifikasi' => 'Bachelor\'s degree in Computer Science or related field.',
                'jenislowongan' => 'Permanent',
                'deadline' => now()->addDays(30),
                'poster' => 'poster1.jpg',
            ],
            [
                'slug' => 'data-analyst',
                'employer_id' => 2,
                'nama_lowongan' => 'Data Analyst',
                'deskripsi' => 'Join us as a Data Analyst to help us make data-driven decisions.',
                'posisi' => 'Part-time',
                'kualifikasi' => 'Experience with data analysis tools and techniques.',
                'jenislowongan' => 'Contract',
                'deadline' => now()->addDays(45),
                'poster' => 'poster2.jpg',
            ],
        ]);
    }
}
