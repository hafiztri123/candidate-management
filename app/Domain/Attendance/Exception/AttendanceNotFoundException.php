<?php

namespace App\Domain\Attendance\Exception;

use App\Shared\Exceptions\DomainException;
use Illuminate\Http\Response;

class AttendanceNotFoundException extends DomainException
{
    public function __construct()
    {
        parent::__construct(
            'Attendance',
            'N/A',
            Response::HTTP_NOT_FOUND,
            'Attendance not found'
        );

    }
}
