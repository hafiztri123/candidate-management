<?php

namespace App\Domain\User\Controllers;

use App\Domain\User\Requests\UserCreationRequest;
use App\Domain\User\Requests\UserLoginRequest;
use App\Domain\User\Services\UserCreationService;
use App\Domain\User\Services\UserTokenLoginService;
use App\Shared\Traits\ApiRespond;
use Illuminate\Http\Response;

/*******************
 *
 *
 * *Purpose: menjadi penerima dan penerus request untuk autentikasi
 * *Model:  User
 *
 *
 *
 *******************/


class AuthController
{
    use ApiRespond;


    /*******************
     *
     * *Service: UserCreationService -> Membuat user
     *
     *******************/

    public function __construct(
        private UserCreationService $userCreationService,
        private UserTokenLoginService $userTokenLoginService
    ) { }

    public function store(UserCreationRequest $request)
    {
        $data = $request->validated();
        $this->userCreationService->create($data);
        return $this->successResponse(HttpCode: Response::HTTP_CREATED);
    }

    public function loginWithToken(UserLoginRequest $request)
    {
        $data = $request->validated();
        $token = $this->userTokenLoginService->login($data);
        return $this->successResponse(data: ['token' => $token] );
    }



}
