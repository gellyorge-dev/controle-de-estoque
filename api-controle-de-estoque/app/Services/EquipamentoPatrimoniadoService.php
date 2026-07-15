<?php

namespace App\Services;

use App\Models\EquipamentoPatrimoniado;
use App\Services\Traits\RecordsAudit;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class EquipamentoPatrimoniadoService
{
    use RecordsAudit;

    public function all(): Collection
    {
        return EquipamentoPatrimoniado::all();
    }

    public function count(): int
    {
        return EquipamentoPatrimoniado::count();
    }

    public function paginate(int $perPage = 50): LengthAwarePaginator
    {
        return EquipamentoPatrimoniado::orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function find(int $id): ?EquipamentoPatrimoniado
    {
        return EquipamentoPatrimoniado::find($id);
    }

    public function findOrFail(int $id): EquipamentoPatrimoniado
    {
        return EquipamentoPatrimoniado::findOrFail($id);
    }

    public function create(array $data): EquipamentoPatrimoniado
    {
        $record = EquipamentoPatrimoniado::create($data);

        $this->recordAudit('create', $record, null, $data);

        return $record;
    }

    public function update(int $id, array $data): EquipamentoPatrimoniado
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

        $this->recordAudit('delete', $record, $record->toArray());

        return $record->delete();
    }

    public function forceDelete(int $id): bool
    {
        $record = EquipamentoPatrimoniado::withTrashed()->findOrFail($id);

        return $record->forceDelete();
    }

    public function restore(int $id): bool
    {
        $record = EquipamentoPatrimoniado::withTrashed()->findOrFail($id);

        return $record->restore();
    }
}
