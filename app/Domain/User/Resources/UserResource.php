<?php

namespace App\Domain\User\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            // 'email_verified_at' => $this->email_verified_at,
            'roles' => $this->roles->map(function ($role) {
                return [
                    'name' => $role->name,
                    'slug' => $role->slug,
                    'description' => $role->description,
                ];
            }),
        ];
    }
}
