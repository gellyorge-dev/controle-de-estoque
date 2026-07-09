<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\UsuarioSistema;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use OpenApi\Attributes as OA;

class AuthController extends Controller
{
    #[OA\Post(
        path: '/login',
        operationId: 'login',
        summary: 'Autenticar usuário',
        description: 'Realiza o login e retorna um token de acesso',
        tags: ['Autenticação'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/LoginRequest')
        ),
        responses: [
            new OA\Response(response: 200, description: 'Login realizado com sucesso', content: new OA\JsonContent(ref: '#/components/schemas/LoginResponse')),
            new OA\Response(response: 422, description: 'Credenciais inválidas ou usuário inativo'),
        ]
    )]
    public function login(LoginRequest $request): JsonResponse
    {
        $usuario = UsuarioSistema::where('login_usuario', $request->login_usuario)->first();

        if (! $usuario || ! Hash::check($request->senha_usuario, $usuario->senha_usuario)) {
            throw ValidationException::withMessages([
                'login_usuario' => ['As credenciais fornecidas estão incorretas.'],
            ]);
        }

        if (! $usuario->ativo) {
            throw ValidationException::withMessages([
                'login_usuario' => ['Este usuário está inativo.'],
            ]);
        }

        $token = $usuario->createToken('api-token')->plainTextToken;

        return response()->json([
            'usuario' => $usuario,
            'token' => $token,
        ]);
    }

    #[OA\Post(
        path: '/logout',
        operationId: 'logout',
        summary: 'Sair do sistema',
        description: 'Revoga o token de acesso atual',
        tags: ['Autenticação'],
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Logout realizado com sucesso'),
            new OA\Response(response: 401, description: 'Não autorizado'),
        ]
    )]
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout realizado com sucesso.']);
    }

    #[OA\Get(
        path: '/me',
        operationId: 'me',
        summary: 'Dados do usuário autenticado',
        description: 'Retorna os dados do usuário atualmente autenticado',
        tags: ['Autenticação'],
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Dados do usuário', content: new OA\JsonContent(ref: '#/components/schemas/UsuarioSistema')),
            new OA\Response(response: 401, description: 'Não autorizado'),
        ]
    )]
    public function me(Request $request): JsonResponse
    {
        return response()->json($request->user());
    }
}
