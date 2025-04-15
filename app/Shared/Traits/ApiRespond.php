<?php

namespace App\Shared\Traits;

use Illuminate\Http\Response;

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
    private function successResponse(
        string $message = "OK",
        int $HttpCode = Response::HTTP_OK,
        array $data = []
    )
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $HttpCode);



    }

    private function errorResponse(
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
