<?php

namespace App\Services;

use App\Models\MarcaEquipamento;
use App\Services\Traits\RecordsAudit;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class MarcaEquipamentoService
{
    use RecordsAudit;

    public function all(): Collection
    {
        return MarcaEquipamento::all();
    }

    public function paginate(int $perPage = 50): LengthAwarePaginator
    {
        return MarcaEquipamento::orderBy('id', 'desc')->paginate($perPage);
    }

    public function find(int $id): ?MarcaEquipamento
    {
        return MarcaEquipamento::find($id);
    }

    public function findOrFail(int $id): MarcaEquipamento
    {
        return MarcaEquipamento::findOrFail($id);
    }

    public function create(array $data): MarcaEquipamento
    {
        $record = MarcaEquipamento::create($data);

        $this->recordAudit('create', $record, null, $data);

        return $record;
    }

    public function update(int $id, array $data): MarcaEquipamento
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
            throw new \DomainException('Não é possível excluir esta marca, pois existem equipamentos patrimoniados vinculados a ela.');
        }

        $this->recordAudit('delete', $record, $record->toArray());

        return $record->delete();
    }

    public function forceDelete(int $id): bool
    {
        $record = MarcaEquipamento::withTrashed()->findOrFail($id);

        return $record->forceDelete();
    }

    public function restore(int $id): bool
    {
        $record = MarcaEquipamento::withTrashed()->findOrFail($id);

        return $record->restore();
    }
}
