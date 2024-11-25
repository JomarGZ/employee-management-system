<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employeeImagePath = storage_path('app/public/employee_images');
        if (File::exists($employeeImagePath)) {
            File::deleteDirectory($employeeImagePath);
        }
        if (!file_exists($employeeImagePath)) {
            mkdir($employeeImagePath, 0777, true);
        }
         

        Employee::factory(20)->create();
    }
}
