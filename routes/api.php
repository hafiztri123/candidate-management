<?php

use App\Domain\Attendance\Controllers\AttendanceController;
use App\Domain\Department\Controller\DepartmentController;
use App\Domain\Post\Controller\PostController;
use App\Domain\User\Controllers\AuthController;
use App\Domain\User\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('/v1')->group(function(){
    Route::prefix('/auth')->group(function(){
        Route::post('/register', [AuthController::class, 'store']);
        Route::post('/login/token', [AuthController::class, 'tokenBasedLogin']);
        Route::post('/login', [AuthController::class, 'cookieBasedLogin']);
    });

    Route::prefix('/auth')->middleware('auth:sanctum')->group(function(){
        Route::get('/me', [UserController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });

    Route::prefix('/users')->middleware("auth:sanctum")->group(function(){
        Route::get('/', [UserController::class, 'getAll']);
        Route::delete('/', [UserController::class, 'deleteUser']);
        Route::put('/', [UserController::class, 'updateUserPassword']);
        Route::post('/', [UserController::class, 'addUser']);
        Route::post('/attendances/in', [AttendanceController::class, 'clockIn']);
        Route::post('/attendances/out', [AttendanceController::class, 'clockOut']);
        Route::post('/posts', [PostController::class, 'createPost']);
        Route::get('/posts', [PostController::class, 'getPosts']);
    });

    Route::prefix('/departments')->middleware('auth:sanctum')->group(function(){
        Route::get('/', [DepartmentController::class, 'getAllDepartments']);
        Route::post('/', [DepartmentController::class, 'createDepartment']);
        Route::put('/{departmentId}', [DepartmentController::class, 'assignDepartment']);
    });
});
