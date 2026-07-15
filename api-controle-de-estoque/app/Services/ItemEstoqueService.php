<?php

namespace App\Services;

use App\Models\ItemEstoque;
use App\Services\Traits\RecordsAudit;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ItemEstoqueService
{
    use RecordsAudit;

    public function all(): Collection
    {
        return ItemEstoque::all();
    }

    public function count(): int
    {
        return ItemEstoque::count();
    }

    public function paginate(int $perPage = 50): LengthAwarePaginator
    {
        return ItemEstoque::orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function find(int $id): ?ItemEstoque
    {
        return ItemEstoque::find($id);
    }

    public function findOrFail(int $id): ItemEstoque
    {
        return ItemEstoque::findOrFail($id);
    }

    public function create(array $data): ItemEstoque
    {
        $record = ItemEstoque::create($data);

        $this->recordAudit('create', $record, null, $data);

        return $record;
    }

    public function update(int $id, array $data): ItemEstoque
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
        $record = ItemEstoque::withTrashed()->findOrFail($id);

        return $record->forceDelete();
    }

    public function restore(int $id): bool
    {
        $record = ItemEstoque::withTrashed()->findOrFail($id);

        return $record->restore();
    }
}
