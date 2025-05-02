<?php

namespace App\Domain\Department\Services\Method;

use App\Domain\Department\Repositories\EloquentDepartmentRepository;
use App\Domain\User\Repositories\EloquentUserRepository;
use Illuminate\Support\Facades\Auth;

class DepartmentAssignService
{
    public function __construct(
        private EloquentUserRepository $userRepository
    )
    {

    }
    public function assignDepartment(string $departmentId)
    {
        $user = Auth::user();
        $user->department_id = $departmentId;
        $this->userRepository->save($user);
    }
}
