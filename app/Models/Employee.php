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
        'image_url',
        'thumbnail_50_image_url'
    ];

    public function department() 
    {
        return $this->belongsTo(Department::class);
    }

    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function scopeSearch($query, $terms = null)
    {
        $query->when($terms, function ($query) use ($terms) {
            collect(str_getcsv( $terms, ' ', '"'))->filter()->each(function ($term) use ($query) {
                $term = "{$term}%";
                $query->whereIn('id', function ($query) use ($term) {
                    $query->select('id')
                        ->from(function ($query) use ($term) {
                            $query->select('id')
                                ->from('employees')
                                ->where('first_name', 'like', $term)
                                ->orWhere('last_name', 'like', $term)
                                ->union(
                                    $query->newQuery()
                                        ->select('employees.id')
                                        ->from('employees')
                                        ->join('departments', 'departments.id', '=', 'employees.department_id')
                                        ->where('departments.name', 'like', $term)
                                );
                        }, 'matches');
                });
            });
        });
      
    }

    public function scopeFilterByDepartment($query, $departmentId)
    {
        return $query->when($departmentId, function ($query, $departmentId) {
            $query->where('department_id', $departmentId);
        });
    }

    public function scopeFilterByStatus($query, $status)
    {
        return $query->when($status, function ($query, $status) {
            $query->where('status', $status);
        });
    }
}
