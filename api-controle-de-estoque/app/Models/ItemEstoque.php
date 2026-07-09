<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['espaco_armazenamento_id', 'arquivo_imagem_id', 'nome_item', 'descricao_item', 'quantidade', 'observacoes_item'])]
class ItemEstoque extends Model
{
    protected $table = 'item_estoque';

    protected function casts(): array
    {
        return [
            'quantidade' => 'integer',
        ];
    }

    public function espacoArmazenamento(): BelongsTo
    {
        return $this->belongsTo(EspacoArmazenamento::class);
    }

    public function arquivoImagem(): BelongsTo
    {
        return $this->belongsTo(ArquivoImagem::class);
    }
}
