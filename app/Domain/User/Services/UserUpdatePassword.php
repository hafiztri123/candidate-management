<?php

namespace App\Domain\User\Services;

use App\Domain\User\Exceptions\PasswordNotValidException;
use App\Domain\User\Exceptions\UserNotFoundException;
use App\Domain\User\Repositories\EloquentUserRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserUpdatePassword
{
    public function __construct(
        private EloquentUserRepository $userRepository
    )
    {
    }

    public function updatePassword(string $id, string $password)
    {
        try{
            $this->validatePassword($password);

            DB::transaction(function () use ($password, $id) {
                $user = $this->findUserById($id);
                $user->password = Hash::make($password);
                $this->userRepository->save($user);
            });
        } catch (PasswordNotValidException $e) {
            throw $e;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }

    }

    private function findUserById(string $id)
    {
        $user = $this->userRepository->findById($id);
        if (!$user){
            throw new UserNotFoundException($id);
        }
        return $user;
    }

    private function validatePassword(string $password)
    {
        $errors = [];

        if(!$password) {
            $errors['password'] = 'Password is empty';
        }

        if(strlen($password) < 8) {
            $errors['min_password_length'] = 'Password less than 8 characters';
        }

        if (strlen($password) >  64) {
            $errors['max_password_length'] = 'Password more than 64 characters';
        }

        if(count($errors) > 0){
            throw new PasswordNotValidException($errors);
        }

        return true;
    }
}
