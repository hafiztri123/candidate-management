<?php

namespace App\Domain\User\Controllers;

use App\Domain\User\Requests\AddUserRequest;
use App\Domain\User\Resources\GetAllUserResourceCollection;
use App\Domain\User\Resources\UserResource;
use App\Domain\User\Services\UserInformationService;
use App\Domain\User\Services\UserService;
use App\Shared\Controllers\Controller;
use App\Shared\Traits\ApiRespond;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

    public function getAll(Request $request)
    {
        $criteria = $request->input('search');
        $pageSize = $request->input('size', 10);
        $data = [
            'criteria' => $criteria ?? null,
            'page_size' => $pageSize ?? 10
        ];

        $result = $this->userSevice->getAllUser($data);

        return $this->successResponse(data: new GetAllUserResourceCollection($result));
    }

    public function deleteUser(Request $request)
    {
        $userId = $request->input('user_id');
        $this->userSevice->deleteUser($userId);
        return $this->successResponse("OK", Response::HTTP_NO_CONTENT);
    }

    public function updateUserPassword(Request $request)
    {
        $request->validate([
            'password' => 'string|required|min:8|max:64'
        ]);
        $userId = $request->input('user_id');
        $userNewPassword = $request->input('password');

        $this->userSevice->updateUserPassword($userId, $userNewPassword);
        return $this->successResponse('OK', Response::HTTP_OK);
    }

    public function addUser(AddUserRequest $request)
    {
        $data = $request->validated();
        $this->userSevice->addUser($data);
        return $this->successResponse(HttpCode: Response::HTTP_CREATED);
    }


}
