<?php


namespace App\Http\Controllers;

use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Requests\Auth\UserRegisterRequest;
use Illuminate\Support\Facades\Auth;
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
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="application/x-www-form-urlencoded",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="first_name",
     *           description="Primeiro nome.",
     *           type="string",
     *         ),
     *         @OA\Property(
     *           property="last_name",
     *           description="Sobrenome.",
     *           type="string",
     *         ),
     *         @OA\Property(
     *           property="email",
     *           description="Email do jornalista, será utilizado como login.",
     *           type="string",
     *         ),
     *         @OA\Property(
     *           property="password",
     *           description="Senha.",
     *           type="string",
     *         ),
     *         @OA\Property(
     *           property="password_confirmation",
     *           description="Confirmação da senha.",
     *           type="string",
     *         ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(response="201", description="{status:'success', data:'jornalista criado com sucesso!'}"),
     *   @OA\Response(response="500", description="{status:'error', data:null, message:'Menssagem de erro'}")
     * ),
     */
    public function register(UserRegisterRequest $request)
    {
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
                'data'   =>  null,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Post(path="/api/login",
     *   tags={"Jornalista"},
     *   summary="Rota para autenticar um jornalista.",
     *   description="Realiza o login e devolve um Token ( JWT ) que expira em 5 minutos.",
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
     *           property="email",
     *           description="email utilizado para se registrar.",
     *           type="string",
     *         ),
     *         @OA\Property(
     *           property="password",
     *           description="Senha informado no registro.",
     *           type="string",
     *         ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(response="200",
     *     description="{status:'success',
          data:'{token: hash, token_type: 'bearer,' expire_in: 'tempo de expiração do token'}'}"
     *   ),
     *   @OA\Response(response="401", description="{status:'fail', data:null, message:'Email ou senha incorretos'}")
     * ),
     */
    public function login(UserLoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (! $token = Auth::attempt($credentials)) {
            return response()->json([
                    'status' => 'fail',
                    'data'   => null,
                    'message' => 'Email ou senha incorretos'
                   ],401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @OA\Get(path="/api/me",
     *   tags={"Jornalista"},
     *   summary="Rota para visualizar os dados do jornalista autenticado.",
     *   description="Retorna os dados do jornalista autenticado.",
     *   @OA\Parameter(
     *     name="Authorization",
     *     in="header",
     *     description="Bearer ",
     *     required=true,
     *   ),
     *   @OA\Response(response="200",
     *     description="{status:'success',
            data:{'id': 1,
                'first_name': 'Kaliary',
                'last_name': 'Cisne',
                'email': 'kaliarycisne@gmail.com',
                'created_at': '2021-03-08T00:17:28.000000Z',
                'updated_at': '2021-03-08T00:17:28.000000Z'
           }"
     *   ),
     * ),
     */
    public function me()
    {
        return response()->json([
            'status' => 'success',
            'data' => auth()->user()
        ]);
    }

}
