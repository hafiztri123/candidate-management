<?php

namespace App\Domain\Attendance\Services;

use App\Domain\Attendance\Services\Method\AttendanceClockInService;
use App\Domain\Attendance\Services\Method\AttendanceClockOutService;
use Illuminate\Support\Facades\Auth;

class AttendanceService
{
    public function __construct(
        private AttendanceClockInService $attendanceClockInService,
        private AttendanceClockOutService $attendanceClockOutService
    )
    {

    }

    public function clockIn()
    {
        return $this->attendanceClockInService->clockIn(Auth::id());
    }

    public function clockOut()
    {
        return $this->attendanceClockOutService->clockOut(Auth::id());
    }


}
