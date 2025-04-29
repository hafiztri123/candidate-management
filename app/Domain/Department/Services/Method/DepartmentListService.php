<?php

namespace App\Domain\Department\Services\Method;

use App\Domain\Department\Repositories\EloquentDepartmentRepository;

class DepartmentListService
{
    public function __construct(
        private EloquentDepartmentRepository $departmentRepository
    )
    {


    }

    public function getAllDepartments()
    {
        return $this->departmentRepository->getAllDepartments();
    }
}
