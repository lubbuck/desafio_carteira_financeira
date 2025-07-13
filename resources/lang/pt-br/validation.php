<?php

return [

    'accepted' => 'Este campo deve ser aceito',
    'active_url' => 'O atributo não é uma URL válida',
    'after' => 'The :attribute must be a date after :date',
    'after_or_equal' => 'The :attribute must be a date after or equal to :date',
    'alpha' => 'Este campo só pode conter letras',
    'alpha_dash' => 'The :attribute may only contain letters, numbers, dashes and underscores',
    'alpha_num' => 'The :attribute may only contain letters and numbers',
    'array' => 'Este campo desse ser uma lista',
    'before' => 'The :attribute must be a date before :date',
    'before_or_equal' => 'The :attribute must be a date before or equal to :date',
    'between' => [
        'numeric' => 'O valor deste campo deve ser entre :min e :max',
        'file' => 'The :attribute must be between :min and :max kilobytes',
        'string' => 'Este campo deve ter entre :min e :max caracteres',
        'array' => 'The :attribute must have between :min and :max items',
    ],
    'boolean' => 'The :attribute field must be true or false',
    'confirmed' => 'Os campos não coincidem',
    'date' => 'Este campo só pode conter datas',
    'date_equals' => 'The :attribute must be a date equal to :date',
    'date_format' => 'The :attribute does not match the format :format',
    'different' => 'The :attribute and :other must be different',
    'digits' => 'O campo deve ter :digits digitos',
    'digits_between' => 'O campo deve ter entre :min e :max digitos',
    'dimensions' => 'The :attribute has invalid image dimensions',
    'distinct' => 'The :attribute field has a duplicate value',
    'email' => 'Este campo deve ser preenchido com um email',
    'ends_with' => 'The :attribute must end with one of the following: :values',
    'exists' => 'Insira um dos dados presentes aqui',
    'file' => 'The :attribute must be a file',
    'filled' => 'The :attribute field must have a value',
    'gt' => [
        'numeric' => 'The :attribute must be greater than :value',
        'file' => 'The :attribute must be greater than :value kilobytes',
        'string' => 'The :attribute must be greater than :value characters',
        'array' => 'The :attribute must have more than :value items',
    ],
    'gte' => [
        'numeric' => 'The :attribute must be greater than or equal :value',
        'file' => 'The :attribute must be greater than or equal :value kilobytes',
        'string' => 'The :attribute must be greater than or equal :value characters',
        'array' => 'The :attribute must have :value items or more',
    ],
    'image' => 'Insira apenas arquivos de imagem',
    'in' => 'Selecione uma das opções',
    'in_array' => 'The :attribute field does not exist in :other',
    'integer' => 'The :attribute must be an integer',
    'ip' => 'The :attribute must be a valid IP address',
    'ipv4' => 'The :attribute must be a valid IPv4 address',
    'ipv6' => 'The :attribute must be a valid IPv6 address',
    'json' => 'The :attribute must be a valid JSON string',
    'lt' => [
        'numeric' => 'The :attribute must be less than :value',
        'file' => 'The :attribute must be less than :value kilobytes',
        'string' => 'The :attribute must be less than :value characters',
        'array' => 'The :attribute must have less than :value items',
    ],
    'lte' => [
        'numeric' => 'The :attribute must be less than or equal :value',
        'file' => 'The :attribute must be less than or equal :value kilobytes',
        'string' => 'The :attribute must be less than or equal :value characters',
        'array' => 'The :attribute must not have more than :value items',
    ],
    'max' => [
        'numeric' => 'O campo deve ter no máximo :max digitos',
        'file' => 'O arquivo deve ter no máximo :max kilobytes',
        'string' => 'O campo deve ter no máximo :max caracteres',
        'array' => 'The :attribute may not have more than :max items',
    ],
    'mimes' => 'O arquivo deve ser do tipo: :values',
    'mimetypes' => 'O arquivo deve ser do tipo: :values',
    'min' => [
        'numeric' => 'Este campo deve ter no mínimo :min digitos',
        'file' => 'Este arquivo deve ter no mínimo :min kilobytes',
        'string' => 'Este campo deve ter no mínimo :min caracteres',
        'array' => 'The :attribute must have at least :min items',
    ],
    'not_in' => 'The selected :attribute is invalid',
    'not_regex' => 'The :attribute format is invalid',
    'numeric' => 'Este campo deve ser um número',
    'password' => 'A senha está incorreta',
    'present' => 'The :attribute field must be present',
    'regex' => 'The :attribute format is invalid',
    'required' => 'Este campo deve ser preenchido',
    'required_if' => 'The :attribute field is required when :other is :value',
    'required_unless' => 'The :attribute field is required unless :other is in :values',
    'required_with' => 'The :attribute field is required when :values is present',
    'required_with_all' => 'The :attribute field is required when :values are present',
    'required_without' => 'The :attribute field is required when :values is not present',
    'required_without_all' => 'The :attribute field is required when none of :values are present',
    'same' => 'The :attribute and :other must match',
    'size' => [
        'numeric' => 'Este campo deve ter :size digitos',
        'file' => 'Este arquivo deve ter :size kilobytes',
        'string' => 'Este campo deve ter :size caracteres',
        'array' => 'The :attribute must contain :size items',
    ],
    'starts_with' => 'The :attribute must start with one of the following: :values',
    'string' => 'The :attribute must be a string',
    'timezone' => 'The :attribute must be a valid zone',
    'unique' => 'Já existe esse dado cadastrado no sistema',
    'uploaded' => 'The :attribute failed to upload',
    'url' => 'The :attribute format is invalid',
    'uuid' => 'The :attribute must be a valid UUID',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attributerule" to name the lines This makes it quick to
    | specify a specific custom language line for a given attribute rule
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email" This simply helps us make our message more expressive
    |
    */

    'attributes' => [],

];
