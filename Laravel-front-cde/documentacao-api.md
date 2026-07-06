# Documentação da API - Controle de Estoque

Base URL: `/api`

---

## Tipos

### Listar todos

```
GET /api/tipos
```

Resposta:
```json
[
    {
        "id": 1,
        "nome_tipo": "Eletrônico",
        "created_at": "2026-07-06T00:00:00.000000Z",
        "updated_at": "2026-07-06T00:00:00.000000Z",
        "deleted_at": null
    }
]
```

### Listar apenas deletados (soft delete)

```
GET /api/tipos/trashed
```

### Criar

```
POST /api/tipos
Content-Type: application/json

{
    "nome_tipo": "Eletrônico"
}
```

Resposta (201):
```json
{
    "id": 1,
    "nome_tipo": "Eletrônico",
    "created_at": "2026-07-06T00:00:00.000000Z",
    "updated_at": "2026-07-06T00:00:00.000000Z",
    "deleted_at": null
}
```

### Mostrar

```
GET /api/tipos/{id}
```

### Atualizar

```
PUT /api/tipos/{id}
Content-Type: application/json

{
    "nome_tipo": "Móvel"
}
```

### Deletar (soft delete)

```
DELETE /api/tipos/{id}
```

Resposta: `204 No Content`

### Restaurar

```
PUT /api/tipos/{id}/restore
```

---

## Fabricantes

### Listar todos

```
GET /api/fabricantes
```

Resposta:
```json
[
    {
        "id": 1,
        "nome_fabricante": "Samsung",
        "created_at": "2026-07-06T00:00:00.000000Z",
        "updated_at": "2026-07-06T00:00:00.000000Z",
        "deleted_at": null
    }
]
```

### Listar apenas deletados (soft delete)

```
GET /api/fabricantes/trashed
```

### Criar

```
POST /api/fabricantes
Content-Type: application/json

{
    "nome_fabricante": "Samsung"
}
```

Resposta (201):
```json
{
    "id": 1,
    "nome_fabricante": "Samsung",
    "created_at": "2026-07-06T00:00:00.000000Z",
    "updated_at": "2026-07-06T00:00:00.000000Z",
    "deleted_at": null
}
```

### Mostrar

```
GET /api/fabricantes/{id}
```

### Atualizar

```
PUT /api/fabricantes/{id}
Content-Type: application/json

{
    "nome_fabricante": "LG"
}
```

### Deletar (soft delete)

```
DELETE /api/fabricantes/{id}
```

Resposta: `204 No Content`

### Restaurar

```
PUT /api/fabricantes/{id}/restore
```

---

## Localizações

### Listar todos

```
GET /api/localizacoes
```

Resposta:
```json
[
    {
        "id": 1,
        "localizacao_nome": "Sala A",
        "created_at": "2026-07-06T00:00:00.000000Z",
        "updated_at": "2026-07-06T00:00:00.000000Z",
        "deleted_at": null
    }
]
```

### Listar apenas deletados (soft delete)

```
GET /api/localizacoes/trashed
```

### Criar

```
POST /api/localizacoes
Content-Type: application/json

{
    "localizacao_nome": "Sala A"
}
```

Resposta (201):
```json
{
    "id": 1,
    "localizacao_nome": "Sala A",
    "created_at": "2026-07-06T00:00:00.000000Z",
    "updated_at": "2026-07-06T00:00:00.000000Z",
    "deleted_at": null
}
```

### Mostrar

```
GET /api/localizacoes/{id}
```

### Atualizar

```
PUT /api/localizacoes/{id}
Content-Type: application/json

{
    "localizacao_nome": "Sala B"
}
```

### Deletar (soft delete)

```
DELETE /api/localizacoes/{id}
```

Resposta: `204 No Content`

### Restaurar

```
PUT /api/localizacoes/{id}/restore
```

---

## Itens de Quantidade

### Listar todos

```
GET /api/itens-de-quantidade
```

Resposta:
```json
[
    {
        "id": 1,
        "id_tipo": 1,
        "id_fabricante": 1,
        "id_localizacao": 1,
        "quantidade": 10,
        "observacao": "Caixa azul",
        "created_at": "2026-07-06T00:00:00.000000Z",
        "updated_at": "2026-07-06T00:00:00.000000Z",
        "deleted_at": null,
        "tipo": {
            "id": 1,
            "nome_tipo": "Eletrônico",
            "created_at": "2026-07-06T00:00:00.000000Z",
            "updated_at": "2026-07-06T00:00:00.000000Z",
            "deleted_at": null
        },
        "fabricante": {
            "id": 1,
            "nome_fabricante": "Samsung",
            "created_at": "2026-07-06T00:00:00.000000Z",
            "updated_at": "2026-07-06T00:00:00.000000Z",
            "deleted_at": null
        },
        "localizacao": {
            "id": 1,
            "localizacao_nome": "Sala A",
            "created_at": "2026-07-06T00:00:00.000000Z",
            "updated_at": "2026-07-06T00:00:00.000000Z",
            "deleted_at": null
        }
    }
]
```

### Listar apenas deletados (soft delete)

```
GET /api/itens-de-quantidade/trashed
```

### Criar

```
POST /api/itens-de-quantidade
Content-Type: application/json

{
    "id_tipo": 1,
    "id_fabricante": 1,
    "id_localizacao": 1,
    "quantidade": 10,
    "observacao": "Caixa azul"
}
```

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| id_tipo | integer | sim | ID do tipo (deve existir em `tipos`) |
| id_fabricante | integer | sim | ID do fabricante (deve existir em `fabricantes`) |
| id_localizacao | integer | sim | ID da localização (deve existir em `localizacoes`) |
| quantidade | integer | sim | Mínimo 0 |
| observacao | string | não | |

Resposta (201):
```json
{
    "id": 1,
    "id_tipo": 1,
    "id_fabricante": 1,
    "id_localizacao": 1,
    "quantidade": 10,
    "observacao": "Caixa azul",
    "created_at": "2026-07-06T00:00:00.000000Z",
    "updated_at": "2026-07-06T00:00:00.000000Z",
    "deleted_at": null,
    "tipo": { ... },
    "fabricante": { ... },
    "localizacao": { ... }
}
```

### Mostrar

```
GET /api/itens-de-quantidade/{id}
```

### Atualizar

```
PUT /api/itens-de-quantidade/{id}
Content-Type: application/json

{
    "id_tipo": 1,
    "id_fabricante": 1,
    "id_localizacao": 1,
    "quantidade": 25,
    "observacao": "Atualizado"
}
```

### Deletar (soft delete)

```
DELETE /api/itens-de-quantidade/{id}
```

Resposta: `204 No Content`

### Restaurar

```
PUT /api/itens-de-quantidade/{id}/restore
```

Observação: a combinação `id_tipo` + `id_fabricante` + `id_localizacao` deve ser única.

---

## Itens Patrimoniados

### Listar todos

```
GET /api/itens-patrimoniados
```

Resposta:
```json
[
    {
        "id": 1,
        "patrimonio": 12345,
        "id_tipo": 1,
        "id_fabricante": 1,
        "id_localizacao": 1,
        "observacao": "Notebook",
        "created_at": "2026-07-06T00:00:00.000000Z",
        "updated_at": "2026-07-06T00:00:00.000000Z",
        "deleted_at": null,
        "tipo": { ... },
        "fabricante": { ... },
        "localizacao": { ... }
    }
]
```

### Listar apenas deletados (soft delete)

```
GET /api/itens-patrimoniados/trashed
```

### Criar

```
POST /api/itens-patrimoniados
Content-Type: application/json

{
    "patrimonio": 12345,
    "id_tipo": 1,
    "id_fabricante": 1,
    "id_localizacao": 1,
    "observacao": "Notebook"
}
```

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| patrimonio | integer | sim | Deve ser único |
| id_tipo | integer | sim | ID do tipo (deve existir em `tipos`) |
| id_fabricante | integer | sim | ID do fabricante (deve existir em `fabricantes`) |
| id_localizacao | integer | sim | ID da localização (deve existir em `localizacoes`) |
| observacao | string | não | |

Resposta (201):
```json
{
    "id": 1,
    "patrimonio": 12345,
    "id_tipo": 1,
    "id_fabricante": 1,
    "id_localizacao": 1,
    "observacao": "Notebook",
    "created_at": "2026-07-06T00:00:00.000000Z",
    "updated_at": "2026-07-06T00:00:00.000000Z",
    "deleted_at": null,
    "tipo": { ... },
    "fabricante": { ... },
    "localizacao": { ... }
}
```

### Mostrar

```
GET /api/itens-patrimoniados/{id}
```

### Atualizar

```
PUT /api/itens-patrimoniados/{id}
Content-Type: application/json

{
    "patrimonio": 54321,
    "id_tipo": 1,
    "id_fabricante": 1,
    "id_localizacao": 1,
    "observacao": "Atualizado"
}
```

### Deletar (soft delete)

```
DELETE /api/itens-patrimoniados/{id}
```

Resposta: `204 No Content`

### Restaurar

```
PUT /api/itens-patrimoniados/{id}/restore`
```

---

## Resumo de Erros

| Código | Significado |
|--------|-------------|
| 200 | Sucesso |
| 201 | Criado com sucesso |
| 204 | Deletado (sem conteúdo) |
| 404 | Recurso não encontrado |
| 422 | Erro de validação (campos inválidos) |

Exemplo de erro 422:
```json
{
    "message": "The nome tipo field is required.",
    "errors": {
        "nome_tipo": ["The nome tipo field is required."]
    }
}
```
