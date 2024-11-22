<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Resources\DepartmentResource;
use App\Http\Resources\EmployeeResource;
use App\Models\Department;
use App\StatusesEnum;
use Inertia\Inertia;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::with('department')->latest()->paginate(10);
        return Inertia::render('Employees/Index', [
            'employees' => fn () => EmployeeResource::collection($employees),
            'departments' => fn () => DepartmentResource::collection(Department::select('id', 'name')->get()),
            'statuses' => fn () => StatusesEnum::cases()
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
        return Inertia::render('Employees/Show', compact($employee));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreEmployeeRequest $request, Employee $employee)
    {
        $employee->update($request->validated());

        return to_route('employees.show', compact($employee))
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
