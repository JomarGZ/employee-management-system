<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    /** @use HasFactory<\Database\Factories\EmployeeFactory> */
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'status',
        'email',
        'position',
        'salary',
        'department_id',
        'phone_number',
        'hire_date',
    ];

    public function department() 
    {
        return $this->belongsTo(Department::class);
    }
}
