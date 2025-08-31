<?php

namespace App\Modules\Auth\Http\Controllers;

use App\Modules\Auth\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request) {

        // A classe padrão auth está configurada em 'backend/src/config/auth.php'
        // Nela está definido que o model é o User
        // Primeiro parâmetro das keys é o campo que será usado pra buscar o usuário
        // Segundo parâmetro é o campo de senha
        // Se precisar logar por email ou username, tem que modificar o primeiro parâmetro de acordo com a busca.
        if(!Auth::attempt($request->only("email", "password"))) {
            return response()->json([
                "message" => "Invalid credentials"
            ], 401);
        }
        
        $user = $request->user();

        $token = $user->createToken("auth_token")->plainTextToken;

        return response()->json([
            "access_token" => $token,
            "token_type" => "Bearer",
            "user" => $user
        ]);

    }

    public function logout(Request $request)
    {
        // Esse $request->user() já está carregado devido ao middleware auth:sanctum
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Sessão encerrada com sucesso.'
        ]);
    }

}
