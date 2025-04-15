<?php

namespace App\Domain\User\Services;

use App\Domain\User\Exceptions\InvalidCredentialsException;
use App\Domain\User\Exceptions\UserNotFoundException;
use App\Domain\User\Exceptions\UserTokenLoginException;
use App\Domain\User\Models\User;
use App\Domain\User\Repositories\EloquentUserRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserTokenLoginService
{
    public function __construct(
        private EloquentUserRepository $userRepository
    )
    {

    }
    public function login(array $data)
    {
        try{
            $user = $this->getUserByEmail($data['email']);
            $this->validateCredential($user, $data['password']);
            return $this->createToken($user);

        } catch (UserNotFoundException | InvalidCredentialsException $e){
            throw $e;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw new UserTokenLoginException(customMessage: $e->getMessage() ?: 'An error has occured during user login attempt');
        }





    }

    private function getUserByEmail(string $email)
    {
        $user = $this->userRepository->findByEmail($email);

        if (!$user) {
            $message = "User with email: $email  not found";
            throw new UserNotFoundException($message);
        }
        return $user;
    }

    private function validateCredential(User $user, string $password){
        if(!Hash::check($password, $user->password)){
            throw new InvalidCredentialsException();
        }
    }

    private function createToken(User $user)
    {
        return $user->createToken('api-token')->plainTextToken;
    }

}
