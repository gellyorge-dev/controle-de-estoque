CREATE DATABASE IF NOT EXISTS sti_patrimonio
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE sti_patrimonio;


-- =====================================================
-- UNIDADE ORGANIZACIONAL
-- Exemplo:
-- Prefeitura
-- Secretaria de Educação
-- Escola Municipal
-- =====================================================

CREATE TABLE unidade_organizacional (
    id INT AUTO_INCREMENT PRIMARY KEY,

    nome VARCHAR(150) NOT NULL UNIQUE,

    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);


-- =====================================================
-- ESPAÇO DE ARMAZENAMENTO
-- Exemplo:
-- Armário 01
-- Depósito
-- Bancada de manutenção
-- =====================================================

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


-- =====================================================
-- MARCA DE EQUIPAMENTO
-- Exemplo:
-- Dell
-- Lenovo
-- HP
-- Intelbras
-- =====================================================

CREATE TABLE marca_equipamento (
    id INT AUTO_INCREMENT PRIMARY KEY,

    nome VARCHAR(100) NOT NULL UNIQUE
);


-- =====================================================
-- TIPO DE EQUIPAMENTO
-- Exemplo:
-- Notebook
-- Monitor
-- Switch
-- Impressora
-- =====================================================

CREATE TABLE tipo_equipamento (
    id INT AUTO_INCREMENT PRIMARY KEY,

    nome VARCHAR(100) NOT NULL UNIQUE
);


-- =====================================================
-- CONDIÇÃO OPERACIONAL
-- Exemplo:
-- Funcionando
-- Em manutenção
-- Defeituoso
-- Baixado
-- =====================================================

CREATE TABLE condicao_operacional_equipamento (
    id INT AUTO_INCREMENT PRIMARY KEY,

    nome VARCHAR(100) NOT NULL UNIQUE
);


-- =====================================================
-- PERFIL DE USUÁRIO
-- =====================================================

CREATE TABLE perfil_usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,

    nome VARCHAR(100) NOT NULL UNIQUE
);


-- =====================================================
-- ARQUIVO DE IMAGEM
-- =====================================================

CREATE TABLE arquivo_imagem (
    id INT AUTO_INCREMENT PRIMARY KEY,

    nome_arquivo VARCHAR(255) NOT NULL,

    caminho VARCHAR(500) NOT NULL,

    mime_type VARCHAR(100),

    tamanho BIGINT,

    hash VARCHAR(255),

    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);


-- =====================================================
-- USUÁRIO DO SISTEMA
-- =====================================================

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


-- =====================================================
-- EQUIPAMENTO PATRIMONIADO
-- Exemplo:
-- Notebook Dell Latitude 5420
-- Patrimônio 12345
-- =====================================================

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



-- =====================================================
-- ITEM DE ESTOQUE
-- Exemplo:
-- Caixa de parafuso Philips
-- Quantidade 500
-- =====================================================

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



-- =====================================================
-- REGISTRO DE AUDITORIA
-- Guarda:
-- quem alterou
-- qual tabela
-- qual registro
-- antes/depois
-- =====================================================

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



-- =====================================================
-- ÍNDICES
-- =====================================================


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