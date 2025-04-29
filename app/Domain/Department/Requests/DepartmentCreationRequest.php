<?php

namespace App\Domain\Department\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentCreationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'string|required',
            'description' => 'string|nullable'
        ];
    }
}
