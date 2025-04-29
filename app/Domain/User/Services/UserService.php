<?php

namespace App\Domain\User\Services;

use App\Domain\User\Services\Method\UserDeleteService;
use App\Domain\User\Services\Method\UserInformationService;
use App\Domain\User\Services\Method\UserListService;
use App\Domain\User\Services\Method\UserLogoutService;
use App\Domain\User\Services\Method\UserRegistrationService;
use App\Domain\User\Services\Method\UserTokenBasedLoginService;
use Illuminate\Http\Request;

class UserService
{
    public function __construct(
        private UserInformationService $userInformation,
        private UserRegistrationService $userRegistration,
        private UserTokenBasedLoginService $userTokenBasedLogin,
        private UserLogoutService $userLogout,
        private UserListService $userList,
        private UserDeleteService $userDeleteService,
        private UserUpdatePassword $userUpdatePassword
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

    public function getAllUser(array $data)
    {
        return $this->userList->getAll($data);
    }

    public function deleteUser(string $id)
    {
        return $this->userDeleteService->deleteUser($id);
    }

    public function updateUserPassword(string $userId, string $newPassword)
    {
        return $this->userUpdatePassword->updatePassword($userId, $newPassword);
    }


}
