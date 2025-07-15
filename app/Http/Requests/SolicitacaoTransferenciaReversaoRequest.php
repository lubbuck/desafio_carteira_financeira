<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SolicitacaoTransferenciaReversaoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'motivo' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages()
    {
        return trans('validation');
    }
}
