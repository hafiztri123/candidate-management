<?php

namespace App\Domain\Department\Controller;

use App\Domain\Department\Requests\DepartmentCreationRequest;
use App\Domain\Department\Services\DepartmentService;
use App\Shared\Controllers\Controller;
use App\Shared\Traits\ApiRespond;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DepartmentController extends Controller
{
    use ApiRespond;

    public function __construct(
        private DepartmentService $departmentService
    )
    {

    }

    public function createDepartment(DepartmentCreationRequest $request)
    {
        $data = $request->validated();
        $this->departmentService->create($data);
        return $this->successResponse('OK', Response::HTTP_CREATED);
    }

    public function getAllDepartments(Request $request)
    {
        $data = $this->departmentService->getAllDepartments();
        return $this->successResponse(data: $data);
    }
}
