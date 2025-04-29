<?php

namespace App\Domain\User\Services\Method;

use App\Domain\User\Repositories\EloquentUserRepository;

class UserListService
{
    public function __construct(
        private EloquentUserRepository $userRepository
    )
    {

    }

    public function getAll(array $data)
    {
        return $this->userRepository->getAllUser($data['criteria'], $data['page_size']);

    }
}
