<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCondicaoOperacionalEquipamentoRequest;
use App\Http\Requests\UpdateCondicaoOperacionalEquipamentoRequest;
use App\Models\CondicaoOperacionalEquipamento;
use OpenApi\Attributes as OA;

class CondicaoOperacionalEquipamentoController extends Controller
{
    #[OA\Get(
        path: '/condicoes-operacionais',
        operationId: 'condicoes-operacionais.index',
        summary: 'Listar todos os registros',
        description: 'Retorna uma lista paginada de condições operacionais',
        tags: ['Condições Operacionais'],
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Lista de condições operacionais', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/CondicaoOperacionalEquipamento'))),
        ]
    )]
    public function index()
    {
        return CondicaoOperacionalEquipamento::all();
    }

    #[OA\Post(
        path: '/condicoes-operacionais',
        operationId: 'condicoes-operacionais.store',
        summary: 'Criar novo registro',
        description: 'Cria um novo condição operacional com os dados enviados',
        tags: ['Condições Operacionais'],
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/CondicaoOperacionalEquipamento')),
        responses: [
            new OA\Response(response: 201, description: 'Registro criado com sucesso', content: new OA\JsonContent(ref: '#/components/schemas/CondicaoOperacionalEquipamento')),
            new OA\Response(response: 422, description: 'Dados inválidos'),
        ]
    )]
    public function store(StoreCondicaoOperacionalEquipamentoRequest $request)
    {
        return response()->json(CondicaoOperacionalEquipamento::create($request->validated()), 201);
    }

    #[OA\Get(
        path: '/condicoes-operacionais/{id}',
        operationId: 'condicoes-operacionais.show',
        summary: 'Exibir registro',
        description: 'Retorna os dados de um condição operacional específico',
        tags: ['Condições Operacionais'],
        security: [['bearerAuth' => []]],
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Dados do condição operacional', content: new OA\JsonContent(ref: '#/components/schemas/CondicaoOperacionalEquipamento')),
            new OA\Response(response: 404, description: 'Registro não encontrado'),
        ]
    )]
    public function show(int $id)
    {
        return CondicaoOperacionalEquipamento::findOrFail($id);
    }

    #[OA\Put(
        path: '/condicoes-operacionais/{id}',
        operationId: 'condicoes-operacionais.update',
        summary: 'Atualizar registro',
        description: 'Atualiza os dados de um condição operacional existente',
        tags: ['Condições Operacionais'],
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/CondicaoOperacionalEquipamento')),
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Registro atualizado', content: new OA\JsonContent(ref: '#/components/schemas/CondicaoOperacionalEquipamento')),
            new OA\Response(response: 404, description: 'Registro não encontrado'),
            new OA\Response(response: 422, description: 'Dados inválidos'),
        ]
    )]
    public function update(UpdateCondicaoOperacionalEquipamentoRequest $request, int $id)
    {
        $condicaoOperacionalEquipamento = CondicaoOperacionalEquipamento::findOrFail($id);

        $condicaoOperacionalEquipamento->update($request->validated());

        return $condicaoOperacionalEquipamento;
    }

    #[OA\Delete(
        path: '/condicoes-operacionais/{id}',
        operationId: 'condicoes-operacionais.destroy',
        summary: 'Excluir registro',
        description: 'Remove um condição operacional do sistema',
        tags: ['Condições Operacionais'],
        security: [['bearerAuth' => []]],
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 204, description: 'Registro excluído'),
            new OA\Response(response: 404, description: 'Registro não encontrado'),
        ]
    )]
    public function destroy(int $id)
    {
        $condicaoOperacionalEquipamento = CondicaoOperacionalEquipamento::findOrFail($id);
        $condicaoOperacionalEquipamento->delete();

        return response()->noContent();
    }
}
