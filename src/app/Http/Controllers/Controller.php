<?php


namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * @OA\ Info(title="Api para Jornal", version="1.0.0")
 */
class Controller extends BaseController
{
    public function respondWithToken($token)
    {
        return response()->json([
            'status' => 'success',
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => env('JWT_TTL') . " minutos"
        ], 200);
    }
}
