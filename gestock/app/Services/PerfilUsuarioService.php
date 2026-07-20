<?php

namespace App\Services;

use App\Models\PerfilUsuario;
use Illuminate\Support\Collection;

class PerfilUsuarioService
{
    public function all(): Collection
    {
        return PerfilUsuario::all();
    }

    public function find(int $id): ?PerfilUsuario
    {
        return PerfilUsuario::find($id);
    }

    public function findOrFail(int $id): PerfilUsuario
    {
        return PerfilUsuario::findOrFail($id);
    }
}
