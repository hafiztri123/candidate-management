<?php

namespace App\Domain\Attendance\Services\Method;

use App\Domain\Attendance\Exception\AttendanceAlreadyExistsException;
use App\Domain\Attendance\Model\Attendance;
use App\Domain\Attendance\Repositories\EloquentAttendanceRepository;
use App\Domain\User\Exceptions\UserNotFoundException;
use App\Domain\User\Repositories\EloquentUserRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AttendanceClockInService
{
    public function __construct(
        private EloquentAttendanceRepository $attendanceRepository,
        private EloquentUserRepository $userRepository
    )
    {

    }

    public function clockIn(string $userId)
    {
        try{
            $this->isUserExists($userId);
            $this->attendanceAlreadyExists($userId);
            DB::transaction(function () use ($userId) {
                $attendance = $this->makeAttendance($userId);
                $this->attendanceRepository->save($attendance);
            });

        } catch (AttendanceAlreadyExistsException | UserNotFoundException $e) {
            throw $e;
        } catch (Exception $e){
            Log::error($e->getMessage());
            throw $e;
        }


    }

    private function attendanceAlreadyExists(string $userId)
    {
        $attendance = $this->attendanceRepository->getTodayAttendanceByUserID($userId);
        if($attendance){
            throw new AttendanceAlreadyExistsException();
        }
        return false;
    }


    private function makeAttendance(string $userId)
    {
        return Attendance::make([
            'user_id' => $userId,
        ]);
    }

    private function isUserExists(string $userId)
    {
        $user = $this->userRepository->findById($userId);
        if(!$user){
            throw new UserNotFoundException($userId);
        }
    }
}
