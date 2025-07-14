<?php

namespace App\Http\Requests\Administracao\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'senha' => ['required'],
            'password' => ['required', 'string', 'min:8'],
        ];
    }

    public function messages()
    {
        return trans('validation');
    }
}
