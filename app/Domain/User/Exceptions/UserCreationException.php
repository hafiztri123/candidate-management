<?php

namespace App\Domain\User\Exceptions;

use App\Shared\Exceptions\DomainException;
use Illuminate\Http\Response;

class UserCreationException extends DomainException
{
    public function __construct(
        ?string $userId = null,
        ?string $customMessage = null
    )
    {
        parent::__construct(
            'User',
            $userId,
            Response::HTTP_BAD_REQUEST,
            $customMessage
        );
    }

}
