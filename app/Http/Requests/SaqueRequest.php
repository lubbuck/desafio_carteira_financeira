<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Dds\Classes\DDS;

class SaqueRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'valor' => ['required', 'numeric', 'digits_between:1,14'],
        ];
    }

    public function messages()
    {
        return trans('validation');
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'valor' => DDS::floatToInt($this->valor)
        ]);
    }
}
