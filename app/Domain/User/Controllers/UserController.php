<?php

namespace App\Domain\User\Controllers;

use App\Domain\User\Resources\UserResource;
use App\Domain\User\Services\UserInformationService;
use App\Shared\Controllers\Controller;
use App\Shared\Traits\ApiRespond;

class UserController extends Controller
{
    use ApiRespond;

    public function __construct(
        private UserInformationService $userInformationService
    )
    {

    }

    public function me()
    {
        $information = $this->userInformationService->me();
        return $this->successResponse(data: new UserResource($information));

    }
}
