<?php

namespace App\Domain\Attendance\Exception;

use App\Shared\Exceptions\DomainException;
use Illuminate\Http\Response;

class AttendanceAlreadyClockedOutException extends DomainException
{
    public function __construct(
        ?string $attendanceId = null
    )
    {
        parent::__construct(
            'Attendance',
            $attendanceId ?? 'N/A',
            Response::HTTP_BAD_REQUEST,
            'Attendance already clocked out',
            []
        );

    }
}
