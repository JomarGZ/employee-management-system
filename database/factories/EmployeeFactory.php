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

    
    public function configure()
    {
          // Only proceed with image configuration if it's not skipped
        if (!static::$shouldConfigure) {
            return $this;
        }
        return $this->afterCreating(function ($employee) {
            try {
                // Create base directory if it doesn't exist
                $baseDirectory = storage_path('app/public/employee_images');
                if (!file_exists($baseDirectory)) {
                    mkdir($baseDirectory, 0755, true);
                }

                // Create employee directory
                $employeeDirectory = "{$baseDirectory}/{$employee->id}";
                if (!file_exists($employeeDirectory)) {
                    mkdir($employeeDirectory, 0755, true);
                }
                // Generate and save original image
                $fileName = fake()->image($employeeDirectory, 300, 300, null, false, false);
                if (!$fileName) {
                    return $this;
                }
                // Update filename in database
                $employee->image_url = $fileName;
                $employee->save();
                info($fileName);
                $fullImagePath = $employeeDirectory . '/' . $fileName;
                if (file_exists($fullImagePath)) {
                    $thumbnailFileName = storage_path('app/public/employee_images/' . $employee->id . '/thumbnail_60_' . $fileName);
                  
                    $manager = new ImageManager(Driver::class);
                    $image = $manager->read($fullImagePath);
                    $image->resize(60, 60);
                    $image->save($thumbnailFileName);
                }
                 
            } catch (\Exception $e) {
                // Log the error for debugging
                \Log::error('Error in EmployeeFactory: ' . $e->getMessage());
                throw $e;
            }
        });
    }
}
