<?php

namespace App\Domain\User\Exceptions;

use App\Shared\Exceptions\DomainException;
use Illuminate\Http\Response;

class UserNotFoundException extends DomainException
{
    public function __construct(
        ?string $userId = null,
        ?string $customMessage = 'User not found'
    )
    {
        parent::__construct(
            'User',
            $userId,
            Response::HTTP_NOT_FOUND,
            $customMessage,
            []
        );
    }
}
