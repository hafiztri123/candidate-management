<?php

namespace App\Shared\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;

/*******************
 *
 *
 * *Purpose: menseragamkan api response
 *
 *
 *
 *******************/


trait ApiRespond
{
    public function successResponse(
        string $message = "OK",
        int $HttpCode = Response::HTTP_OK,
        array|Model|JsonResource|LengthAwarePaginator|Collection  $data = []
    )
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $HttpCode);



    }

    public function errorResponse(
        ?string $message = "FAIL",
        int $httpCode = Response::HTTP_INTERNAL_SERVER_ERROR,
        array $errors = []
    )  {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ], $httpCode);
    }
}
