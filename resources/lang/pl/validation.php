<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute musi zostać zaakceptowany.',
    'active_url' => 'The :attribute is not a valid URL.',
    'after' => ':attribute musi być po dacie :date.',
    'after_or_equal' => ':attribute musi być po lub równy dacie :date.',
    'alpha' => 'The :attribute may only contain letters.',
    'alpha_dash' => 'The :attribute may only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'The :attribute may only contain letters and numbers.',
    'array' => ':attribute musi być tablicą.',
    'before' => ':attribute musi być przed :date.',
    'before_or_equal' => ':attribute musi być równy lub wczesniejszy od daty :date.',
    'between' => [
        'numeric' => ':attribute musi być pomiędzy :min a :max.',
        'file' => ':attribute musi mieć rozmiar pomiędzy :min a :max kilobytes.',
        'string' => ':attribute musi zawierać od :min do :max znaków.',
        'array' => ':attribute musi zawierać pomiędzy :min a :max pozycji.',
    ],
    'boolean' => 'The :attribute field must be true or false.',
    'confirmed' => ':attribute nie pasuje do podanego wcześniej.',
    'date' => ':attribute nie jest poprawną datą.',
    'date_equals' => 'The :attribute must be a date equal to :date.',
    'date_format' => ':attribute nie pasuje do formatu :format.',
    'different' => 'The :attribute and :other must be different.',
    'digits' => ':attribute musi być liczbą :digits.',
    'digits_between' => ':attribute musi być liczbą pomiędzy :min a :max digits.',
    'dimensions' => 'The :attribute has invalid image dimensions.',
    'distinct' => 'The :attribute field has a duplicate value.',
    'email' => ':attribute musi być poprawnym adresem email.',
    'exists' => 'The selected :attribute is invalid.',
    'file' => 'The :attribute must be a file.',
    'filled' => 'The :attribute field must have a value.',
    'gt' => [
        'numeric' => 'The :attribute must be greater than :value.',
        'file' => 'The :attribute must be greater than :value kilobytes.',
        'string' => 'The :attribute must be greater than :value characters.',
        'array' => 'The :attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'The :attribute must be greater than or equal :value.',
        'file' => 'The :attribute must be greater than or equal :value kilobytes.',
        'string' => 'The :attribute must be greater than or equal :value characters.',
        'array' => 'The :attribute must have :value items or more.',
    ],
    'image' => 'The :attribute must be an image.',
    'in' => 'The selected :attribute is invalid.',
    'in_array' => 'The :attribute field does not exist in :other.',
    'integer' => ':attribute musi być liczbą całkowitą.',
    'ip' => 'The :attribute must be a valid IP address.',
    'ipv4' => 'The :attribute must be a valid IPv4 address.',
    'ipv6' => 'The :attribute must be a valid IPv6 address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => 'The :attribute must be less than :value.',
        'file' => 'The :attribute must be less than :value kilobytes.',
        'string' => 'The :attribute must be less than :value characters.',
        'array' => 'The :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'The :attribute must be less than or equal :value.',
        'file' => 'The :attribute must be less than or equal :value kilobytes.',
        'string' => 'The :attribute must be less than or equal :value characters.',
        'array' => 'The :attribute must not have more than :value items.',
    ],
    'max' => [
        'numeric' => ':attribute nie może być wiekszy od :max.',
        'file' => ':attribute nie może mieć rozmieru wiekszego niż :max kilobajtów.',
        'string' => ':attribute nie może mieć wiecej niż :max znaków.',
        'array' => ':attribute nie może zawierać wiecej niż :max pozycji.',
    ],
    'mimes' => ':attribute musi być o rozszerzeniu: :values.',
    'mimetypes' => ':attribute plik musi być jednym z mimetypes: :values.',
    'min' => [
        'numeric' => ':attribute musi wynosić conajmniej :min.',
        'file' => ':attribute musi mieć rozmiar conajmniej :min kilobajtów.',
        'string' => ':attribute muesi mieć conajmniej :min znaków.',
        'array' => ':attribute musi zawierać conajmniej :min pozycji.',
    ],
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'The :attribute format is invalid.',
    'numeric' => ':attribute musi być liczbą.',
    'present' => 'The :attribute field must be present.',
    'regex' => 'The :attribute format is invalid.',
    'required' => ':attribute jest wymagane.',
    'required_if' => 'The :attribute field is required when :other is :value.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'The :attribute and :other must match.',
    'size' => [
        'numeric' => ':attribute musi być :size.',
        'file' => ':attribute musi mieć rozmiar :size kilobajtów.',
        'string' => ':attribute musi mieć rozmiar :size znaków.',
        'array' => ':attribute musi zawierać :size pozycji.',
    ],
    'starts_with' => 'The :attribute must start with one of the following: :values',
    'string' => ':attribute musi być ciągiem znaków.',
    'timezone' => 'The :attribute must be a valid zone.',
    'unique' => ':attribute jest zajęty.',
    'uploaded' => 'The :attribute failed to upload.',
    'url' => 'The :attribute format is invalid.',
    'uuid' => 'The :attribute must be a valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
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
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
