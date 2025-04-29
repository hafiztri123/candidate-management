<?php

namespace App\Domain\User\Services\Method;

use App\Domain\User\Exceptions\UserNotFoundException;
use App\Domain\User\Models\User;
use App\Domain\User\Repositories\EloquentUserRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserDeleteService
{
    public function __construct(
        private EloquentUserRepository $userRepository
    )
    {

    }

    public function deleteUser(string $id)
    {
        try {
            DB::transaction(function () use ($id) {
                $user = $this->findUserById($id);
                $this->userRepository->delete($user);
            });
        } catch (UserNotFoundException $e) {
            throw $e;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }

    }

    private function findUserById(string $id)
    {
        $user = $this->userRepository->findById($id);
        if (!$user) {
            throw new UserNotFoundException(userId: $id);
        }

        return $user;
    }

}
