<?php

namespace App\Services;

use App\Models\EspacoArmazenamento;
use App\Services\Traits\RecordsAudit;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class EspacoArmazenamentoService
{
    use RecordsAudit;

    public function all(): Collection
    {
        return EspacoArmazenamento::all();
    }

    public function paginate(int $perPage = 50): LengthAwarePaginator
    {
        return EspacoArmazenamento::orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function find(int $id): ?EspacoArmazenamento
    {
        return EspacoArmazenamento::find($id);
    }

    public function findOrFail(int $id): EspacoArmazenamento
    {
        return EspacoArmazenamento::findOrFail($id);
    }

    public function create(array $data): EspacoArmazenamento
    {
        $record = EspacoArmazenamento::create($data);

        $this->recordAudit('create', $record, null, $data);

        return $record;
    }

    public function update(int $id, array $data): EspacoArmazenamento
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

        if ($record->itensEstoque()->count() > 0) {
            throw new \DomainException('Não é possível excluir este espaço, pois existem itens de estoque vinculados a ele.');
        }

        if ($record->equipamentosPatrimoniados()->count() > 0) {
            throw new \DomainException('Não é possível excluir este espaço, pois existem equipamentos patrimoniados vinculados a ele.');
        }

        $this->recordAudit('delete', $record, $record->toArray());

        return $record->delete();
    }

    public function forceDelete(int $id): bool
    {
        $record = EspacoArmazenamento::withTrashed()->findOrFail($id);

        return $record->forceDelete();
    }

    public function restore(int $id): bool
    {
        $record = EspacoArmazenamento::withTrashed()->findOrFail($id);

        return $record->restore();
    }
}
