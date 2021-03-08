<?php


namespace App\Http\Controllers;

use App\TypeNews;
use Illuminate\Http\Request;
use Mockery\Exception;

class TypeNewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @OA\Post(path="/api/type/create",
     *   tags={"Tipos de notícias"},
     *   summary="Rota para criar um tipo de notícia.",
     *   description="Cria um novo tipo de notícia.",
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
     *           property="type",
     *           description="Tipo da notícia.",
     *           type="string",
     *         ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(response="201",
     *     description="{status:'success', data:'Tipo criado com sucesso!'}"
     *   ),
     *   @OA\Response(response="500", description="{status:'error', data:null, message:'Mensagem de erro'}")
     * ),
     * @param  Request  $request
     */
    public function create(Request $request)
    {
        //todo: Trocar esses validates para middlewares
        //validate incoming request
        $this->validate($request, [
            'type' => 'required|string',
        ]);

        try
        {
            $user = new TypeNews();
            $user->user_id = auth()->user()->id;
            $user->type = $request->input('type');

            $user->save();

            return response()->json([
                'status' => 'success',
                'data' => 'Tipo criado com sucesso!',
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
     * @OA\Post(path="/api/type/update/{id}",
     *   tags={"Tipos de notícias"},
     *   summary="Rota para atualizar um tipo de notícia.",
     *   description="Atualiza um tipo de notícia.",
     *   @OA\Parameter(
     *     name="Authorization",
     *     in="header",
     *     description="Bearer ",
     *     required=true,
     *   ),
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Id do tipo da notícia",
     *     required=true,
     *   ),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="application/x-www-form-urlencoded",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="type",
     *           description="Tipo da notícia.",
     *           type="string",
     *         ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(response="200",
     *     description="{status:'success', data:'Tipo atualizado com sucesso!'}"
     *   ),
     *   @OA\Response(response="500", description="{status:'error', data:null, message:'Mensagem de erro'}")
     * ),
     * @param  Request  $request
     */
    public function update(Request $request, $id)
    {
        //validate incoming request
        $this->validate($request, [
            'type' => 'required|string',
        ]);

        try {
            $type = TypeNews::findOrFail($id);
            $data = $request->all();
            $type->update($data);

            return response()->json( [
                'status' => 'success',
                'data' => 'Tipo atualizado com sucesso!',
            ], 200);

        }
        catch (\Exception $e)
        {
            return response()->json( [
                'status' => 'error',
                'data'   => null,
                'message' => $e->getMessage(),
            ], 500);
        }

    }

    /**
     * @OA\Post(path="/api/type/delete/{id}",
     *   tags={"Tipos de notícias"},
     *   summary="Rota para remover um tipo de notícia.",
     *   description="Remove um tipo de notícia.",
     *   @OA\Parameter(
     *     name="Authorization",
     *     in="header",
     *     description="Bearer ",
     *     required=true,
     *   ),
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Id do tipo da notícia",
     *     required=true,
     *   ),
     *   @OA\Response(response="200",
     *     description="{status:'success', data:'Tipo removido com sucesso!'}"
     *   ),
     *   @OA\Response(response="500", description="{status:'error', data:null, message:'Mensagem de erro'}")
     * ),
     * @param  Request  $request
     */
    public function delete($id)
    {
        try {
            $type = TypeNews::findOrFail($id);

            // Não permite que um tipo seja excluido estando atrelado a uma notícia
            if ($type->news->isNotEmpty()) {
                throw new Exception("Este tipo está em uso em uma notícia e por isso não pode ser deletado.");
            }

            $type->delete();

            return response()->json( [
                'status' => 'success',
                'data' => 'Tipo removido com sucesso!',
            ], 200);

        }
        catch (\Exception $e)
        {
            return response()->json( [
                'status' => 'error',
                'data'  => null,
                'message' => $e->getMessage(),
            ], 500);
        }

    }

    /**
     * @OA\Get(path="/api/type/me",
     *   tags={"Tipos de notícias"},
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
                'id': 1,
                'user_id': '1',
                'type': 'Esportes',
                'created_at': '2021-03-08T00:17:28.000000Z',
                'updated_at': '2021-03-08T00:17:28.000000Z'
            }"
     *   ),
     * ),
     * @param  Request  $request
     */
    public function me()
    {
        return response()->json([
            'status' => 'success',
            'data' => auth()->user()->typeNews
        ]);
    }

}
