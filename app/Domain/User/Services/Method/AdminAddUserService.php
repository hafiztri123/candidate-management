<?php

namespace App\Domain\User\Services\Method;

use App\Domain\Department\Exception\DepartmentNotFoundException;
use App\Domain\Department\Repositories\EloquentDepartmentRepository;
use App\Domain\Role\Exceptions\RoleNotFoundExceptions;
use APp\Domain\Role\Repositories\EloquentRoleRepository;
use App\Domain\User\Events\UserCreatedEvent;
use App\Domain\User\Exceptions\UserAlreadyExistsException;
use App\Domain\User\Exceptions\UserDataMissingException;
use App\Domain\User\Models\User;
use App\Domain\User\Repositories\EloquentUserRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminAddUserService
{
    public function __construct(
        private EloquentUserRepository $userRepository,
        private EloquentDepartmentRepository $departmentRepository,
        private EloquentRoleRepository $roleRepository
    )
    {

    }

    public function addUser(array $data)
    {
        try {
            $this->isUserDataMissing($data);
            if($this->isUserExists($data['email'])){
                throw new UserAlreadyExistsException();
            }

            $this->isDepartmentExists($data['department_id']);

            $user = $this->makeUser($data);
            DB::transaction(function () use ($user) {
                $this->userRepository->save($user);
                DB::afterCommit(function () use ($user){
                    $this->attachRoleToUser($user);
                });

            });


        } catch (UserDataMissingException | DepartmentNotFoundException | RoleNotFoundExceptions $e) {
            throw $e;
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

    }

    private function isUserDataMissing(array $data)
    {
        $errors = [];

        if(empty($data)){
            $errors['data'] = 'Required data is missing';
        }

        if(empty($data['name'] || !isset($data['name']))) {
            $errors['name'] = 'Name is missing';
        }

        if (empty($data['email'] || !isset($data['email']))) {
            $errors['email'] = 'email is missing';
        }

        if (empty($data['password'] || !isset($data['password']))) {
            $errors['password'] = 'password is missing';
        }

        if (count($errors) > 0) {
            throw new UserDataMissingException('Required data is missing', $errors);
        }
    }

    private function isUserExists(string $email)
    {
        $user = $this->userRepository->findByEmail($email);
        return !!$user;
    }

    private function isDepartmentExists(string $departmentId)
    {
        $department = $this->departmentRepository->findById($departmentId);
        if(!$department){
            throw new DepartmentNotFoundException($departmentId);
        }

        return true;
    }

    private function makeUser(array $data)
    {
        return User::make([
            'name' => $data['name'],
            'email' => $data['email'],
            'department_id' => $data['department_id'],
            'password' => Hash::make($data['password'])
        ]);
    }

    private function attachRoleToUser(User $user)
    {
        $roleUser = $this->roleRepository->findBySlug('user');
        if (!$roleUser) {
            throw new RoleNotFoundExceptions(customMessage: 'Role User not found');
        }

        UserCreatedEvent::dispatch($user, $roleUser);
    }

}
