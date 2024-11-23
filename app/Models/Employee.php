<?php

namespace App\Models;

use App\StatusesEnum;
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

    public function scopeSearch($query, $searchParam)
    {
        return $query->when($searchParam, function ($query, $searchParam) {
            return $query->whereAny([
                'first_name',
                'last_name',
                'email',
                'phone_number',
                'status'
            ], 'like', "%{$searchParam}%")
            ->orWhereHas('department', function ($query) use ($searchParam) {
                $query->where('name', 'like', "%{$searchParam}%");
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
