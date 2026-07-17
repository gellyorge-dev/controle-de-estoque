<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nome_arquivo', 'caminho', 'mime_type', 'tamanho', 'hash', 'tipo', 'entidade_id'])]
class ArquivoImagem extends Model
{
    protected $table = 'arquivo_img';

    public function usuariosSistema(): HasMany
    {
        return $this->hasMany(UsuarioSistema::class);
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
