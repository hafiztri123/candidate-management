<?php

namespace App\Domain\Attendance\Services\Method;

use App\Domain\Attendance\Exception\AttendanceAlreadyClockedOutException;
use App\Domain\Attendance\Exception\AttendanceNotFoundException;
use App\Domain\Attendance\Model\Attendance;
use App\Domain\Attendance\Repositories\EloquentAttendanceRepository;
use App\Domain\User\Exceptions\UserNotFoundException;
use App\Domain\User\Repositories\EloquentUserRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AttendanceClockOutService
{
    public function __construct(
        private EloquentAttendanceRepository $attendanceRepository,
        private EloquentUserRepository $userRepository
    )
    {

    }

    public function clockOut(string $userId)
    {
        try {
            $this->isUserExists($userId);
            $attendance = $this->getTodayUserNonClockedOutAttendance($userId);
            $this->attendanceAlreadyClockedOut($attendance);
            DB::transaction(function () use ($attendance) {
                $attendance->clocked_out = now();
                $this->attendanceRepository->save($attendance);

            });
        } catch (AttendanceNotFoundException | UserNotFoundException | AttendanceAlreadyClockedOutException $e) {
            throw $e;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw $e;

        }


    }

    private function getTodayUserNonClockedOutAttendance(string $userId)
    {
        $attendance = $this->attendanceRepository->getTodayNonClockedOutAttendanceByUserId($userId);
        if(!$attendance){
            throw new AttendanceNotFoundException();
        }
        return $attendance;

    }

    private function isUserExists(string $userId)
    {
        $user = $this->userRepository->findById($userId);
        if(!$user) {
            throw new UserNotFoundException($userId);
        }
    }

    private function attendanceAlreadyClockedOut(Attendance $attendance)
    {
        if($attendance && $attendance->clocked_out){
            throw new AttendanceAlreadyClockedOutException($attendance->id);
        }
    }
}
