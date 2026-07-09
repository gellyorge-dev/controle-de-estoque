<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMarcaEquipamentoRequest;
use App\Http\Requests\UpdateMarcaEquipamentoRequest;
use App\Models\MarcaEquipamento;
use OpenApi\Attributes as OA;

class MarcaEquipamentoController extends Controller
{
    #[OA\Get(
        path: '/marcas-equipamento',
        operationId: 'marcas-equipamento.index',
        summary: 'Listar todos os registros',
        description: 'Retorna uma lista paginada de marcas de equipamento',
        tags: ['Marcas de Equipamento'],
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Lista de marcas de equipamento', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/MarcaEquipamento'))),
        ]
    )]
    public function index()
    {
        return MarcaEquipamento::all();
    }

    #[OA\Post(
        path: '/marcas-equipamento',
        operationId: 'marcas-equipamento.store',
        summary: 'Criar novo registro',
        description: 'Cria um novo marca de equipamento com os dados enviados',
        tags: ['Marcas de Equipamento'],
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/MarcaEquipamento')),
        responses: [
            new OA\Response(response: 201, description: 'Registro criado com sucesso', content: new OA\JsonContent(ref: '#/components/schemas/MarcaEquipamento')),
            new OA\Response(response: 422, description: 'Dados inválidos'),
        ]
    )]
    public function store(StoreMarcaEquipamentoRequest $request)
    {
        return response()->json(MarcaEquipamento::create($request->validated()), 201);
    }

    #[OA\Get(
        path: '/marcas-equipamento/{id}',
        operationId: 'marcas-equipamento.show',
        summary: 'Exibir registro',
        description: 'Retorna os dados de um marca de equipamento específico',
        tags: ['Marcas de Equipamento'],
        security: [['bearerAuth' => []]],
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Dados do marca de equipamento', content: new OA\JsonContent(ref: '#/components/schemas/MarcaEquipamento')),
            new OA\Response(response: 404, description: 'Registro não encontrado'),
        ]
    )]
    public function show(int $id)
    {
        return MarcaEquipamento::findOrFail($id);
    }

    #[OA\Put(
        path: '/marcas-equipamento/{id}',
        operationId: 'marcas-equipamento.update',
        summary: 'Atualizar registro',
        description: 'Atualiza os dados de um marca de equipamento existente',
        tags: ['Marcas de Equipamento'],
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/MarcaEquipamento')),
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Registro atualizado', content: new OA\JsonContent(ref: '#/components/schemas/MarcaEquipamento')),
            new OA\Response(response: 404, description: 'Registro não encontrado'),
            new OA\Response(response: 422, description: 'Dados inválidos'),
        ]
    )]
    public function update(UpdateMarcaEquipamentoRequest $request, int $id)
    {
        $marcaEquipamento = MarcaEquipamento::findOrFail($id);

        $marcaEquipamento->update($request->validated());

        return $marcaEquipamento;
    }

    #[OA\Delete(
        path: '/marcas-equipamento/{id}',
        operationId: 'marcas-equipamento.destroy',
        summary: 'Excluir registro',
        description: 'Remove um marca de equipamento do sistema',
        tags: ['Marcas de Equipamento'],
        security: [['bearerAuth' => []]],
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 204, description: 'Registro excluído'),
            new OA\Response(response: 404, description: 'Registro não encontrado'),
        ]
    )]
    public function destroy(int $id)
    {
        $marcaEquipamento = MarcaEquipamento::findOrFail($id);
        $marcaEquipamento->delete();

        return response()->noContent();
    }
}
