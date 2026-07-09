<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUsuarioSistemaRequest;
use App\Http\Requests\UpdateUsuarioSistemaRequest;
use App\Models\UsuarioSistema;
use OpenApi\Attributes as OA;

class UsuarioSistemaController extends Controller
{
    #[OA\Get(
        path: '/usuarios-sistema',
        operationId: 'usuarios-sistema.index',
        summary: 'Listar todos os registros',
        description: 'Retorna uma lista paginada de usuários do sistema',
        tags: ['Usuários do Sistema'],
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Lista de usuários do sistema', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/UsuarioSistema'))),
        ]
    )]
    public function index()
    {
        return UsuarioSistema::all();
    }

    #[OA\Post(
        path: '/usuarios-sistema',
        operationId: 'usuarios-sistema.store',
        summary: 'Criar novo registro',
        description: 'Cria um novo usuário do sistema com os dados enviados',
        tags: ['Usuários do Sistema'],
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/UsuarioSistema')),
        responses: [
            new OA\Response(response: 201, description: 'Registro criado com sucesso', content: new OA\JsonContent(ref: '#/components/schemas/UsuarioSistema')),
            new OA\Response(response: 422, description: 'Dados inválidos'),
        ]
    )]
    public function store(StoreUsuarioSistemaRequest $request)
    {
        return response()->json(UsuarioSistema::create($request->validated()), 201);
    }

    #[OA\Get(
        path: '/usuarios-sistema/{id}',
        operationId: 'usuarios-sistema.show',
        summary: 'Exibir registro',
        description: 'Retorna os dados de um usuário do sistema específico',
        tags: ['Usuários do Sistema'],
        security: [['bearerAuth' => []]],
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Dados do usuário do sistema', content: new OA\JsonContent(ref: '#/components/schemas/UsuarioSistema')),
            new OA\Response(response: 404, description: 'Registro não encontrado'),
        ]
    )]
    public function show(int $id)
    {
        return UsuarioSistema::findOrFail($id);
    }

    #[OA\Put(
        path: '/usuarios-sistema/{id}',
        operationId: 'usuarios-sistema.update',
        summary: 'Atualizar registro',
        description: 'Atualiza os dados de um usuário do sistema existente',
        tags: ['Usuários do Sistema'],
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/UsuarioSistema')),
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Registro atualizado', content: new OA\JsonContent(ref: '#/components/schemas/UsuarioSistema')),
            new OA\Response(response: 404, description: 'Registro não encontrado'),
            new OA\Response(response: 422, description: 'Dados inválidos'),
        ]
    )]
    public function update(UpdateUsuarioSistemaRequest $request, int $id)
    {
        $usuarioSistema = UsuarioSistema::findOrFail($id);

        $usuarioSistema->update($request->validated());

        return $usuarioSistema;
    }

    #[OA\Delete(
        path: '/usuarios-sistema/{id}',
        operationId: 'usuarios-sistema.destroy',
        summary: 'Excluir registro',
        description: 'Remove um usuário do sistema do sistema',
        tags: ['Usuários do Sistema'],
        security: [['bearerAuth' => []]],
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 204, description: 'Registro excluído'),
            new OA\Response(response: 404, description: 'Registro não encontrado'),
        ]
    )]
    public function destroy(int $id)
    {
        $usuarioSistema = UsuarioSistema::findOrFail($id);
        $usuarioSistema->delete();

        return response()->noContent();
    }
}
