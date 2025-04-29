<?php

namespace App\Domain\Department\Exceptions;

use App\Shared\Exceptions\DomainException;
use Illuminate\Http\Response;

class MissingDepartmentDataException extends DomainException
{
    public function __construct(
        ?string $customMessage = null,
        array $errors = []
    )
    {
        parent::__construct(
            'Department',
            'n/a',
            Response::HTTP_BAD_REQUEST,
            $customMessage ?: 'Missing required data during department registration',
            $errors
        );

    }

}
