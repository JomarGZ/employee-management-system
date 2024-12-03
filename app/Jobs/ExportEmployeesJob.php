<?php

namespace App\Jobs;

use App\Events\ExportCsvStatusUpdated;
use App\Models\Employee;
use App\Models\Export;
use App\Models\User;
use App\Notifications\ExportEmployeesCompleted;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ExportEmployeesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

   
    protected $user;
    protected $export;
    // public $timeout = 3600; // 1 hour timeout
    // public $tries = 3; // Number of retries

    public function __construct(User $user, Export $export)
    {
        $this->user = $user;
        $this->export = $export;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        
        $export = $this->exportCsvEmployeees();

     
        
        event(new ExportCsvStatusUpdated($this->user, $export));
    }
    

    public function exportCsvEmployeees()
    {
        try {
            $filepath = storage_path("app/public/exports/{$this->export->file_name}");
            

            if (!Storage::disk('public')->exists('exports')) {
                Storage::disk('public')->makeDirectory('exports');
            }

            $createCsvFile = fopen($filepath, 'w');

            if ($createCsvFile === false) {
                throw new Exception("Unable to create file: $filepath");
            }

            $headers = [
                'ID', 
                'FIRST NAME', 
                'LAST NAME', 
                'EMAIL', 
                'PHONE NUMBER', 
                'POSITION', 
                'HIRE DATE', 
                'SALARY', 
                'STATUS', 
                'DEPARTMENT', 
                'DATE OF INPUT', 
                'DATE OF UPDATED INPUT'
            ];
            fputcsv($createCsvFile, $headers);
            
            Employee::select([
                'id', 
                'first_name', 
                'last_name', 
                'email', 
                'phone_number', 
                'salary', 
                'position', 
                'department_id', 
                'status', 
                'hire_date', 
                'created_at', 
                'updated_at'
            ])
            ->with('department:id,name')
            ->chunk(2000, function ($employees) use ($createCsvFile) {
                foreach($employees as $employee) {
                 
                    $row = [
                        $employee->id,
                        $employee->first_name,
                        $employee->last_name,
                        $employee->email,
                        $employee->phone_number,
                        $employee->position,
                        $employee->hire_date,
                        $employee->salary,
                        $employee->status,
                        $employee->department?->name,
                        $employee->created_at,
                        $employee->created_at,
                    ];
                    if (fputcsv($createCsvFile, $row) === false) {
                        throw new Exception('Failed to write CSV row');
                    }
                }
            });

            fclose($createCsvFile);

            $this->export->status = "completed";
            $this->export->save();

            return $this->export;

        } catch (Exception $e) {
            if (isset($filepath) && file_exists($filepath)) {
                unlink($filepath);
            }
            
            // Log error
            \Log::error("Error exporting employee CSV: " . $e->getMessage());
            
            // Update export status if record exists
            if (isset($this->export)) {
                $this->export->update(['status' => 'failed']);
            }
            
            throw $e; // Re-throw the exception for job failure handling
        }
    }
}