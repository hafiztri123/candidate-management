<?php

namespace App\Domain\User\Services;

use App\Domain\Role\Exceptions\RoleNotFoundExceptions;
use APp\Domain\Role\Repositories\EloquentRoleRepository;
use App\Domain\User\Events\UserCreatedEvent;
use App\Domain\User\Exceptions\UserAlreadyExists;
use App\Domain\User\Exceptions\UserAlreadyExistsException;
use App\Domain\User\Exceptions\UserCreationException;
use App\Domain\User\Exceptions\UserRegistrationDataMissingException;
use App\Domain\User\Models\User;
use App\Domain\User\Repositories\EloquentUserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

/*******************
 *
 *
 * *Purpose: membuat model user dan memasukkan ke database
 * *Model:  User
 *
 *
 *
 *******************/

class UserCreationService
{

    /*******************
     *
     * TODO: ganti kelas konkrit dengan interface
     *
     *******************/

    public function __construct(
        private EloquentUserRepository $userRepository,
        private EloquentRoleRepository $roleRepository
    )
    {

    }

    public function create(array $data)
    {
        try{

            $this->isDataValid($data);
            $this->hasUserAlreadyExisted($data['email']);
            $user = $this->createUserModel($data);

            DB::transaction(function() use ($user){
                $this->userRepository->save($user);
                DB::afterCommit(function() use ($user) {
                    $this->attachRoleUser($user);
                });
            });

        } catch (UserRegistrationDataMissingException | UserAlreadyExistsException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new UserCreationException(customMessage: $e->getMessage() ?: 'An error has occured during user creation');
        }
    }

    private function hasUserAlreadyExisted(string $email)
    {
        $user = $this->userRepository->findByEmail($email);
        if ($user){
            throw new UserAlreadyExistsException(customMessage: "User with $email already exists");
        }
        return $user;
    }

    private function createUserModel(array $data)
    {
        $encrpytedPassword = $this->encryptPassword($data['password']);

        return User::make([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $encrpytedPassword
        ]);
    }

    private function encryptPassword(string $password)
    {
        return Hash::make($password);
    }

    private function isDataValid(array $data)
    {
        $errors = [];

        if(empty($data)){
            $errors['form'] = 'Form is empty';
            return $errors;
        }

        if (empty($data['name']) || !isset($data['name'])) {
            $errors['name'] = 'Name is empty or  not valid';
        }

        if (empty($data['email']) || !isset($data['email']) ) {
            $errors['email'] = 'Email is empty or not valid';
        }

        if (empty($data['password']) || !isset($data['password'])) {
            $errors['password'] = 'Password is empty or not valid';
        }

        if(!empty($errors)){
            throw new UserRegistrationDataMissingException("Missing required data", $errors);
        }
    }

    private function attachRoleUser(User $user)
    {
        $roleUser = $this->roleRepository->findBySlug('user');
        if(!$roleUser){
            throw new RoleNotFoundExceptions(customMessage: 'Role User not found');
        }

        UserCreatedEvent::dispatch($user, $roleUser);


    }
}
