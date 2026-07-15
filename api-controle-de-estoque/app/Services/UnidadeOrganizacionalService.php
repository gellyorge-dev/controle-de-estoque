<?php

namespace App\Services;

use App\Models\UnidadeOrganizacional;
use App\Services\Traits\RecordsAudit;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class UnidadeOrganizacionalService
{
    use RecordsAudit;

    public function all(): Collection
    {
        return UnidadeOrganizacional::all();
    }

    public function paginate(int $perPage = 50): LengthAwarePaginator
    {
        return UnidadeOrganizacional::orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function find(int $id): ?UnidadeOrganizacional
    {
        return UnidadeOrganizacional::find($id);
    }

    public function findOrFail(int $id): UnidadeOrganizacional
    {
        return UnidadeOrganizacional::findOrFail($id);
    }

    public function create(array $data): UnidadeOrganizacional
    {
        $record = UnidadeOrganizacional::create($data);

        $this->recordAudit('create', $record, null, $data);

        return $record;
    }

    public function update(int $id, array $data): UnidadeOrganizacional
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

        if ($record->espacoArmazenamento()->count() > 0) {
            throw new \DomainException('Não é possível excluir esta unidade, pois existem espaços de armazenamento vinculados a ela.');
        }

        $this->recordAudit('delete', $record, $record->toArray());

        return $record->delete();
    }

    public function forceDelete(int $id): bool
    {
        $record = UnidadeOrganizacional::withTrashed()->findOrFail($id);

        return $record->forceDelete();
    }

    public function restore(int $id): bool
    {
        $record = UnidadeOrganizacional::withTrashed()->findOrFail($id);

        return $record->restore();
    }
}
