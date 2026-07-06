<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['id_tipo', 'id_fabricante', 'id_localizacao', 'quantidade', 'observacao'])]
class ItemDeQuantidade extends Model
{
    use SoftDeletes;

    protected $table = 'itens_de_quantidade';

    public function tipo(): BelongsTo
    {
        return $this->belongsTo(Tipo::class, 'id_tipo');
    }

    public function fabricante(): BelongsTo
    {
        return $this->belongsTo(Fabricante::class, 'id_fabricante');
    }

    public function localizacao(): BelongsTo
    {
        return $this->belongsTo(Localizacao::class, 'id_localizacao');
    }
}
