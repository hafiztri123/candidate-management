<?php

namespace App\Domain\Attendance\Repositories;

use App\Domain\Attendance\Model\Attendance;

class EloquentAttendanceRepository
{
    public function getTodayAttendanceByUserId(string $userId)
    {
        return Attendance::where('user_id', $userId)
            ->whereDate('created_at', today())
            ->first();
    }

    public function getTodayNonClockedOutAttendanceByUserId(string $userId)
    {
        return Attendance::where('user_id', $userId)
            ->whereDate('created_at', today())
            ->whereNull('clocked_out')
            ->first();
    }

    public function save(Attendance $attendance)
    {
        $attendance->save();
    }
}
