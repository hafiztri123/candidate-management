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

    public function findById(string $id)
    {
        return Department::find($id);
    }

    public function departmentsExistsById(array $departmentsId)
    {
        $existingCount = Department::whereIn('id', $departmentsId)->count();
        return $existingCount === count($departmentsId);
    }
}
