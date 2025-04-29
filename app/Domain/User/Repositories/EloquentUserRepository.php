<?php

namespace App\Domain\User\Repositories;

use App\Domain\User\Models\User;
use Illuminate\Support\Facades\DB;

/*******************
 *
 *
 * *Purpose: transaksi database dengan model role
 * *Model:  App\Domain\User\Models
 *
 *
 *
 *******************/


class EloquentUserRepository
{

    /*******************
     *
     * *Purpose: menyimpan model yang telah dibuat sebelumnya ke database
     *
     *******************/

    public function save(User $user)
    {
            $user->save();
    }

    public function findByEmail(string $email)
    {
        return User::where('email', $email )->first();
    }

    public function findByIdWithRoles(string $id)
    {
        return User::with('roles')->find($id);
    }

    public function getAllUser(?string $criteria = null, int $pageSize = 10)
    {
        $baseQuery = User::query();

        if ($criteria){
            $baseQuery->where(function ($q) use ($criteria){
                $q->where('name', 'like', "%{$criteria}%")
                    ->orWhere('email', 'like', "%{$criteria}%");
            });
        }

        return $baseQuery->paginate($pageSize);
    }

    public function delete(User $user)
    {
        $user->delete();
    }

    public function findById(string $id)
    {
        return User::find($id);
    }

}
