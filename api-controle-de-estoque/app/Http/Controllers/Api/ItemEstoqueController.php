<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreItemEstoqueRequest;
use App\Http\Requests\UpdateItemEstoqueRequest;
use App\Models\ItemEstoque;
use OpenApi\Attributes as OA;

class ItemEstoqueController extends Controller
{
    #[OA\Get(
        path: '/itens-estoque',
        operationId: 'itens-estoque.index',
        summary: 'Listar todos os registros',
        description: 'Retorna uma lista paginada de itens de estoque',
        tags: ['Itens de Estoque'],
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Lista de itens de estoque', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/ItemEstoque'))),
        ]
    )]
    public function index()
    {
        return ItemEstoque::all();
    }

    #[OA\Post(
        path: '/itens-estoque',
        operationId: 'itens-estoque.store',
        summary: 'Criar novo registro',
        description: 'Cria um novo item de estoque com os dados enviados',
        tags: ['Itens de Estoque'],
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/ItemEstoque')),
        responses: [
            new OA\Response(response: 201, description: 'Registro criado com sucesso', content: new OA\JsonContent(ref: '#/components/schemas/ItemEstoque')),
            new OA\Response(response: 422, description: 'Dados inválidos'),
        ]
    )]
    public function store(StoreItemEstoqueRequest $request)
    {
        return response()->json(ItemEstoque::create($request->validated()), 201);
    }

    #[OA\Get(
        path: '/itens-estoque/{id}',
        operationId: 'itens-estoque.show',
        summary: 'Exibir registro',
        description: 'Retorna os dados de um item de estoque específico',
        tags: ['Itens de Estoque'],
        security: [['bearerAuth' => []]],
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Dados do item de estoque', content: new OA\JsonContent(ref: '#/components/schemas/ItemEstoque')),
            new OA\Response(response: 404, description: 'Registro não encontrado'),
        ]
    )]
    public function show(int $id)
    {
        return ItemEstoque::findOrFail($id);
    }

    #[OA\Put(
        path: '/itens-estoque/{id}',
        operationId: 'itens-estoque.update',
        summary: 'Atualizar registro',
        description: 'Atualiza os dados de um item de estoque existente',
        tags: ['Itens de Estoque'],
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/ItemEstoque')),
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Registro atualizado', content: new OA\JsonContent(ref: '#/components/schemas/ItemEstoque')),
            new OA\Response(response: 404, description: 'Registro não encontrado'),
            new OA\Response(response: 422, description: 'Dados inválidos'),
        ]
    )]
    public function update(UpdateItemEstoqueRequest $request, int $id)
    {
        $itemEstoque = ItemEstoque::findOrFail($id);

        $itemEstoque->update($request->validated());

        return $itemEstoque;
    }

    #[OA\Delete(
        path: '/itens-estoque/{id}',
        operationId: 'itens-estoque.destroy',
        summary: 'Excluir registro',
        description: 'Remove um item de estoque do sistema',
        tags: ['Itens de Estoque'],
        security: [['bearerAuth' => []]],
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 204, description: 'Registro excluído'),
            new OA\Response(response: 404, description: 'Registro não encontrado'),
        ]
    )]
    public function destroy(int $id)
    {
        $itemEstoque = ItemEstoque::findOrFail($id);
        $itemEstoque->delete();

        return response()->noContent();
    }
}
