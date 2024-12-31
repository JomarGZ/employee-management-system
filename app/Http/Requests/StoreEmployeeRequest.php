<?php

namespace App\Http\Requests;

use App\Models\Department;
use App\Models\Employee;
use App\StatusesEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                Rule::unique(Employee::class, 'email')
            ],
            'phone_number' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'hire_date' => ['required'],
            'salary' => ['required'],
            'image_url' => ['required', 'image', 'mimes:png,jpg'],
            'status' => ['required', Rule::enum(StatusesEnum::class)],
            'department_id' => ['required', Rule::exists(Department::class, 'id')],
        ];
    }
}
