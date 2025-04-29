<?php

namespace App\Domain\User\Exceptions;

use App\Shared\Exceptions\DomainException;
use Illuminate\Http\Response;

class PasswordNotValidException extends DomainException
{
    public function __construct(
        array $errors = []
    )
    {
        parent::__construct(
            'User',
            'N/A',
            Response::HTTP_BAD_REQUEST,
            'Password not valid',
            $errors
        );

    }
}
