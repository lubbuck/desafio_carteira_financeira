<?php

namespace App\Http\Requests\Administracao\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'between:2,255'],
            'email' => ['required', 'email', 'between:5,255', Rule::unique('users', 'email')->ignore($this->user ? $this->user->id : null)]
        ];
    }

    public function messages()
    {
        return trans('validation');
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'email' =>  !is_null($this->email) ? strtolower($this->email) : null,
        ]);
    }
}
