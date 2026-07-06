<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['localizacao_nome'])]
class Localizacao extends Model
{
    use SoftDeletes;

    protected $table = 'localizacoes';

    public function itensDeQuantidade(): HasMany
    {
        return $this->hasMany(ItemDeQuantidade::class, 'id_localizacao');
    }

    public function itensPatrimoniados(): HasMany
    {
        return $this->hasMany(ItemPatrimoniado::class, 'id_localizacao');
    }
}
