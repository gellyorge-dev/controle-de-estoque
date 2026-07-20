<?php

namespace App\Services;

use App\Models\UsuarioSistema;
use App\Services\Traits\RecordsAudit;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class UsuarioSistemaService
{
    use RecordsAudit;

    public function all(): Collection
    {
        return UsuarioSistema::all();
    }

    public function paginate(int $perPage = 50): LengthAwarePaginator
    {
        return UsuarioSistema::orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function find(int $id): ?UsuarioSistema
    {
        return UsuarioSistema::find($id);
    }

    public function findOrFail(int $id): UsuarioSistema
    {
        return UsuarioSistema::findOrFail($id);
    }

    public function create(array $data): UsuarioSistema
    {
        $data['ativo'] = $data['ativo'] ?? false;

        $record = UsuarioSistema::create($data);

        $this->recordAudit('create', $record, null, $data);

        return $record;
    }

    public function update(int $id, array $data): UsuarioSistema
    {
        $record = $this->findOrFail($id);

        $data['ativo'] = $data['ativo'] ?? false;

        $wouldBeAdmin = (array_key_exists('perfil_usuario_id', $data) ? $data['perfil_usuario_id'] : $record->perfil_usuario_id) === 1;
        $wouldBeActive = $data['ativo'];

        if ($wouldBeAdmin && $wouldBeActive) {
            $old = $record->toArray();
            $record->update($data);

            $this->recordAudit('update', $record, $old, $data);

            return $record->fresh();
        }

        if ($record->perfil_usuario_id === 1 && $record->ativo) {
            $otherActiveAdmins = UsuarioSistema::where('perfil_usuario_id', 1)
                ->where('ativo', true)
                ->where('id', '!=', $id)
                ->count();

            if ($otherActiveAdmins === 0) {
                throw new \RuntimeException('Não é possível remover o único administrador ativo do sistema.');
            }
        }

        $old = $record->toArray();
        $record->update($data);

        $this->recordAudit('update', $record, $old, $data);

        return $record->fresh();
    }

    public function delete(int $id): bool
    {
        $record = $this->findOrFail($id);

        $this->recordAudit('delete', $record, $record->toArray());

        return $record->delete();
    }

    public function forceDelete(int $id): bool
    {
        $record = UsuarioSistema::withTrashed()->findOrFail($id);

        return $record->forceDelete();
    }

    public function restore(int $id): bool
    {
        $record = UsuarioSistema::withTrashed()->findOrFail($id);

        return $record->restore();
    }
}
