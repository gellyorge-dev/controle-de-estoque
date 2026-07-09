<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEquipamentoPatrimoniadoRequest;
use App\Http\Requests\UpdateEquipamentoPatrimoniadoRequest;
use App\Models\EquipamentoPatrimoniado;
use OpenApi\Attributes as OA;

class EquipamentoPatrimoniadoController extends Controller
{
    #[OA\Get(
        path: '/equipamentos-patrimoniados',
        operationId: 'equipamentos-patrimoniados.index',
        summary: 'Listar todos os registros',
        description: 'Retorna uma lista paginada de equipamentos patrimoniados',
        tags: ['Equipamentos Patrimoniados'],
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Lista de equipamentos patrimoniados', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/EquipamentoPatrimoniado'))),
        ]
    )]
    public function index()
    {
        return EquipamentoPatrimoniado::all();
    }

    #[OA\Post(
        path: '/equipamentos-patrimoniados',
        operationId: 'equipamentos-patrimoniados.store',
        summary: 'Criar novo registro',
        description: 'Cria um novo equipamento patrimoniado com os dados enviados',
        tags: ['Equipamentos Patrimoniados'],
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/EquipamentoPatrimoniado')),
        responses: [
            new OA\Response(response: 201, description: 'Registro criado com sucesso', content: new OA\JsonContent(ref: '#/components/schemas/EquipamentoPatrimoniado')),
            new OA\Response(response: 422, description: 'Dados inválidos'),
        ]
    )]
    public function store(StoreEquipamentoPatrimoniadoRequest $request)
    {
        return response()->json(EquipamentoPatrimoniado::create($request->validated()), 201);
    }

    #[OA\Get(
        path: '/equipamentos-patrimoniados/{id}',
        operationId: 'equipamentos-patrimoniados.show',
        summary: 'Exibir registro',
        description: 'Retorna os dados de um equipamento patrimoniado específico',
        tags: ['Equipamentos Patrimoniados'],
        security: [['bearerAuth' => []]],
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Dados do equipamento patrimoniado', content: new OA\JsonContent(ref: '#/components/schemas/EquipamentoPatrimoniado')),
            new OA\Response(response: 404, description: 'Registro não encontrado'),
        ]
    )]
    public function show(int $id)
    {
        return EquipamentoPatrimoniado::findOrFail($id);
    }

    #[OA\Put(
        path: '/equipamentos-patrimoniados/{id}',
        operationId: 'equipamentos-patrimoniados.update',
        summary: 'Atualizar registro',
        description: 'Atualiza os dados de um equipamento patrimoniado existente',
        tags: ['Equipamentos Patrimoniados'],
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/EquipamentoPatrimoniado')),
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Registro atualizado', content: new OA\JsonContent(ref: '#/components/schemas/EquipamentoPatrimoniado')),
            new OA\Response(response: 404, description: 'Registro não encontrado'),
            new OA\Response(response: 422, description: 'Dados inválidos'),
        ]
    )]
    public function update(UpdateEquipamentoPatrimoniadoRequest $request, int $id)
    {
        $equipamentoPatrimoniado = EquipamentoPatrimoniado::findOrFail($id);

        $equipamentoPatrimoniado->update($request->validated());

        return $equipamentoPatrimoniado;
    }

    #[OA\Delete(
        path: '/equipamentos-patrimoniados/{id}',
        operationId: 'equipamentos-patrimoniados.destroy',
        summary: 'Excluir registro',
        description: 'Remove um equipamento patrimoniado do sistema',
        tags: ['Equipamentos Patrimoniados'],
        security: [['bearerAuth' => []]],
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 204, description: 'Registro excluído'),
            new OA\Response(response: 404, description: 'Registro não encontrado'),
        ]
    )]
    public function destroy(int $id)
    {
        $equipamentoPatrimoniado = EquipamentoPatrimoniado::findOrFail($id);
        $equipamentoPatrimoniado->delete();

        return response()->noContent();
    }
}
