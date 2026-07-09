<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegistroAuditoriaRequest;
use App\Http\Requests\UpdateRegistroAuditoriaRequest;
use App\Models\RegistroAuditoria;
use OpenApi\Attributes as OA;

class RegistroAuditoriaController extends Controller
{
    #[OA\Get(
        path: '/registros-auditoria',
        operationId: 'registros-auditoria.index',
        summary: 'Listar todos os registros',
        description: 'Retorna uma lista paginada de registros de auditoria',
        tags: ['Registros de Auditoria'],
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Lista de registros de auditoria', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/RegistroAuditoria'))),
        ]
    )]
    public function index()
    {
        return RegistroAuditoria::all();
    }

    #[OA\Post(
        path: '/registros-auditoria',
        operationId: 'registros-auditoria.store',
        summary: 'Criar novo registro',
        description: 'Cria um novo registro de auditoria com os dados enviados',
        tags: ['Registros de Auditoria'],
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/RegistroAuditoria')),
        responses: [
            new OA\Response(response: 201, description: 'Registro criado com sucesso', content: new OA\JsonContent(ref: '#/components/schemas/RegistroAuditoria')),
            new OA\Response(response: 422, description: 'Dados inválidos'),
        ]
    )]
    public function store(StoreRegistroAuditoriaRequest $request)
    {
        return response()->json(RegistroAuditoria::create($request->validated()), 201);
    }

    #[OA\Get(
        path: '/registros-auditoria/{id}',
        operationId: 'registros-auditoria.show',
        summary: 'Exibir registro',
        description: 'Retorna os dados de um registro de auditoria específico',
        tags: ['Registros de Auditoria'],
        security: [['bearerAuth' => []]],
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Dados do registro de auditoria', content: new OA\JsonContent(ref: '#/components/schemas/RegistroAuditoria')),
            new OA\Response(response: 404, description: 'Registro não encontrado'),
        ]
    )]
    public function show(int $id)
    {
        return RegistroAuditoria::findOrFail($id);
    }

    #[OA\Put(
        path: '/registros-auditoria/{id}',
        operationId: 'registros-auditoria.update',
        summary: 'Atualizar registro',
        description: 'Atualiza os dados de um registro de auditoria existente',
        tags: ['Registros de Auditoria'],
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/RegistroAuditoria')),
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Registro atualizado', content: new OA\JsonContent(ref: '#/components/schemas/RegistroAuditoria')),
            new OA\Response(response: 404, description: 'Registro não encontrado'),
            new OA\Response(response: 422, description: 'Dados inválidos'),
        ]
    )]
    public function update(UpdateRegistroAuditoriaRequest $request, int $id)
    {
        $registroAuditoria = RegistroAuditoria::findOrFail($id);

        $registroAuditoria->update($request->validated());

        return $registroAuditoria;
    }

    #[OA\Delete(
        path: '/registros-auditoria/{id}',
        operationId: 'registros-auditoria.destroy',
        summary: 'Excluir registro',
        description: 'Remove um registro de auditoria do sistema',
        tags: ['Registros de Auditoria'],
        security: [['bearerAuth' => []]],
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 204, description: 'Registro excluído'),
            new OA\Response(response: 404, description: 'Registro não encontrado'),
        ]
    )]
    public function destroy(int $id)
    {
        $registroAuditoria = RegistroAuditoria::findOrFail($id);
        $registroAuditoria->delete();

        return response()->noContent();
    }
}
