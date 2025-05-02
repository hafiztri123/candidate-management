<?php

namespace App\Domain\Post\Repositories;

use App\Domain\Department\Model\Department;
use App\Domain\Post\Model\Post;

class EloquentPostRepository
{
    public function getAllPostByDepartmentId(string $departmentId)
    {
        return Post::where('visibility', 'all_employees')
            ->orWhereHas('departments', function ($query) use ($departmentId) {
                $query->where('departments.id', $departmentId);
            })->get();
    }


    public function save(Post $post)
    {
        $post->save();
    }
}
