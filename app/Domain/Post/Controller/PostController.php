<?php

namespace App\Domain\Post\Controller;

use App\Domain\Post\Request\CreatePostRequest;
use App\Domain\Post\Services\PostService;
use App\Shared\Controllers\Controller;
use App\Shared\Traits\ApiRespond;
use Illuminate\Http\Response;

class PostController extends Controller
{
    use ApiRespond;

    public function __construct(
        private PostService $postService

    )
    {

    }

    public function createPost(CreatePostRequest $request)
    {
        $data = $request->validated();
        $this->postService->createPost($data);
        return $this->successResponse("post created", Response::HTTP_CREATED);
    }

    public function getPosts()
    {
        $data = $this->postService->getAllPost();
        return $this->successResponse(data: $data);
    }
}
