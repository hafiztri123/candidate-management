<?php

namespace App\Domain\User\Controllers;

use App\Domain\User\Exceptions\InvalidCredentialsException;
use App\Domain\User\Requests\UserCreationRequest;
use App\Domain\User\Requests\UserLoginRequest;
use App\Domain\User\Requests\UserRegisterRequest;
use App\Domain\User\Services\UserCreationService;
use App\Domain\User\Services\UserService;
use App\Domain\User\Services\UserTokenLoginService;
use App\Shared\Traits\ApiRespond;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

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
        private UserService $userService
    ) { }

    public function store(UserRegisterRequest $request)
    {
        $data = $request->validated();
        $this->userService->register($data);
        return $this->successResponse(HttpCode: Response::HTTP_CREATED);
    }

    public function tokenBasedLogin(UserLoginRequest $request)
    {
        $data = $request->validated();
        $token = $this->userService->tokenBasedLogin($data);
        return $this->successResponse(data: ['token' => $token] );
    }

    public function cookieBasedLogin(UserLoginRequest $request)
    {
        $request->validated();

        if (!Auth::attempt($request->only('email', 'password'))) {
                throw new InvalidCredentialsException();
        }

        $request->session()->regenerate();


        return $this->successResponse();
    }

    public function logout(Request $request)
    {
        $this->userService->logout($request);
        return $this->successResponse(HttpCode: Response::HTTP_NO_CONTENT);
    }

}
