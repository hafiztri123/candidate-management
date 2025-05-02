<?php

namespace App\Domain\Post\Services;

use App\Domain\Post\Services\Method\CreatePostService;
use App\Domain\Post\Services\Method\GetAllPostService;
use Illuminate\Support\Facades\Auth;

class PostService
{
    public function __construct(
        private CreatePostService $createPostService,
        private GetAllPostService $getAllPostService
    )
    {

    }

    public function createPost(array $data)
    {
        return $this->createPostService->createPost($data);
    }

    public function getAllPost()
    {
        $user = Auth::user();
        $departmentId = $user->department_id;

        return $this->getAllPostService->getAllPost($departmentId);
    }
}
