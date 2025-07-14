<?php

namespace App\Http\Requests\Sistema;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Dds\Classes\RoutesPermiteds;
use App\Models\Sistema\PermissionRoute;

class PermissionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $registereds = $this->getMethod() == 'POST' ?
            PermissionRoute::pluck('route_name')->toArray()
            : PermissionRoute::where('permission_id', '!=', $this->permission->id)->pluck('route_name')->toArray();

        return [
            'nome' => [
                'required',
                'string',
                'between:2,100',
                Rule::unique('permissions', 'nome')->ignore($this->permission ? $this->permission->id : null)
            ],
            'group' => ['required', 'string', 'between:2,255'],
            'sub_group' => ['nullable', 'string', 'between:2,255'],
            'descricao' => ['nullable', 'string', 'between:2,255'],
            'routes' => ['required', 'array', Rule::notIn($registereds)]
        ];
    }

    public function messages()
    {
        return trans('validation');
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'routes' => isset($this->routes) ? RoutesPermiteds::filter($this->routes) : [],
        ]);
    }
}
