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

}
