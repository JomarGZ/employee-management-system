<?php

namespace App\Jobs\EmployeesImport;

use App\Models\Department;
use App\Models\Employee;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessEmployeeImportJob implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private array $dataLine, private array $fieldMap)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $department = Department::firstOrCreate(
            [
                'name' => $this->dataLine[$this->fieldMap['department']],
            ],
            [
                'name' => $this->dataLine[$this->fieldMap['department']],
            ],
        );

        try {
            Employee::updateOrCreate(
                [
                    'email' => $this->dataLine[$this->fieldMap['email']],
                ],
                [
                    'first_name' => $this->dataLine[$this->fieldMap['first_name']],
                    'department_id' => $department->id,
                    'last_name' => $this->dataLine[$this->fieldMap['last_name']],
                    'phone_number' => $this->dataLine[$this->fieldMap['phone_number']],
                    'position' => $this->dataLine[$this->fieldMap['position']],
                    'salary' => $this->dataLine[$this->fieldMap['salary']],
                    'hire_date' => $this->dataLine[$this->fieldMap['hire_date']],
                    'status' => $this->dataLine[$this->fieldMap['status']],
                ]
            );
        } catch (Exception $e) {
            Log::error($e->getMessage());
            Log::info('Error processing employee import');
        }
    }
}
