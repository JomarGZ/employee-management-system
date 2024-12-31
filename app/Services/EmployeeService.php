<?php
namespace App\Services;

use App\Models\Employee;

class EmployeeService {

    public function getStatusesCounts()
    {
        return Employee::toBase()
            ->selectRaw("count(case when status = 'active' then 1 end) as active")
            ->selectRaw("count(case when status = 'inactive' then 1 end) as inactive")
            ->selectRaw("count(case when status = 'onboarding' then 1 end) as onboarding")
            ->selectRaw("count(case when status = 'on leave' then 1 end) as on_leave")
            ->first();
    }

}