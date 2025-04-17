<?php

namespace App\Domain\User\Controllers;

use App\Domain\User\Resources\UserResource;
use App\Domain\User\Services\UserInformationService;
use App\Domain\User\Services\UserService;
use App\Shared\Controllers\Controller;
use App\Shared\Traits\ApiRespond;

class UserController extends Controller
{
    use ApiRespond;

    public function __construct(
        private UserService $userSevice
    )
    {

    }

    public function me()
    {
        $information = $this->userSevice->me();
        return $this->successResponse(data: new UserResource($information));

    }
}
