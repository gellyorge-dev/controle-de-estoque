<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared('
CREATE TABLE unidade_organizacional (
    id INT AUTO_INCREMENT PRIMARY KEY,

    nome VARCHAR(150) NOT NULL UNIQUE,

    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE espaco_armazenamento (
    id INT AUTO_INCREMENT PRIMARY KEY,

    unidade_organizacional_id INT NOT NULL,

    nome VARCHAR(150) NOT NULL,

    descricao VARCHAR(255),

    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,


    CONSTRAINT fk_espaco_armazenamento_unidade
        FOREIGN KEY (unidade_organizacional_id)
        REFERENCES unidade_organizacional(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);

CREATE TABLE marca_equipamento (
    id INT AUTO_INCREMENT PRIMARY KEY,

    nome VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE tipo_equipamento (
    id INT AUTO_INCREMENT PRIMARY KEY,

    nome VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE condicao_operacional_equipamento (
    id INT AUTO_INCREMENT PRIMARY KEY,

    nome VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE perfil_usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,

    nome VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE arquivo_imagem (
    id INT AUTO_INCREMENT PRIMARY KEY,

    nome_arquivo VARCHAR(255) NOT NULL,

    caminho VARCHAR(500) NOT NULL,

    mime_type VARCHAR(100),

    tamanho BIGINT,

    hash VARCHAR(255),

    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE usuario_sistema (
    id INT AUTO_INCREMENT PRIMARY KEY,

    perfil_usuario_id INT NOT NULL,

    arquivo_imagem_id INT NULL,

    nome_usuario VARCHAR(150) NOT NULL,

    login_usuario VARCHAR(100) NOT NULL UNIQUE,

    senha_usuario VARCHAR(255) NOT NULL,

    ativo BOOLEAN NOT NULL DEFAULT TRUE,

    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,


    CONSTRAINT fk_usuario_perfil
        FOREIGN KEY (perfil_usuario_id)
        REFERENCES perfil_usuario(id),


    CONSTRAINT fk_usuario_imagem
        FOREIGN KEY (arquivo_imagem_id)
        REFERENCES arquivo_imagem(id)
);

CREATE TABLE equipamento_patrimoniado (

    id INT AUTO_INCREMENT PRIMARY KEY,


    numero_patrimonio INT NOT NULL UNIQUE,


    numero_serie VARCHAR(150),


    espaco_armazenamento_id INT NOT NULL,


    marca_equipamento_id INT,


    tipo_equipamento_id INT,


    condicao_operacional_equipamento_id INT NOT NULL,


    arquivo_imagem_id INT NULL,


    nome_equipamento VARCHAR(150) NOT NULL,


    descricao_equipamento TEXT,


    informado_ao_patrimonio BOOLEAN NOT NULL DEFAULT FALSE,


    local_anterior VARCHAR(255),


    destino VARCHAR(255),


    observacoes_equipamento TEXT,


    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,


    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,


    CONSTRAINT fk_equipamento_espaco
        FOREIGN KEY (espaco_armazenamento_id)
        REFERENCES espaco_armazenamento(id),


    CONSTRAINT fk_equipamento_marca
        FOREIGN KEY (marca_equipamento_id)
        REFERENCES marca_equipamento(id),


    CONSTRAINT fk_equipamento_tipo
        FOREIGN KEY (tipo_equipamento_id)
        REFERENCES tipo_equipamento(id),


    CONSTRAINT fk_equipamento_condicao
        FOREIGN KEY (condicao_operacional_equipamento_id)
        REFERENCES condicao_operacional_equipamento(id),


    CONSTRAINT fk_equipamento_imagem
        FOREIGN KEY (arquivo_imagem_id)
        REFERENCES arquivo_imagem(id)
);

CREATE TABLE item_estoque (

    id INT AUTO_INCREMENT PRIMARY KEY,


    espaco_armazenamento_id INT NOT NULL,


    arquivo_imagem_id INT NULL,


    nome_item VARCHAR(150) NOT NULL,


    descricao_item TEXT,


    quantidade INT NOT NULL DEFAULT 0,


    observacoes_item TEXT,


    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,


    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,


    CONSTRAINT fk_item_estoque_espaco
        FOREIGN KEY (espaco_armazenamento_id)
        REFERENCES espaco_armazenamento(id),


    CONSTRAINT fk_item_estoque_imagem
        FOREIGN KEY (arquivo_imagem_id)
        REFERENCES arquivo_imagem(id)

);

CREATE TABLE registro_auditoria (

    id INT AUTO_INCREMENT PRIMARY KEY,


    usuario_sistema_id INT NOT NULL,


    nome_tabela VARCHAR(100) NOT NULL,


    identificador_registro INT NOT NULL,


    tipo_acao VARCHAR(30) NOT NULL,


    valor_anterior TEXT,


    valor_novo TEXT,


    observacao TEXT,


    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,


    CONSTRAINT fk_auditoria_usuario
        FOREIGN KEY (usuario_sistema_id)
        REFERENCES usuario_sistema(id)

);

CREATE INDEX idx_equipamento_numero_patrimonio
ON equipamento_patrimoniado(numero_patrimonio);

CREATE INDEX idx_equipamento_nome
ON equipamento_patrimoniado(nome_equipamento);

CREATE INDEX idx_equipamento_localizacao
ON equipamento_patrimoniado(espaco_armazenamento_id);

CREATE INDEX idx_item_estoque_nome
ON item_estoque(nome_item);

CREATE INDEX idx_item_estoque_localizacao
ON item_estoque(espaco_armazenamento_id);

CREATE INDEX idx_auditoria_registro
ON registro_auditoria(nome_tabela, identificador_registro);
');
    }

    public function down(): void
    {
        DB::unprepared('
DROP TABLE IF EXISTS registro_auditoria;
DROP TABLE IF EXISTS equipamento_patrimoniado;
DROP TABLE IF EXISTS item_estoque;
DROP TABLE IF EXISTS usuario_sistema;
DROP TABLE IF EXISTS arquivo_imagem;
DROP TABLE IF EXISTS perfil_usuario;
DROP TABLE IF EXISTS condicao_operacional_equipamento;
DROP TABLE IF EXISTS tipo_equipamento;
DROP TABLE IF EXISTS marca_equipamento;
DROP TABLE IF EXISTS espaco_armazenamento;
DROP TABLE IF EXISTS unidade_organizacional;
');
    }
};
