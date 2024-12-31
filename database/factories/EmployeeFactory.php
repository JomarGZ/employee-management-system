<?php

namespace Database\Factories;

use App\Models\Department;
use App\StatusesEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use function PHPUnit\Framework\directoryExists;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    protected static $shouldConfigure = true;

    public static function skipConfiguration()
    {
        static::$shouldConfigure = false;
    }
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
            'image_url' => null,
            'salary' => fake()->numberBetween(30000, 150000),
            'hire_date' => fake()->dateTimeBetween('-20 years', 'now'),
            'email' => fake()->unique()->userName() . Str::uuid() . '@example.com',
            'department_id' => $departments->random(),
            'status' => fake()->randomElement(StatusesEnum::cases()),
            'phone_number' => fake()->phoneNumber(),
        ];
    }
   
}
