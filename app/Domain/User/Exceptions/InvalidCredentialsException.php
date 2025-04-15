<?php

namespace App\Domain\User\Exceptions;

use App\Shared\Exceptions\DomainException;
use Illuminate\Http\Response;

class InvalidCredentialsException extends DomainException
{
    public function __construct()
    {
        parent::__construct(
            'User',
            null,
            Response::HTTP_BAD_REQUEST,
            'Email or password is incorrect',
            []
        );

    }
}
