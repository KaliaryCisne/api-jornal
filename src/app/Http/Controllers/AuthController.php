<?php


namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    /**
     * @OA\Post(path="/api/register",
     *   tags={"Jornalista"},
     *   summary="Rota para criação de jornalistas.",
     *   description="Cria um jornalista.",
     *   @OA\Parameter(
     *      name="username",
     *      in="body",
     *      required=true,
     *     @OA\Schema(type="string"),
     *   ),
     *   @OA\Response(response="default", description="successful operation")
     * ),
     * @param  Request  $request
     */
    public function register(Request $request)
    {
        //validate incoming request
        $this->validate($request, [
            'email' => 'required|string|unique:users',
            'password' => 'required|confirmed',
        ]);

        try
        {
            $user = new User;
            $user->first_name= $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->email= $request->input('email');
            $user->password = app('hash')->make($request->input('password'));
            $user->save();

            return response()->json( [
                'status' => 'success',
                'data' => 'Jornalista criado com sucesso!'
            ], 201);

        }
        catch (\Exception $e)
        {
            return response()->json( [
                'status' => 'error',
                'data'   =>  $e->getMessage()
            ], 500);
        }
    }

    /**
     * Realiza o login e devolve um Token ( JWT ) que expira em 5 minutos
     * @param  Request  $request
     */
    public function login(Request $request)
    {
        //validate incoming request
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['email', 'password']);

        if (! $token = Auth::attempt($credentials)) {
            return response()->json([
                    'status' => 'fail',
                    'data'   => 'Email ou senha incorretos'
                   ],401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Retorna os dados de um jornalista.
     * @param  Request  $request
     */
    public function me()
    {
        return response()->json([
            'status' => 'success',
            'data' => auth()->user()
        ]);
    }
}
