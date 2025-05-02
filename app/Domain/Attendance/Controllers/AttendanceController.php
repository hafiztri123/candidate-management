<?php

namespace App\Domain\Attendance\Controllers;

use App\Domain\Attendance\Services\AttendanceService;
use App\Shared\Controllers\Controller;
use App\Shared\Traits\ApiRespond;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    use ApiRespond;

    public function __construct(
        private AttendanceService $attendanceService
    )
    {

    }

    public function clockIn(Request $request)
    {
        $this->attendanceService->clockIn();
        return $this->successResponse('Clock in successful');

    }

    public function clockOut(Request $request)
    {
        $this->attendanceService->clockOut();
        return $this->successResponse('Clock out succesful');
    }

}
