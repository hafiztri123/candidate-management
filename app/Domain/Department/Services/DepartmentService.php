<?php

namespace App\Domain\Department\Services;

use App\Domain\Department\Repositories\EloquentDepartmentRepository;
use App\Domain\Department\Services\Method\CreateDepartmentService;
use App\Domain\Department\Services\Method\DepartmentCreationService;
use App\Domain\Department\Services\Method\DepartmentListService;

class DepartmentService
{
    public function __construct(
        private DepartmentCreationService $departmentCreationService,
        private DepartmentListService $departmentListService
    )
    {

    }

    public function create(array $data)
    {
        return $this->departmentCreationService->create($data);
    }

    public function getAllDepartments()
    {
        return $this->departmentListService->getAllDepartments();
    }

}
