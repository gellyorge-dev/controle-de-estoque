<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nome'])]
class CondicaoOperacionalEquipamento extends Model
{
    protected $table = 'cond_eqp';

    public $timestamps = false;

    public function equipamentosPatrimoniados(): HasMany
    {
        return $this->hasMany(EquipamentoPatrimoniado::class);
    }
}
