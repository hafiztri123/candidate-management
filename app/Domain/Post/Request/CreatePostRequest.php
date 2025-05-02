<?php

namespace App\Domain\Post\Request;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'string|required|max:255',
            'content' => 'string|required',
            'visibility' => 'string|required|in:all_employees,specific_departments|max:255',
            'department_id' => 'array|required_if:visibility,specific_departments',
            'department_id.*' => 'string|exists:departments,id'

        ];
    }

}
