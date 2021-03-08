<?php

namespace App\Http\Requests\Auth;

use Urameshibr\Requests\FormRequest;

class UserLoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|string',
            'password' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'required'  => 'Campo :attribute é obrigatório',
            'unique'    => 'Campo :attribute já está cadastrado em nossa base',
        ];
    }
}
