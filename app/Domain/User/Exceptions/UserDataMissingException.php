<?php

namespace App\Domain\User\Exceptions;

use App\Shared\Exceptions\DomainException;
use Illuminate\Http\Response;

class UserDataMissingException extends DomainException
{
    public function __construct(
        ?string $customMessage = null,
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
