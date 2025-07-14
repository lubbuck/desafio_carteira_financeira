<?php

namespace App\Http\Requests\Administracao\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePermissionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'permissions' => ['nullable', 'array', 'exists:permissions,id'],
        ];
    }

    public function messages()
    {
        return trans('validation');
    }
}
