<?php

namespace App\Domain\User\Services\Method;

use App\Domain\User\Repositories\EloquentUserRepository;
use Illuminate\Support\Facades\Auth;

class UserInformation
{
    public function __construct(
        private EloquentUserRepository $userRepository
    ) { }

    public function me()
    {
        $user = $this->userRepository->findByIdWithRoles(Auth::id());
        return $user;
    }
}
