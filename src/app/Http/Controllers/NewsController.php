<?php


namespace App\Http\Controllers;

use App\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Cria uma notícia.
     * @param  Request  $request
     */
    public function create(Request $request)
    {
        //todo: Trocar esses validates para middlewares
        //todo: verificar se barra a criação de uma notícia cujo o tipo nao existe na tabela de tipos

        /** validate incoming request */
        $this->validate($request, [
            'type_news_id' => 'required|integer|exists:type_news,id',
            'title' => 'required|string',
            'description' => 'required|string',
            'body' => 'required|string'
        ]);

        try
        {
            $news = new News();
            $news->user_id = auth()->user()->id;
            $news->type_news_id = $request->input('type_news_id');
            $news->title = $request->input('title');
            $news->description = $request->input('description');
            $news->body = $request->input('body');

            if ($request->has('image_link')) {
                $news->image_link = $request->input('image_link');
            }
            $news->save();

            return response()->json([
                'status' => 'success',
                'data' => 'Notícia criada com sucesso!',
            ], 201);

        }
        catch (\Exception $e)
        {
            return response()->json([
                'status' => 'error',
                'data' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Lista todas as notícias de um jornalista
     * @param  Request  $request
     */
    public function me()
    {
        return response()->json([
            'status' => 'success',
            'data' => auth()->user()->news
        ]);
    }

    /**
     * Atualiza uma notícia
     * @param Request $request
     * @param $id
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        //validate incoming request
        $this->validate($request, [
            'type_news_id' => 'integer',
            'title' => 'string',
            'description' => 'string',
            'body' => 'string',
            'image_link' => 'string',
        ]);

        try {
            $type = News::findOrFail($id);
            $data = $request->all();
            $type->update($data);

            return response()->json([
                'status' => 'success',
                'data' => 'Notícia atualizada com sucesso!',
            ], 200);

        }
        catch (\Exception $e)
        {
            return response()->json([
                'status' => 'error',
                'data' => $e->getMessage(),
            ], 500);
        }

    }

    /**
     * Exclui uma notícia
     * @param $id
     * @throws \Illuminate\Validation\ValidationException
     */
    public function delete($id)
    {
        try {
            $type = News::findOrFail($id);
            $type->delete();

            return response()->json([
                'stauts' => 'success',
                'data' => 'Notícia removida com sucesso',
            ], 200);

        }
        catch (\Exception $e)
        {
            return response()->json( [
                'status' => 'error',
                'data' => $e->getMessage(),
            ], 500);
        }

    }

    /**
     * Retorna todas as notícias de um tipo
     * @param $id
     */
    public function findNewsByTypeId($id)
    {
        return response()->json([
            'status' => 'success',
            'data' => auth()->user()->typeNews->where('id', $id)->first()->news,
        ]);
    }

}
