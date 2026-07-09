<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTipoEquipamentoRequest;
use App\Http\Requests\UpdateTipoEquipamentoRequest;
use App\Models\TipoEquipamento;
use OpenApi\Attributes as OA;

class TipoEquipamentoController extends Controller
{
    #[OA\Get(
        path: '/tipos-equipamento',
        operationId: 'tipos-equipamento.index',
        summary: 'Listar todos os registros',
        description: 'Retorna uma lista paginada de tipos de equipamento',
        tags: ['Tipos de Equipamento'],
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Lista de tipos de equipamento', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/TipoEquipamento'))),
        ]
    )]
    public function index()
    {
        return TipoEquipamento::all();
    }

    #[OA\Post(
        path: '/tipos-equipamento',
        operationId: 'tipos-equipamento.store',
        summary: 'Criar novo registro',
        description: 'Cria um novo tipo de equipamento com os dados enviados',
        tags: ['Tipos de Equipamento'],
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/TipoEquipamento')),
        responses: [
            new OA\Response(response: 201, description: 'Registro criado com sucesso', content: new OA\JsonContent(ref: '#/components/schemas/TipoEquipamento')),
            new OA\Response(response: 422, description: 'Dados inválidos'),
        ]
    )]
    public function store(StoreTipoEquipamentoRequest $request)
    {
        return response()->json(TipoEquipamento::create($request->validated()), 201);
    }

    #[OA\Get(
        path: '/tipos-equipamento/{id}',
        operationId: 'tipos-equipamento.show',
        summary: 'Exibir registro',
        description: 'Retorna os dados de um tipo de equipamento específico',
        tags: ['Tipos de Equipamento'],
        security: [['bearerAuth' => []]],
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Dados do tipo de equipamento', content: new OA\JsonContent(ref: '#/components/schemas/TipoEquipamento')),
            new OA\Response(response: 404, description: 'Registro não encontrado'),
        ]
    )]
    public function show(int $id)
    {
        return TipoEquipamento::findOrFail($id);
    }

    #[OA\Put(
        path: '/tipos-equipamento/{id}',
        operationId: 'tipos-equipamento.update',
        summary: 'Atualizar registro',
        description: 'Atualiza os dados de um tipo de equipamento existente',
        tags: ['Tipos de Equipamento'],
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/TipoEquipamento')),
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Registro atualizado', content: new OA\JsonContent(ref: '#/components/schemas/TipoEquipamento')),
            new OA\Response(response: 404, description: 'Registro não encontrado'),
            new OA\Response(response: 422, description: 'Dados inválidos'),
        ]
    )]
    public function update(UpdateTipoEquipamentoRequest $request, int $id)
    {
        $tipoEquipamento = TipoEquipamento::findOrFail($id);

        $tipoEquipamento->update($request->validated());

        return $tipoEquipamento;
    }

    #[OA\Delete(
        path: '/tipos-equipamento/{id}',
        operationId: 'tipos-equipamento.destroy',
        summary: 'Excluir registro',
        description: 'Remove um tipo de equipamento do sistema',
        tags: ['Tipos de Equipamento'],
        security: [['bearerAuth' => []]],
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 204, description: 'Registro excluído'),
            new OA\Response(response: 404, description: 'Registro não encontrado'),
        ]
    )]
    public function destroy(int $id)
    {
        $tipoEquipamento = TipoEquipamento::findOrFail($id);
        $tipoEquipamento->delete();

        return response()->noContent();
    }
}
