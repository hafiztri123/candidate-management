<?php

namespace App\Shared\Providers;

use App\Domain\User\Events\UserCreatedEvent;
use App\Domain\User\Listeners\AssignRoleToUser;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppEventProvider extends ServiceProvider
{
    public function boot(): void
    {
        Event::listen(
            UserCreatedEvent::class,
            AssignRoleToUser::class
        );
    }
}
