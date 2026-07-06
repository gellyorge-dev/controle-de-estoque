<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['nome_tipo'])]
class Tipo extends Model
{
    use SoftDeletes;

    public function itensDeQuantidade(): HasMany
    {
        return $this->hasMany(ItemDeQuantidade::class, 'id_tipo');
    }

    public function itensPatrimoniados(): HasMany
    {
        return $this->hasMany(ItemPatrimoniado::class, 'id_tipo');
    }
}
