<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['nome_fabricante'])]
class Fabricante extends Model
{
    use SoftDeletes;

    public function itensDeQuantidade(): HasMany
    {
        return $this->hasMany(ItemDeQuantidade::class, 'id_fabricante');
    }

    public function itensPatrimoniados(): HasMany
    {
        return $this->hasMany(ItemPatrimoniado::class, 'id_fabricante');
    }
}
