<?php

namespace App\Services;

use App\Models\TipoEquipamento;
use App\Services\Traits\RecordsAudit;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class TipoEquipamentoService
{
    use RecordsAudit;

    public function all(): Collection
    {
        return TipoEquipamento::all();
    }

    public function paginate(int $perPage = 50): LengthAwarePaginator
    {
        return TipoEquipamento::orderBy('id', 'desc')->paginate($perPage);
    }

    public function find(int $id): ?TipoEquipamento
    {
        return TipoEquipamento::find($id);
    }

    public function findOrFail(int $id): TipoEquipamento
    {
        return TipoEquipamento::findOrFail($id);
    }

    public function create(array $data): TipoEquipamento
    {
        $record = TipoEquipamento::create($data);

        $this->recordAudit('create', $record, null, $data);

        return $record;
    }

    public function update(int $id, array $data): TipoEquipamento
    {
        $record = $this->findOrFail($id);
        $old = $record->toArray();
        $record->update($data);

        $this->recordAudit('update', $record, $old, $data);

        return $record->fresh();
    }

    public function delete(int $id): bool
    {
        $record = $this->findOrFail($id);

        if ($record->equipamentosPatrimoniados()->count() > 0) {
            throw new \DomainException('Não é possível excluir este tipo, pois existem equipamentos patrimoniados vinculados a ele.');
        }

        $this->recordAudit('delete', $record, $record->toArray());

        return $record->delete();
    }

    public function forceDelete(int $id): bool
    {
        $record = TipoEquipamento::withTrashed()->findOrFail($id);

        return $record->forceDelete();
    }

    public function restore(int $id): bool
    {
        $record = TipoEquipamento::withTrashed()->findOrFail($id);

        return $record->restore();
    }
}
