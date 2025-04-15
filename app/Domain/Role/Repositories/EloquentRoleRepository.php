<?php

namespace APp\Domain\Role\Repositories;

use App\Domain\Role\Models\Role;

/*******************
 *
 *
 * *Purpose: transaksi database dengan model role
 * *Model:  App\Domain\Role\Models
 *
 *
 *
 *******************/

class EloquentRoleRepository
{
    public function save(Role $role)
    {
        $role->save();
    }

    public function findBySlug(string $slug){
        return Role::where('slug', $slug)->first();
    }
}
