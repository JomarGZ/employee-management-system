<?php

namespace Database\Factories;

use App\Models\Department;
use App\StatusesEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use function PHPUnit\Framework\directoryExists;

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
            'salary' => fake()->numberBetween(30000, 150000),
            'hire_date' => fake()->dateTimeBetween('-20 years', 'now'),
            'email' => fake()->unique()->safeEmail(),
            'department_id' => $departments->random(),
            'status' => fake()->randomElement(StatusesEnum::cases()),
            'phone_number' => fake()->phoneNumber(),
        ];
    }

    
    public function configure()
    {
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
                
                // Update filename in database
                $employee->image_url = $fileName;
                $employee->save();

                // Generate and save thumbnail
                $thumbnailDirectory = "{$employeeDirectory}";
                if (!file_exists($thumbnailDirectory)) {
                    mkdir($thumbnailDirectory, 0755, true);
                }
                
                $thumb = fake()->image($thumbnailDirectory, 60, 60, null, false, false);
               
                $thumbnailPath = "{$employeeDirectory}/$thumb";
                if (directoryExists($thumbnailPath)) {
                    
                    $newThumbName = $employeeDirectory . DIRECTORY_SEPARATOR . 'thumbnail_60_' . $fileName;
                    
                    // If a file with the new name already exists, delete it first
                    if (file_exists($newThumbName)) {
                        unlink($newThumbName);
                    }
                    
                    // Rename the thumbnail
                    rename($thumbnailPath, $newThumbName);
                }
            } catch (\Exception $e) {
                // Log the error for debugging
                \Log::error('Error in EmployeeFactory: ' . $e->getMessage());
                throw $e;
            }
        });
    }
}
