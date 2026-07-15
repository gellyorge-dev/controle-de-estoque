<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nome'])]
class UnidadeOrganizacional extends Model
{
    protected $table = 'unidade_org';

    public function espacoArmazenamento(): HasMany
    {
        return $this->hasMany(EspacoArmazenamento::class);
    }
}
