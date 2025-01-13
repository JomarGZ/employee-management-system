<?php

namespace App\Http\Controllers;

use App\Jobs\EmployeesImport\ProcessEmployeeImportJob;
use App\Jobs\ProcessImportJob;
use App\Models\Employee;
use App\Rules\EmployeeImportCsvRule;
use DateTime;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Spatie\SimpleExcel\SimpleExcelReader;

class EmployeeImportController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'csv_file' => ['required', 'file', 'mimes:csv'],
        ]);
        $file = $request->file('csv_file');

        $file = $file->storeAs('imports', $file->getClientOriginalName(), 'public');
        $filePath = storage_path("app/public/{$file}");
        
        throw_unless(file_exists($filePath),  new FileNotFoundException('File not found'));
        
        dispatch(new ProcessImportJob($filePath))->onQueue('import');
       
        return back()->with('status', 'Import process started');
    }
}
