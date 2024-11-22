<?php

namespace Database\Factories;

use App\Models\Department;
use App\StatusesEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $departments = Department::pluck('id');
   
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'position' => fake()->jobTitle(),
            'thumbnail_300_image_url' => fake()->image(storage_path('app/public/employee_images'), 300, 300, null, false, false),
            'thumbnail_50_image_url' => fake()->image(storage_path('app/public/employee_images'), 50, 50, null, false, false),
            'salary' => fake()->numberBetween(30000, 150000),
            'email' => fake()->unique()->safeEmail(),
            'department_id' => $departments->random(),
            'status' => fake()->randomElement(StatusesEnum::cases()),
            'phone_number' => fake()->phoneNumber(),
        ];
    }
}
