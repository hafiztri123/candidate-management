<?php

namespace App\Domain\User\Listeners;

use App\Domain\User\Events\UserCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

class AssignRoleToUser implements ShouldQueue
{
    protected $tries = 3;
    protected $backoff = 60;

    public function handle(UserCreatedEvent $event)
    {
        $user = $event->getUser();
        $role = $event->getRole();

        $user->roles()->attach($role->id);

    }
}
