<?php

namespace App\Domain\Department\Repositories;

use App\Domain\Department\Model\Department;

class EloquentDepartmentRepository
{
    public function getAllDepartments()
    {
        return Department::all();
    }

    public function saveDepartment(Department $department)
    {
        $department->save();
    }
}
