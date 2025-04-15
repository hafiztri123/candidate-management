<?php

namespace App\Domain\Role\Exceptions;

use App\Shared\Exceptions\DomainException;
use Illuminate\Http\Response;

class RoleNotFoundExceptions extends DomainException
{
    public function __construct(
        ?string $RoleId = null,
        ?string $customMessage = null
    )
    {
        parent::__construct(
            'Role',
            $RoleId,
            Response::HTTP_NOT_FOUND,
            $customMessage ?: 'Role not found',
            []
        );
    }
}
