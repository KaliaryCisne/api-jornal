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
     * Cria um tipo de notícia.
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
                'status' => 'false',
                'data' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Busca os tipos de notícias pertencentes a um jornalista
     * @param  Request  $request
     */
    public function me()
    {
        return response()->json([
            'status' => 'success',
            'data' => auth()->user()->typeNews
        ]);
    }

    /**
     * Atualiza um tipo de notícia
     * @param Request $request
     * @param $id
     * @throws \Illuminate\Validation\ValidationException
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
                'data' => 'Tipo atualizado com sucesso',
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
     * Exclui um tipo de notícia
     * @param $id
     * @throws \Illuminate\Validation\ValidationException
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
                'data' => $e->getMessage(),
            ], 500);
        }

    }

}
