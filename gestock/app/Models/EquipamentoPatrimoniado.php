<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'numero_patrimonio',
    'numero_serie',
    'espaco_armazenamento_id',
    'marca_equipamento_id',
    'tipo_equipamento_id',
    'condicao_operacional_equipamento_id',
    'arquivo_imagem_id',
    'descricao_equipamento',
    'informado_ao_patrimonio',
    'patrimonio_esta_ativo',
    'local_anterior',
    'observacoes_equipamento',
])]
class EquipamentoPatrimoniado extends Model
{
    protected $table = 'equip_patrim';

    protected function casts(): array
    {
        return [
            'informado_ao_patrimonio' => 'boolean',
            'patrimonio_esta_ativo' => 'boolean',
        ];
    }

    public function espacoArmazenamento(): BelongsTo
    {
        return $this->belongsTo(EspacoArmazenamento::class);
    }

    public function marcaEquipamento(): BelongsTo
    {
        return $this->belongsTo(MarcaEquipamento::class);
    }

    public function tipoEquipamento(): BelongsTo
    {
        return $this->belongsTo(TipoEquipamento::class);
    }

    public function condicaoOperacionalEquipamento(): BelongsTo
    {
        return $this->belongsTo(CondicaoOperacionalEquipamento::class);
    }

    public function arquivoImagem(): BelongsTo
    {
        return $this->belongsTo(ArquivoImagem::class);
    }
}
