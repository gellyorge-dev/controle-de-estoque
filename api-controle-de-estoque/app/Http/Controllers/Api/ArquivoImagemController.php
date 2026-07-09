<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArquivoImagemRequest;
use App\Http\Requests\UpdateArquivoImagemRequest;
use App\Models\ArquivoImagem;
use OpenApi\Attributes as OA;

class ArquivoImagemController extends Controller
{
    #[OA\Get(
        path: '/arquivos-imagem',
        operationId: 'arquivos-imagem.index',
        summary: 'Listar todos os registros',
        description: 'Retorna uma lista paginada de arquivos de imagem',
        tags: ['Arquivos de Imagem'],
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Lista de arquivos de imagem', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/ArquivoImagem'))),
        ]
    )]
    public function index()
    {
        return ArquivoImagem::all();
    }

    #[OA\Post(
        path: '/arquivos-imagem',
        operationId: 'arquivos-imagem.store',
        summary: 'Criar novo registro',
        description: 'Cria um novo arquivo de imagem com os dados enviados',
        tags: ['Arquivos de Imagem'],
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/ArquivoImagem')),
        responses: [
            new OA\Response(response: 201, description: 'Registro criado com sucesso', content: new OA\JsonContent(ref: '#/components/schemas/ArquivoImagem')),
            new OA\Response(response: 422, description: 'Dados inválidos'),
        ]
    )]
    public function store(StoreArquivoImagemRequest $request)
    {
        return response()->json(ArquivoImagem::create($request->validated()), 201);
    }

    #[OA\Get(
        path: '/arquivos-imagem/{id}',
        operationId: 'arquivos-imagem.show',
        summary: 'Exibir registro',
        description: 'Retorna os dados de um arquivo de imagem específico',
        tags: ['Arquivos de Imagem'],
        security: [['bearerAuth' => []]],
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Dados do arquivo de imagem', content: new OA\JsonContent(ref: '#/components/schemas/ArquivoImagem')),
            new OA\Response(response: 404, description: 'Registro não encontrado'),
        ]
    )]
    public function show(int $id)
    {
        return ArquivoImagem::findOrFail($id);
    }

    #[OA\Put(
        path: '/arquivos-imagem/{id}',
        operationId: 'arquivos-imagem.update',
        summary: 'Atualizar registro',
        description: 'Atualiza os dados de um arquivo de imagem existente',
        tags: ['Arquivos de Imagem'],
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/ArquivoImagem')),
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Registro atualizado', content: new OA\JsonContent(ref: '#/components/schemas/ArquivoImagem')),
            new OA\Response(response: 404, description: 'Registro não encontrado'),
            new OA\Response(response: 422, description: 'Dados inválidos'),
        ]
    )]
    public function update(UpdateArquivoImagemRequest $request, int $id)
    {
        $arquivoImagem = ArquivoImagem::findOrFail($id);

        $arquivoImagem->update($request->validated());

        return $arquivoImagem;
    }

    #[OA\Delete(
        path: '/arquivos-imagem/{id}',
        operationId: 'arquivos-imagem.destroy',
        summary: 'Excluir registro',
        description: 'Remove um arquivo de imagem do sistema',
        tags: ['Arquivos de Imagem'],
        security: [['bearerAuth' => []]],
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 204, description: 'Registro excluído'),
            new OA\Response(response: 404, description: 'Registro não encontrado'),
        ]
    )]
    public function destroy(int $id)
    {
        $arquivoImagem = ArquivoImagem::findOrFail($id);
        $arquivoImagem->delete();

        return response()->noContent();
    }
}
