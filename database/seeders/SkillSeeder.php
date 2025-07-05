<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $now = Carbon::now();

        $skills = [
            ['id' => 1, 'name' => 'PHP',          'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'name' => 'JavaScript',   'created_at' => $now, 'updated_at' => $now],
            ['id' => 3, 'name' => 'Laravel',      'created_at' => $now, 'updated_at' => $now],
            ['id' => 4, 'name' => 'Vue.js',       'created_at' => $now, 'updated_at' => $now],
            ['id' => 5, 'name' => 'MySQL',        'created_at' => $now, 'updated_at' => $now],
            ['id' => 6, 'name' => 'Tailwind CSS', 'created_at' => $now, 'updated_at' => $now],
            // Tambahkan skill lain sesuai kebutuhan
        ];

        DB::table('skills')->insert($skills);
    }
}
