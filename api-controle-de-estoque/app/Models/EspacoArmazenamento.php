<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['unidade_organizacional_id', 'nome', 'descricao'])]
class EspacoArmazenamento extends Model
{
    protected $table = 'espaco_armazenamento';

    public function unidadeOrganizacional(): BelongsTo
    {
        return $this->belongsTo(UnidadeOrganizacional::class);
    }

    public function equipamentosPatrimoniados(): HasMany
    {
        return $this->hasMany(EquipamentoPatrimoniado::class);
    }

    public function itensEstoque(): HasMany
    {
        return $this->hasMany(ItemEstoque::class);
    }
}
