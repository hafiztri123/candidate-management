<?php


namespace App\Shared\Services;

use Illuminate\Support\Facades\Auth;

class RoleManagerService
{
    public function canManageUser()
    {
        return Auth::user()->roles()->where('name', 'admin')->exists();
    }
}
