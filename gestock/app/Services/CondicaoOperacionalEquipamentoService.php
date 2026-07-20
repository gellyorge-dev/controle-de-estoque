<?php

namespace App\Services;

use App\Models\CondicaoOperacionalEquipamento;
use App\Services\Traits\RecordsAudit;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class CondicaoOperacionalEquipamentoService
{
    use RecordsAudit;

    public function all(): Collection
    {
        return CondicaoOperacionalEquipamento::all();
    }

    public function paginate(int $perPage = 50): LengthAwarePaginator
    {
        return CondicaoOperacionalEquipamento::orderBy('id', 'desc')->paginate($perPage);
    }

    public function find(int $id): ?CondicaoOperacionalEquipamento
    {
        return CondicaoOperacionalEquipamento::find($id);
    }

    public function findOrFail(int $id): CondicaoOperacionalEquipamento
    {
        return CondicaoOperacionalEquipamento::findOrFail($id);
    }

    public function create(array $data): CondicaoOperacionalEquipamento
    {
        $record = CondicaoOperacionalEquipamento::create($data);

        $this->recordAudit('create', $record, null, $data);

        return $record;
    }

    public function update(int $id, array $data): CondicaoOperacionalEquipamento
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
            throw new \DomainException('Não é possível excluir esta condição operacional, pois existem equipamentos patrimoniados vinculados a ela.');
        }

        $this->recordAudit('delete', $record, $record->toArray());

        return $record->delete();
    }

    public function forceDelete(int $id): bool
    {
        $record = CondicaoOperacionalEquipamento::withTrashed()->findOrFail($id);

        return $record->forceDelete();
    }

    public function restore(int $id): bool
    {
        $record = CondicaoOperacionalEquipamento::withTrashed()->findOrFail($id);

        return $record->restore();
    }
}
