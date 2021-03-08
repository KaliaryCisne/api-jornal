<?php


namespace App\Http\Requests\TypeNews;


use Urameshibr\Requests\FormRequest;

class TypeRegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'type' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'required'  => 'Campo :attribute é obrigatório',
            'string'   => 'Campo :attribute deve ser uma string'
        ];
    }
}
