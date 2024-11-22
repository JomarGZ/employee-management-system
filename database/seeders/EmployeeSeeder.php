<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employeeImagePath = storage_path('app/public/employee_images');
        if (!file_exists($employeeImagePath)) {
            mkdir($employeeImagePath, 0777, true);
        }
        array_map('unlink', glob($employeeImagePath . "/*"));

        Employee::factory(20)->create();
    }
}
