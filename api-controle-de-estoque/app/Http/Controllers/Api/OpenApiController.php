<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use OpenApi\Attributes as OA;

#[OA\OpenApi(
    openapi: '3.1.0',
    info: new OA\Info(
        version: '1.0.0',
        title: 'API Controle de Estoque',
        description: 'API para controle de patrimônio e estoque'
    ),
    servers: [
        new OA\Server(url: '/api', description: 'API Server'),
    ],
    security: [
        ['bearerAuth' => []],
    ],
    tags: [
        new OA\Tag(name: 'Autenticação', description: 'Endpoints de autenticação'),
        new OA\Tag(name: 'Unidades Organizacionais', description: 'CRUD de unidades organizacionais'),
        new OA\Tag(name: 'Espaços de Armazenamento', description: 'CRUD de espaços de armazenamento'),
        new OA\Tag(name: 'Marcas de Equipamento', description: 'CRUD de marcas de equipamento'),
        new OA\Tag(name: 'Tipos de Equipamento', description: 'CRUD de tipos de equipamento'),
        new OA\Tag(name: 'Condições Operacionais', description: 'CRUD de condições operacionais de equipamento'),
        new OA\Tag(name: 'Perfis de Usuário', description: 'CRUD de perfis de usuário'),
        new OA\Tag(name: 'Arquivos de Imagem', description: 'CRUD de arquivos de imagem'),
        new OA\Tag(name: 'Usuários do Sistema', description: 'CRUD de usuários do sistema'),
        new OA\Tag(name: 'Equipamentos Patrimoniados', description: 'CRUD de equipamentos patrimoniados'),
        new OA\Tag(name: 'Itens de Estoque', description: 'CRUD de itens de estoque'),
        new OA\Tag(name: 'Registros de Auditoria', description: 'Consulta de registros de auditoria'),
    ]
)]
#[OA\SecurityScheme(
    securityScheme: 'bearerAuth',
    type: 'http',
    scheme: 'bearer',
    bearerFormat: 'JWT',
    description: 'Token de autenticação (Sanctum)'
)]
#[OA\Schema(
    schema: 'LoginRequest',
    description: 'Credenciais de login',
    properties: [
        new OA\Property(property: 'login_usuario', type: 'string', description: 'Login do usuário'),
        new OA\Property(property: 'senha_usuario', type: 'string', description: 'Senha do usuário'),
    ]
)]
#[OA\Schema(
    schema: 'LoginResponse',
    description: 'Resposta do login',
    properties: [
        new OA\Property(property: 'usuario', ref: '#/components/schemas/UsuarioSistema', description: 'Dados do usuário autenticado'),
        new OA\Property(property: 'token', type: 'string', description: 'Token de autenticação'),
    ]
)]
#[OA\Schema(
    schema: 'UnidadeOrganizacional',
    description: 'Unidade organizacional',
    properties: [
        new OA\Property(property: 'id', type: 'integer', description: 'ID da unidade'),
        new OA\Property(property: 'nome', type: 'string', description: 'Nome da unidade'),
        new OA\Property(property: 'created_at', type: 'string', format: 'date-time', description: 'Data de criação', nullable: true),
    ]
)]
#[OA\Schema(
    schema: 'EspacoArmazenamento',
    description: 'Espaço de armazenamento',
    properties: [
        new OA\Property(property: 'id', type: 'integer', description: 'ID do espaço'),
        new OA\Property(property: 'unidade_organizacional_id', type: 'integer', description: 'ID da unidade organizacional'),
        new OA\Property(property: 'nome', type: 'string', description: 'Nome do espaço'),
        new OA\Property(property: 'descricao', type: 'string', description: 'Descrição do espaço', nullable: true),
        new OA\Property(property: 'created_at', type: 'string', format: 'date-time', description: 'Data de criação', nullable: true),
    ]
)]
#[OA\Schema(
    schema: 'MarcaEquipamento',
    description: 'Marca de equipamento',
    properties: [
        new OA\Property(property: 'id', type: 'integer', description: 'ID da marca'),
        new OA\Property(property: 'nome', type: 'string', description: 'Nome da marca'),
    ]
)]
#[OA\Schema(
    schema: 'TipoEquipamento',
    description: 'Tipo de equipamento',
    properties: [
        new OA\Property(property: 'id', type: 'integer', description: 'ID do tipo'),
        new OA\Property(property: 'nome', type: 'string', description: 'Nome do tipo'),
    ]
)]
#[OA\Schema(
    schema: 'CondicaoOperacionalEquipamento',
    description: 'Condição operacional de equipamento',
    properties: [
        new OA\Property(property: 'id', type: 'integer', description: 'ID da condição'),
        new OA\Property(property: 'nome', type: 'string', description: 'Nome da condição'),
    ]
)]
#[OA\Schema(
    schema: 'PerfilUsuario',
    description: 'Perfil de usuário',
    properties: [
        new OA\Property(property: 'id', type: 'integer', description: 'ID do perfil'),
        new OA\Property(property: 'nome', type: 'string', description: 'Nome do perfil'),
    ]
)]
#[OA\Schema(
    schema: 'ArquivoImagem',
    description: 'Arquivo de imagem',
    properties: [
        new OA\Property(property: 'id', type: 'integer', description: 'ID do arquivo'),
        new OA\Property(property: 'nome_arquivo', type: 'string', description: 'Nome original do arquivo'),
        new OA\Property(property: 'caminho', type: 'string', description: 'Caminho de armazenamento'),
        new OA\Property(property: 'mime_type', type: 'string', description: 'Tipo MIME do arquivo', nullable: true),
        new OA\Property(property: 'tamanho', type: 'integer', description: 'Tamanho do arquivo em bytes', nullable: true),
        new OA\Property(property: 'hash', type: 'string', description: 'Hash SHA-256 do arquivo', nullable: true),
        new OA\Property(property: 'created_at', type: 'string', format: 'date-time', description: 'Data de upload'),
    ]
)]
#[OA\Schema(
    schema: 'UsuarioSistema',
    description: 'Usuário do sistema',
    properties: [
        new OA\Property(property: 'id', type: 'integer', description: 'ID do usuário'),
        new OA\Property(property: 'perfil_usuario_id', type: 'integer', description: 'ID do perfil de usuário'),
        new OA\Property(property: 'arquivo_imagem_id', type: 'integer', description: 'ID da imagem do perfil', nullable: true),
        new OA\Property(property: 'nome_usuario', type: 'string', description: 'Nome completo do usuário'),
        new OA\Property(property: 'login_usuario', type: 'string', description: 'Login de acesso'),
        new OA\Property(property: 'ativo', type: 'boolean', description: 'Indica se o usuário está ativo'),
        new OA\Property(property: 'created_at', type: 'string', format: 'date-time', description: 'Data de criação', nullable: true),
        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', description: 'Data de atualização', nullable: true),
    ]
)]
#[OA\Schema(
    schema: 'EquipamentoPatrimoniado',
    description: 'Equipamento patrimoniado',
    properties: [
        new OA\Property(property: 'id', type: 'integer', description: 'ID do equipamento'),
        new OA\Property(property: 'numero_patrimonio', type: 'integer', description: 'Número do patrimônio'),
        new OA\Property(property: 'numero_serie', type: 'string', description: 'Número de série', nullable: true),
        new OA\Property(property: 'espaco_armazenamento_id', type: 'integer', description: 'ID do espaço de armazenamento'),
        new OA\Property(property: 'marca_equipamento_id', type: 'integer', description: 'ID da marca', nullable: true),
        new OA\Property(property: 'tipo_equipamento_id', type: 'integer', description: 'ID do tipo de equipamento', nullable: true),
        new OA\Property(property: 'condicao_operacional_equipamento_id', type: 'integer', description: 'ID da condição operacional'),
        new OA\Property(property: 'arquivo_imagem_id', type: 'integer', description: 'ID da imagem do equipamento', nullable: true),
        new OA\Property(property: 'nome_equipamento', type: 'string', description: 'Nome do equipamento'),
        new OA\Property(property: 'descricao_equipamento', type: 'string', description: 'Descrição do equipamento', nullable: true),
        new OA\Property(property: 'informado_ao_patrimonio', type: 'boolean', description: 'Informado ao setor de patrimônio'),
        new OA\Property(property: 'local_anterior', type: 'string', description: 'Local anterior do equipamento', nullable: true),
        new OA\Property(property: 'destino', type: 'string', description: 'Destino do equipamento', nullable: true),
        new OA\Property(property: 'observacoes_equipamento', type: 'string', description: 'Observações', nullable: true),
        new OA\Property(property: 'created_at', type: 'string', format: 'date-time', description: 'Data de criação', nullable: true),
        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', description: 'Data de atualização', nullable: true),
    ]
)]
#[OA\Schema(
    schema: 'ItemEstoque',
    description: 'Item de estoque',
    properties: [
        new OA\Property(property: 'id', type: 'integer', description: 'ID do item'),
        new OA\Property(property: 'espaco_armazenamento_id', type: 'integer', description: 'ID do espaço de armazenamento'),
        new OA\Property(property: 'arquivo_imagem_id', type: 'integer', description: 'ID da imagem do item', nullable: true),
        new OA\Property(property: 'nome_item', type: 'string', description: 'Nome do item'),
        new OA\Property(property: 'descricao_item', type: 'string', description: 'Descrição do item', nullable: true),
        new OA\Property(property: 'quantidade', type: 'integer', description: 'Quantidade em estoque'),
        new OA\Property(property: 'observacoes_item', type: 'string', description: 'Observações', nullable: true),
        new OA\Property(property: 'created_at', type: 'string', format: 'date-time', description: 'Data de criação', nullable: true),
        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', description: 'Data de atualização', nullable: true),
    ]
)]
#[OA\Schema(
    schema: 'RegistroAuditoria',
    description: 'Registro de auditoria',
    properties: [
        new OA\Property(property: 'id', type: 'integer', description: 'ID do registro'),
        new OA\Property(property: 'usuario_sistema_id', type: 'integer', description: 'ID do usuário que realizou a ação'),
        new OA\Property(property: 'nome_tabela', type: 'string', description: 'Nome da tabela alterada'),
        new OA\Property(property: 'identificador_registro', type: 'integer', description: 'ID do registro alterado'),
        new OA\Property(property: 'tipo_acao', type: 'string', description: 'Tipo de ação (create/update/delete)'),
        new OA\Property(property: 'valor_anterior', type: 'string', description: 'Valor anterior (JSON)', nullable: true),
        new OA\Property(property: 'valor_novo', type: 'string', description: 'Valor novo (JSON)', nullable: true),
        new OA\Property(property: 'observacao', type: 'string', description: 'Observação', nullable: true),
        new OA\Property(property: 'created_at', type: 'string', format: 'date-time', description: 'Data do registro'),
    ]
)]
class OpenApiController extends Controller
{
    //
}
