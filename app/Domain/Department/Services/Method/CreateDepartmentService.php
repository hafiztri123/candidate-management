<?php

namespace App\Domain\Department\Services\Method;

use App\Domain\Department\Exceptions\MissingDepartmentDataException;
use App\Domain\Department\Model\Department;
use App\Domain\Department\Repositories\EloquentDepartmentRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateDepartmentService
{
    public function __construct(
        private EloquentDepartmentRepository $eloquentDepartmentRepository
    )
    {

    }
    public function create(array $data)
    {
        try {
            $this->isDepartmentRegistrationDataValid($data);
            $department = $this->makeDepartment($data);
            DB::transaction(function () use ($department) {
                $this->eloquentDepartmentRepository->saveDepartment($department);
            });

        } catch (MissingDepartmentDataException $e){
            throw $e;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }


    }

    private function isDepartmentRegistrationDataValid(array $data)
    {
        $errors = [];

        if(empty($data)){
            $errors['form'] = 'data is invalid';
        }

        if (empty($data['name']) || !isset($data['name'])){
            $errors['name'] = 'Name is missing';
        }

        if(!empty($errors)){
            throw new MissingDepartmentDataException(errors: $errors);
        }
    }

    private function makeDepartment(array $data)
    {
        $department = Department::make([
            'name' => $data['name'],
            'description' => $data['description'] ?? null
        ]);

        return $department;
    }
}
