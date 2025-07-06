<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeskillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Contoh data dummy
        $employeeSkills = [
            ['employee_id' => 1, 'skill_id' => 1],
            ['employee_id' => 1, 'skill_id' => 2],
            ['employee_id' => 2, 'skill_id' => 1],
            ['employee_id' => 2, 'skill_id' => 3],
            ['employee_id' => 2, 'skill_id' => 2],
            // Tambahkan data sesuai kebutuhan
        ];

        DB::table('employee_skill')->insert($employeeSkills);
    }
}
