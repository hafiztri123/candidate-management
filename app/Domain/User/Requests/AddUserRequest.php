<?php

namespace App\Domain\User\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class AddUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'string|required',
            'email' => 'string|email|required',
            'password' => 'string|required',
            'department_id' => 'string|required|exists:departments,id'
        ];
    }
}
