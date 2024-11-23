<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Resources\DepartmentResource;
use App\Http\Resources\EmployeeResource;
use App\Models\Department;
use App\StatusesEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

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
}
