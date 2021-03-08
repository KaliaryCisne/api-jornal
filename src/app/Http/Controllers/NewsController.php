<?php


namespace App\Http\Controllers;

use App\Http\Requests\News\NewsRegisterRequest;
use App\Http\Requests\News\NewsUpdateRequest;
use App\News;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @OA\Post(path="/api/news/create",
     *   tags={"Notícias"},
     *   summary="Rota para criar uma notícia.",
     *   description="Cria uma nova notícia.",
     *   @OA\Parameter(
     *     name="Authorization",
     *     in="header",
     *     description="Bearer ",
     *     required=true,
     *   ),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="application/x-www-form-urlencoded",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="type_news_id",
     *           description="Id do tipo de notícia.",
     *           type="integer",
     *         ),
     *         @OA\Property(
     *           property="title",
     *           description="Título da notícia.",
     *           type="string",
     *         ),
     *         @OA\Property(
     *           property="description",
     *           description="Descrição da notícia.",
     *           type="string",
     *         ),
     *         @OA\Property(
     *           property="body",
     *           description="Corpo da notícia.",
     *           type="string",
     *         ),
     *         @OA\Property(
     *           property="image_link",
     *           description="Imagem.",
     *           type="string",
     *         ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(response="201",
     *     description="{status:'success', data:'Notícia criada com sucesso!'}"
     *   ),
     *   @OA\Response(response="500", description="{status:'error', data:null, message:'Mensagem de erro'}")
     * ),
     */
    public function create(NewsRegisterRequest $request)
    {
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
                'data' => null,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Post(path="/api/news/update/{id}",
     *   tags={"Notícias"},
     *   summary="Rota para atualizar uma notícia.",
     *   description="Atualiza uma nova notícia.",
     *   @OA\Parameter(
     *     name="Authorization",
     *     in="header",
     *     description="Bearer ",
     *     required=true,
     *   ),
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Id da notícia",
     *     required=true,
     *   ),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="application/x-www-form-urlencoded",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="type_news_id",
     *           description="Id do tipo de notícia.",
     *           type="integer",
     *         ),
     *         @OA\Property(
     *           property="title",
     *           description="Título da notícia.",
     *           type="string",
     *         ),
     *         @OA\Property(
     *           property="description",
     *           description="Descrição da notícia.",
     *           type="string",
     *         ),
     *         @OA\Property(
     *           property="body",
     *           description="Corpo da notícia.",
     *           type="string",
     *         ),
     *         @OA\Property(
     *           property="image_link",
     *           description="Imagem.",
     *           type="string",
     *         ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(response="201",
     *     description="{status:'success', data:'Notícia atualizada com sucesso!'}"
     *   ),
     *   @OA\Response(response="500", description="{status:'error', data:null, message:'Mensagem de erro'}")
     * ),
     */
    public function update(NewsUpdateRequest $request, $id)
    {
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
                'data' => null,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Post(path="/api/news/delete/{id}",
     *   tags={"Notícias"},
     *   summary="Rota para remover uma notícia.",
     *   description="remove uma notícia.",
     *   @OA\Parameter(
     *     name="Authorization",
     *     in="header",
     *     description="Bearer ",
     *     required=true,
     *   ),
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Id da notícia",
     *     required=true,
     *   ),
     *   @OA\Response(response="201",
     *     description="{status:'success', data:'Notícia removida com sucesso!'}"
     *   ),
     *   @OA\Response(response="500", description="{status:'error', data:null, message:'Mensagem de erro'}")
     * ),
     */
    public function delete($id)
    {
        try {
            $type = News::findOrFail($id);
            $type->delete();

            return response()->json([
                'stauts' => 'success',
                'data' => 'Notícia removida com sucesso!',
            ], 200);

        }
        catch (\Exception $e)
        {
            return response()->json( [
                'status' => 'error',
                'data' => null,
                'message' => $e->getMessage(),
            ], 500);
        }

    }

    /**
     * @OA\Get(path="/api/news/type/{id}",
     *   tags={"Notícias"},
     *   summary="Rota para visualizar os todos os tipos de notícias do jornalista autenticado por um tipo.",
     *   description="Retorna todos os tipos de notícias do jornalista autenticado por um tipo.",
     *   @OA\Parameter(
     *     name="Authorization",
     *     in="header",
     *     description="Bearer ",
     *     required=true,
     *   ),
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Id da notícia",
     *     required=true,
     *   ),
     *   @OA\Response(response="200",
     *     description="{status:'success',
            data:{
                'id: 4,
                user_id: 1,
                type_news_id: 3,
                title: Título da notícia,
                description: Descrição aqui,
                body: Corpo aqui,
                image_link: null,
                created_at: 2021-03-08T01:40:37.000000Z,
                updated_at: 2021-03-08T01:40:37.000000Z
            }"
     *   ),
     * ),
     */
    public function findNewsByTypeId($id)
    {
        return response()->json([
            'status' => 'success',
            'data' => auth()->user()->typeNews->where('id', $id)->first()->news,
        ]);
    }

    /**
     * @OA\Get(path="/api/news/me",
     *   tags={"Notícias"},
     *   summary="Rota para visualizar os todos os tipos de notícias do jornalista autenticado.",
     *   description="Retorna todos os tipos de notícias do jornalista autenticado.",
     *   @OA\Parameter(
     *     name="Authorization",
     *     in="header",
     *     description="Bearer ",
     *     required=true,
     *   ),
     *   @OA\Response(response="200",
     *     description="{status:'success',
            data:{
                'id: 4,
                user_id: 1,
                type_news_id: 3,
                title: Título da notícia,
                description: Descrição aqui,
                body: Corpo aqui,
                image_link: null,
                created_at: 2021-03-08T01:40:37.000000Z,
                updated_at: 2021-03-08T01:40:37.000000Z
            }"
     *   ),
     * ),
     */
    public function me()
    {
        return response()->json([
            'status' => 'success',
            'data' => auth()->user()->news
        ]);
    }

}
