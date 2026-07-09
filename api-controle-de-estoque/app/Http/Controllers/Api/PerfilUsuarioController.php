<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePerfilUsuarioRequest;
use App\Http\Requests\UpdatePerfilUsuarioRequest;
use App\Models\PerfilUsuario;
use OpenApi\Attributes as OA;

class PerfilUsuarioController extends Controller
{
    #[OA\Get(
        path: '/perfis-usuario',
        operationId: 'perfis-usuario.index',
        summary: 'Listar todos os registros',
        description: 'Retorna uma lista paginada de perfis de usuário',
        tags: ['Perfis de Usuário'],
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Lista de perfis de usuário', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/PerfilUsuario'))),
        ]
    )]
    public function index()
    {
        return PerfilUsuario::all();
    }

    #[OA\Post(
        path: '/perfis-usuario',
        operationId: 'perfis-usuario.store',
        summary: 'Criar novo registro',
        description: 'Cria um novo perfil de usuário com os dados enviados',
        tags: ['Perfis de Usuário'],
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/PerfilUsuario')),
        responses: [
            new OA\Response(response: 201, description: 'Registro criado com sucesso', content: new OA\JsonContent(ref: '#/components/schemas/PerfilUsuario')),
            new OA\Response(response: 422, description: 'Dados inválidos'),
        ]
    )]
    public function store(StorePerfilUsuarioRequest $request)
    {
        return response()->json(PerfilUsuario::create($request->validated()), 201);
    }

    #[OA\Get(
        path: '/perfis-usuario/{id}',
        operationId: 'perfis-usuario.show',
        summary: 'Exibir registro',
        description: 'Retorna os dados de um perfil de usuário específico',
        tags: ['Perfis de Usuário'],
        security: [['bearerAuth' => []]],
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Dados do perfil de usuário', content: new OA\JsonContent(ref: '#/components/schemas/PerfilUsuario')),
            new OA\Response(response: 404, description: 'Registro não encontrado'),
        ]
    )]
    public function show(int $id)
    {
        return PerfilUsuario::findOrFail($id);
    }

    #[OA\Put(
        path: '/perfis-usuario/{id}',
        operationId: 'perfis-usuario.update',
        summary: 'Atualizar registro',
        description: 'Atualiza os dados de um perfil de usuário existente',
        tags: ['Perfis de Usuário'],
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/PerfilUsuario')),
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Registro atualizado', content: new OA\JsonContent(ref: '#/components/schemas/PerfilUsuario')),
            new OA\Response(response: 404, description: 'Registro não encontrado'),
            new OA\Response(response: 422, description: 'Dados inválidos'),
        ]
    )]
    public function update(UpdatePerfilUsuarioRequest $request, int $id)
    {
        $perfilUsuario = PerfilUsuario::findOrFail($id);

        $perfilUsuario->update($request->validated());

        return $perfilUsuario;
    }

    #[OA\Delete(
        path: '/perfis-usuario/{id}',
        operationId: 'perfis-usuario.destroy',
        summary: 'Excluir registro',
        description: 'Remove um perfil de usuário do sistema',
        tags: ['Perfis de Usuário'],
        security: [['bearerAuth' => []]],
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 204, description: 'Registro excluído'),
            new OA\Response(response: 404, description: 'Registro não encontrado'),
        ]
    )]
    public function destroy(int $id)
    {
        $perfilUsuario = PerfilUsuario::findOrFail($id);
        $perfilUsuario->delete();

        return response()->noContent();
    }
}
