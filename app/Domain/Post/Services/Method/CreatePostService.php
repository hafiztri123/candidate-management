<?php

namespace App\Domain\Post\Services\Method;

use App\Domain\Department\Exception\DepartmentNotFoundException;
use App\Domain\Department\Repositories\EloquentDepartmentRepository;
use App\Domain\Post\Model\Post;
use App\Domain\Post\Repositories\EloquentPostRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreatePostService
{
    public function __construct(
        private EloquentPostRepository $postRepository,
        private EloquentDepartmentRepository $departmentRepository
    )
    {


    }

    public function createPost(array $data)
    {
        try {
            if(!empty($data['department_id']) && isset($data['department_id'])) {
                $this->isDepartmentExists($data['department_id']);
            }
            $post = $this->makePost($data);
            DB::transaction(function () use ($data, $post){
                $this->postRepository->save($post);
                if (!empty($data['department_id']) && isset($data['department_id'])) {
                    $post->departments()->attach($data['department_id']);
                }
            });

        } catch (DepartmentNotFoundException $e) {
            throw $e;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }

    }

    private function isDepartmentExists(array $departmentsId)
    {
        $areDepartmentsExists = $this->departmentRepository->departmentsExistsById($departmentsId);
        if (!$areDepartmentsExists) {
            throw new DepartmentNotFoundException();
        }
    }

    private function makePost(array $data)
    {
        return Post::make([
            'title' => $data['title'],
            'content' => $data['content'],
            'visibility' => $data['visibility'],
            'user_id' => Auth::id()
        ]);

    }
}
