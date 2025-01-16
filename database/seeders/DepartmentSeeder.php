<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
            'name' => 'web development',
            'created_at' => now(),
            'updated_at' => now()
            ],
            [
            'name' => 'mobile app development',
            'created_at' => now(),
            'updated_at' => now()
            ],
            [
            'name' => 'HR',
            'created_at' => now(),
            'updated_at' => now()
            ],
            [
            'name' => 'call center',
            'created_at' => now(),
            'updated_at' => now()
            ],
        ];

        Department::upsert($departments, ['name'], ['created_at', 'updated_at']);
    }
}
