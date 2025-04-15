<?php

namespace App\Domain\User\Events;

use App\Domain\Role\Models\Role;
use App\Domain\User\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserCreatedEvent
{
    Use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        private User $user,
        private Role $role
    )
    {

    }


    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name')
        ];
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getRole()
    {
        return $this->role;
    }
}
