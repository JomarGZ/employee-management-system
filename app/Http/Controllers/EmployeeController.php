<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Resources\DepartmentResource;
use App\Http\Resources\EmployeeResource;
use App\Models\Department;
use App\Rules\EmployeeImportCsvRule;
use App\StatusesEnum;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Spatie\SimpleExcel\SimpleExcelReader;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        
        $employees = Employee::query()
            ->select([
                'id', 
                'department_id',
                'first_name',
                'last_name',
                'status',
                'email',
                'salary',
                'image_url'
            ])
            ->with('department')
            ->search($search)
            ->filterByDepartment($request->query('department_id'))
            ->filterByStatus($request->query('status'))
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return Inertia::render('Employees/Index', [
            'employees' => fn () => EmployeeResource::collection($employees),
            'departments' => fn () => DepartmentResource::collection(Department::select('id', 'name')->get()),
            'statuses' => fn () => StatusesEnum::cases(),
            'filters' => [
                'search' => $search
            ]
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        $validated = $request->validated();
        $employee = Employee::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
            'department_id' => $validated['department_id'],
            'position' => $validated['position'],
            'hire_date' => $validated['hire_date'],
            'salary' => $validated['salary'],
            'status' => $validated['status'],
        ]);
      
        if ($request->hasFile('image_url')) {
            $file = $request->file('image_url');
            $fileName = $file->getClientOriginalName();

            $file->storeAs('employee_images/' . $employee->id,  $fileName, 'public');
            $imageManager = new ImageManager(Driver::class);

            $imagePath = storage_path('app/public/employee_images/' . $employee->id . '/' . $fileName);
            if (file_exists($imagePath)) {
                $image = $imageManager->read($imagePath);
                $image->resize(60, 60);
                $thumbPath = storage_path('app/public/employee_images/' . $employee->id . '/thumbnail_60_' . $fileName);
                $image->save($thumbPath);
            }
            $employee->image_url = $fileName;
            $employee->save();
        }

        return to_route('employees.index')->with('message', 'Successfully added employee');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        $employee = EmployeeResource::make($employee->load('department'));   
        return Inertia::render('Employees/Show', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {

        $validated = $request->validated();
        $employee->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
            'department_id' => $validated['department_id'],
            'position' => $validated['position'],
            'hire_date' => $validated['hire_date'],
            'salary' => $validated['salary'],
            'status' => $validated['status'],
        ]);

        if ($request->hasFile('image_url')) {
            Storage::disk('public')->delete('employee_images/' . $employee->id . '/*');
            $file = $request->file('image_url');

            $fileName = $file->getClientOriginalName();
        }
        return to_route('employees.show', compact('employee'))
            ->with('message', 'Successfully updated employee information');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return to_route('employees.index')->with('message', 'Successfully deleted');
    }


    public function exportCSV()
    {
        try {
            if (!Storage::disk('public')->exists('exports')) {
                Storage::disk('public')->makeDirectory('exports');
            }
            $filename = 'export_employees_' . date('Y-m-d_His') . '.csv';
            $filepath = storage_path('app/public/exports/' . $filename);
            $createInitialCsvFile = fopen($filepath, 'w');

            if ($createInitialCsvFile === false) {
                throw new Exception("Unable to create file: $filepath");
            }

    
            $headers = ['ID', 'FIRST NAME', 'LAST NAME', 'EMAIL', 'PHONE NUMBER', 'POSITION', 'HIRE DATE', 'SALARY', 'STATUS', 'DEPARTMENT', 'DATE OF INPUT', 'DATE OF UPDATED INPUT'];
            fputcsv($createInitialCsvFile, $headers);
    
            Employee::select(['id', 'first_name', 'last_name', 'email', 'phone_number', 'salary', 'position', 'department_id', 'status', 'hire_date', 'created_at', 'updated_at'])
                ->with('department:id,name')
                ->chunk(2000, function ($employees) use ($createInitialCsvFile) {
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
                            $employee->department->name,
                            $employee->created_at,
                            $employee->created_at,
                        ];
    
                        if (fputcsv($createInitialCsvFile, $row) === false) {
                            throw new Exception('Failed to write CSV row');
                        }
                    }
                });
    
            fclose($createInitialCsvFile);
                  // Check if file exists and is readable
            if (!Storage::disk('public')->exists('exports/' . $filename)) {
                throw new Exception('Export file not found');
            }
            return Storage::disk('public')->download('exports/' . $filename);
        } catch (Exception $e) {
            info("Error on exportin employee CSV $e");
            if (isset($filepath) && file_exists($filepath)) {
                unlink($filepath);
            }
            return response()->json([
                'message' => 'Failed to export CSV',
                'error' => $e->getMessage()
            ], 500);
        }
      
    }

    public function importCSV(Request $request)
    {
        $requiredHeaders = [
            'first name',
            'last name',
            'email',
            'status',
            'position',
            'phone number',
            'hire date',
            'salary',
        ];

        $request->validate([
            'csv_file' => ['required', 'file', 'mimes:csv', 'max:10240', new EmployeeImportCsvRule($requiredHeaders)]
        ]);

        SimpleExcelReader::create($request->file('csv_file'), 'csv')
            ->useHeaders([
                'id',
                'first_name',
                'last_name',
                'email',
                'phone_number',
                'position',
                'hire_date',
                'salary',
                'status'
            ])
            ->getRows()
            ->each(function (array $row) {
                $reformattedRow = [
                    'first_name' => $row['first_name'],
                    'last_name' => $row['last_name'],
                    'email' => $row['email'],
                    'phone_number' => $row['phone_number'],
                    'position' => $row['position'],
                    'hire_date' => (new DateTime($row['hire_date']))->format('Y-m-d'),
                    'salary' => $row['salary'],
                    'status' => $row['status'],
                ];
        
                Employee::upsert(
                    $reformattedRow,
                    ['first_name', 'last_name'],  // Unique identifier columns
                    ['email', 'status', 'position']  // Columns to update if record exists
                );
        
            });

        return back();
    }

}
