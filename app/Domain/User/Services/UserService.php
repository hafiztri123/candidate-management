<?php

namespace App\Domain\User\Services;

use App\Domain\User\Services\Method\UserInformation;
use App\Domain\User\Services\Method\UserLogout;
use App\Domain\User\Services\Method\UserRegistration;
use App\Domain\User\Services\Method\UserTokenBasedLogin;
use Illuminate\Http\Request;

class UserService
{
    public function __construct(
        private UserInformation $userInformation,
        private UserRegistration $userRegistration,
        private UserTokenBasedLogin $userTokenBasedLogin,
        private UserLogout $userLogout
    ) {  }

    public function me()
    {
        return $this->userInformation->me();
    }

    public function register(array $data)
    {
        return $this->userRegistration->register($data);
    }

    public function tokenBasedLogin(array $data)
    {
        return $this->userTokenBasedLogin->login($data);
    }

    public function logout(Request $request)
    {
        return $this->userLogout->logout($request);
    }


}
