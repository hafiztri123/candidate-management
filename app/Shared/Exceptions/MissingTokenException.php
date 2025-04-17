<?php

namespace App\Shared\Exceptions;

use Exception;
use Illuminate\Http\Response;

class MissingTokenException extends Exception
{
    public function __construct()
    {
        parent::__construct(
            'Token is missing',
            Response::HTTP_BAD_REQUEST
        );

    }
}
