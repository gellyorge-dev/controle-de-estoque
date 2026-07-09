<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUnidadeOrganizacionalRequest;
use App\Http\Requests\UpdateUnidadeOrganizacionalRequest;
use App\Models\UnidadeOrganizacional;
use OpenApi\Attributes as OA;

class UnidadeOrganizacionalController extends Controller
{
    #[OA\Get(
        path: '/unidades-organizacionais',
        operationId: 'unidades-organizacionais.index',
        summary: 'Listar todos os registros',
        description: 'Retorna uma lista paginada de unidades organizacionais',
        tags: ['Unidades Organizacionais'],
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Lista de unidades organizacionais', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/UnidadeOrganizacional'))),
        ]
    )]
    public function index()
    {
        return UnidadeOrganizacional::all();
    }

    #[OA\Post(
        path: '/unidades-organizacionais',
        operationId: 'unidades-organizacionais.store',
        summary: 'Criar novo registro',
        description: 'Cria um novo unidade organizacional com os dados enviados',
        tags: ['Unidades Organizacionais'],
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/UnidadeOrganizacional')),
        responses: [
            new OA\Response(response: 201, description: 'Registro criado com sucesso', content: new OA\JsonContent(ref: '#/components/schemas/UnidadeOrganizacional')),
            new OA\Response(response: 422, description: 'Dados inválidos'),
        ]
    )]
    public function store(StoreUnidadeOrganizacionalRequest $request)
    {
        return response()->json(UnidadeOrganizacional::create($request->validated()), 201);
    }

    #[OA\Get(
        path: '/unidades-organizacionais/{id}',
        operationId: 'unidades-organizacionais.show',
        summary: 'Exibir registro',
        description: 'Retorna os dados de um unidade organizacional específico',
        tags: ['Unidades Organizacionais'],
        security: [['bearerAuth' => []]],
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Dados do unidade organizacional', content: new OA\JsonContent(ref: '#/components/schemas/UnidadeOrganizacional')),
            new OA\Response(response: 404, description: 'Registro não encontrado'),
        ]
    )]
    public function show(int $id)
    {
        return UnidadeOrganizacional::findOrFail($id);
    }

    #[OA\Put(
        path: '/unidades-organizacionais/{id}',
        operationId: 'unidades-organizacionais.update',
        summary: 'Atualizar registro',
        description: 'Atualiza os dados de um unidade organizacional existente',
        tags: ['Unidades Organizacionais'],
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/UnidadeOrganizacional')),
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Registro atualizado', content: new OA\JsonContent(ref: '#/components/schemas/UnidadeOrganizacional')),
            new OA\Response(response: 404, description: 'Registro não encontrado'),
            new OA\Response(response: 422, description: 'Dados inválidos'),
        ]
    )]
    public function update(UpdateUnidadeOrganizacionalRequest $request, int $id)
    {
        $unidadeOrganizacional = UnidadeOrganizacional::findOrFail($id);

        $unidadeOrganizacional->update($request->validated());

        return $unidadeOrganizacional;
    }

    #[OA\Delete(
        path: '/unidades-organizacionais/{id}',
        operationId: 'unidades-organizacionais.destroy',
        summary: 'Excluir registro',
        description: 'Remove um unidade organizacional do sistema',
        tags: ['Unidades Organizacionais'],
        security: [['bearerAuth' => []]],
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 204, description: 'Registro excluído'),
            new OA\Response(response: 404, description: 'Registro não encontrado'),
        ]
    )]
    public function destroy(int $id)
    {
        $unidadeOrganizacional = UnidadeOrganizacional::findOrFail($id);
        $unidadeOrganizacional->delete();

        return response()->noContent();
    }
}
