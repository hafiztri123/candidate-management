<?php

namespace App\Domain\User\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'string|required|email',
            'password' => 'string|required'
        ];
    }

}
