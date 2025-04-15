<?php

namespace App\Domain\User\Exceptions;

use App\Shared\Exceptions\DomainException;
use Illuminate\Http\Response;

class UserTokenLoginException extends DomainException
{
    public function __construct(
        string $customMessage = 'An error occured when user login',
        array $errors = []
    )
    {
        parent::__construct(
            'User',
            null,
            Response::HTTP_BAD_REQUEST,
            $customMessage,
            $errors
        );

    }
}
