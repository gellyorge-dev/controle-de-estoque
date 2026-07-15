<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['usuario_sistema_id', 'nome_tabela', 'identificador_registro', 'tipo_acao', 'valor_anterior', 'valor_novo', 'observacao'])]
class RegistroAuditoria extends Model
{
    protected $table = 'registro_aud';

    public const UPDATED_AT = null;

    public function usuarioSistema(): BelongsTo
    {
        return $this->belongsTo(UsuarioSistema::class);
    }
}
