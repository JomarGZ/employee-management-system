<?php

namespace Database\Seeders;

use App\Models\Employee;
use Database\Factories\EmployeeFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\LazyCollection;
use function Laravel\Prompts\progress;

class EmployeeTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmployeeFactory::skipConfiguration();

        $progress = progress('Creating employee', 1_000_000);
        $progress->start();
        LazyCollection::times(5000)->each(function () use ($progress) {
            Employee::factory(200)->create();

            $progress->advance(200);
        });

        $progress->finish();
    }

}
  