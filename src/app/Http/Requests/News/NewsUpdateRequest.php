<?php


namespace App\Http\Requests\News;


use Urameshibr\Requests\FormRequest;

class NewsUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'type_news_id' => 'integer',
            'title' => 'string',
            'description' => 'string',
            'body' => 'string',
            'image_link' => 'string',
        ];
    }

    public function messages()
    {
        return [
            'required'  => 'Campo :attribute é obrigatório',
            'exists'    => 'O valor informado no campo :attribute deve existir na nossa base',
            'integer'   => 'Campo :attribute deve ser um número',
            'string'    => 'Campo :attribute deve ser uma string'
        ];
    }
}
