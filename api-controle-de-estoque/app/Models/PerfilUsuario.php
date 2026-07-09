<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nome'])]
class PerfilUsuario extends Model
{
    protected $table = 'perfil_usuario';

    public $timestamps = false;

    public function usuariosSistema(): HasMany
    {
        return $this->hasMany(UsuarioSistema::class);
    }
}
