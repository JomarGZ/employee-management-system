<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            DepartmentSeeder::class,
        ]);
        User::create([
            'first_name' => 'HR',
            'last_name' => 'Manager',
            'email' => 'hr@manager.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ]);
    }
}
