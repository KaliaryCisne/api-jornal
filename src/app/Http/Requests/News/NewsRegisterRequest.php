<?php


namespace App\Http\Requests\News;


use Urameshibr\Requests\FormRequest;

class NewsRegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'type_news_id' => 'required|integer|exists:type_news,id',
            'title' => 'required|string',
            'description' => 'required|string',
            'body' => 'required|string',
            'image_link' => 'string',
        ];
    }

    public function messages()
    {
        return [
            'required'  => 'Campo :attribute é obrigatório',
            'exists'    => 'O valor informado no campo :attribute deve existir na nossa base',
            'integer'   => 'Campo :attribute deve ser um número'
        ];
    }

}
