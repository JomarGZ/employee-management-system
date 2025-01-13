<?php

namespace App\Http\Controllers;

use App\Events\ExportCsvStatusUpdated;
use App\Jobs\ExportEmployeesJob;
use App\Models\Export;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeesExportController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function store(Request $request)
    {
        try {
            $authUser = $request->user();
            $filename = 'export_employees_' . date('Y-m-d_His') . '.csv';
            $export = $authUser->exportFile()->create([
                'file_name' => $filename,
                'file_path' => Storage::disk('public')->url("exports/{$filename}"),
                'status' => 'pending'
            ]);
           
            event(new ExportCsvStatusUpdated($authUser, $export));

            ExportEmployeesJob::dispatch($authUser, $export);

            return response()->json([
                'message' => 'Export started. You will be notified when it\'s ready.'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to start export',
                'error' => $e->getMessage()
            ], 500);
        }
      
    }

    public function destroy(Export $export) 
    {
       
        Storage::disk('public')->when(
            Storage::disk('public')->exists("exports/{$export->file_name}"),
            fn () => Storage::disk('public')->delete("exports/{$export->file_name}")
        );
        
        $export->delete();

        return response()->json([
            'success' => true,
        'message' => 'Successfully deleted'
        ]);
    }
}
