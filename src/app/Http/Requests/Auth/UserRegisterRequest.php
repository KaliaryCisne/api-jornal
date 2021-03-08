<?php

namespace App\Http\Requests\Auth;

use Urameshibr\Requests\FormRequest;

class UserRegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|string|unique:users',
            'password' => 'required|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'required'  => 'Campo :attribute é obrigatório',
            'unique'    => 'Campo :attribute já está cadastrado em nossa base',
            'confirmed'  => 'As senhas digitadas devem ser iguais',
        ];
    }
}
