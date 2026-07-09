<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEspacoArmazenamentoRequest;
use App\Http\Requests\UpdateEspacoArmazenamentoRequest;
use App\Models\EspacoArmazenamento;
use OpenApi\Attributes as OA;

class EspacoArmazenamentoController extends Controller
{
    #[OA\Get(
        path: '/espacos-armazenamento',
        operationId: 'espacos-armazenamento.index',
        summary: 'Listar todos os registros',
        description: 'Retorna uma lista paginada de espaços de armazenamento',
        tags: ['Espaços de Armazenamento'],
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Lista de espaços de armazenamento', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/EspacoArmazenamento'))),
        ]
    )]
    public function index()
    {
        return EspacoArmazenamento::all();
    }

    #[OA\Post(
        path: '/espacos-armazenamento',
        operationId: 'espacos-armazenamento.store',
        summary: 'Criar novo registro',
        description: 'Cria um novo espaço de armazenamento com os dados enviados',
        tags: ['Espaços de Armazenamento'],
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/EspacoArmazenamento')),
        responses: [
            new OA\Response(response: 201, description: 'Registro criado com sucesso', content: new OA\JsonContent(ref: '#/components/schemas/EspacoArmazenamento')),
            new OA\Response(response: 422, description: 'Dados inválidos'),
        ]
    )]
    public function store(StoreEspacoArmazenamentoRequest $request)
    {
        return response()->json(EspacoArmazenamento::create($request->validated()), 201);
    }

    #[OA\Get(
        path: '/espacos-armazenamento/{id}',
        operationId: 'espacos-armazenamento.show',
        summary: 'Exibir registro',
        description: 'Retorna os dados de um espaço de armazenamento específico',
        tags: ['Espaços de Armazenamento'],
        security: [['bearerAuth' => []]],
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Dados do espaço de armazenamento', content: new OA\JsonContent(ref: '#/components/schemas/EspacoArmazenamento')),
            new OA\Response(response: 404, description: 'Registro não encontrado'),
        ]
    )]
    public function show(int $id)
    {
        return EspacoArmazenamento::findOrFail($id);
    }

    #[OA\Put(
        path: '/espacos-armazenamento/{id}',
        operationId: 'espacos-armazenamento.update',
        summary: 'Atualizar registro',
        description: 'Atualiza os dados de um espaço de armazenamento existente',
        tags: ['Espaços de Armazenamento'],
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/EspacoArmazenamento')),
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Registro atualizado', content: new OA\JsonContent(ref: '#/components/schemas/EspacoArmazenamento')),
            new OA\Response(response: 404, description: 'Registro não encontrado'),
            new OA\Response(response: 422, description: 'Dados inválidos'),
        ]
    )]
    public function update(UpdateEspacoArmazenamentoRequest $request, int $id)
    {
        $espacoArmazenamento = EspacoArmazenamento::findOrFail($id);

        $espacoArmazenamento->update($request->validated());

        return $espacoArmazenamento;
    }

    #[OA\Delete(
        path: '/espacos-armazenamento/{id}',
        operationId: 'espacos-armazenamento.destroy',
        summary: 'Excluir registro',
        description: 'Remove um espaço de armazenamento do sistema',
        tags: ['Espaços de Armazenamento'],
        security: [['bearerAuth' => []]],
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 204, description: 'Registro excluído'),
            new OA\Response(response: 404, description: 'Registro não encontrado'),
        ]
    )]
    public function destroy(int $id)
    {
        $espacoArmazenamento = EspacoArmazenamento::findOrFail($id);
        $espacoArmazenamento->delete();

        return response()->noContent();
    }
}
