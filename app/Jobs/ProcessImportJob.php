<?php

namespace App\Jobs;

use App\Jobs\EmployeesImport\ProcessEmployeeImportJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessImportJob implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    public $timeout = 1200;
    /**
     * Create a new job instance.
     */
    public function __construct(private string $filePath)
    {
        
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $fieldMap = [
            'id' => 0,
            'first_name' => 1,
            'last_name' => 2,
            'email' => 3,
            'phone_number' => 4,
            'position' => 5,
            'hire_date' => 6,
            'salary' => 7,
            'status' => 8,
            'department' => 9,
        ];

        $fileStream = fopen($this->filePath, 'r');

        $skipHeader = true;

        while (($line = fgetcsv(stream: $fileStream)) !== false) {
            if ($skipHeader) {
                $skipHeader = false;
                continue;
            }
            dispatch(new ProcessEmployeeImportJob($line, $fieldMap))->onQueue('importProcess');
        }
    }
}
