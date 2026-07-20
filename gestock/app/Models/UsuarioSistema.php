<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[Fillable(['perfil_usuario_id', 'arquivo_imagem_id', 'nome_usuario', 'login_usuario', 'senha_usuario', 'ativo'])]
#[Hidden(['senha_usuario'])]
class UsuarioSistema extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'usuario_sis';

    public function getAuthPassword(): string
    {
        return $this->senha_usuario;
    }

    public function perfilUsuario(): BelongsTo
    {
        return $this->belongsTo(PerfilUsuario::class);
    }

    public function arquivoImagem(): BelongsTo
    {
        return $this->belongsTo(ArquivoImagem::class);
    }

    public function registrosAuditoria(): HasMany
    {
        return $this->hasMany(RegistroAuditoria::class);
    }
}
