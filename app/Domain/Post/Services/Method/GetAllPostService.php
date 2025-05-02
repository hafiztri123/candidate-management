<?php

namespace App\Domain\Post\Services\Method;

use App\Domain\Post\Repositories\EloquentPostRepository;

class GetAllPostService
{
    public function __construct(
        private EloquentPostRepository $postRepository
    )
    {

    }

    public function getAllPost(string $departmentId)
    {
        return $this->postRepository->getAllPostByDepartmentId($departmentId);
    }
}
