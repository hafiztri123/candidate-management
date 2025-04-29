<?php

namespace App\Domain\Department\Exception;

use App\Shared\Exceptions\DomainException;
use Illuminate\Http\Response;

class DepartmentNotFoundException extends DomainException
{
    public function __construct(
       private ?string $departmentId = null

    )
    {
        parent::__construct(
            'Department',
            $departmentId,
            Response::HTTP_NOT_FOUND,
            'Department not found',
            []

        );

    }

}
