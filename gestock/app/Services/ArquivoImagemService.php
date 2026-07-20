<?php

namespace App\Services;

use App\Models\ArquivoImagem;
use App\Services\Traits\RecordsAudit;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ArquivoImagemService
{
    use RecordsAudit;

    public function all(): Collection
    {
        return ArquivoImagem::all();
    }

    public function paginate(int $perPage = 50): LengthAwarePaginator
    {
        return ArquivoImagem::orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function find(int $id): ?ArquivoImagem
    {
        return ArquivoImagem::find($id);
    }

    public function findOrFail(int $id): ArquivoImagem
    {
        return ArquivoImagem::findOrFail($id);
    }

    public function create(array $data): ArquivoImagem
    {
        $record = ArquivoImagem::create($data);

        $this->recordAudit('create', $record, null, $data);

        return $record;
    }

    public function update(int $id, array $data): ArquivoImagem
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

        if ($record->usuariosSistema()->count() > 0) {
            throw new \DomainException('Não é possível excluir esta imagem, pois existem usuários vinculados a ela.');
        }

        if ($record->equipamentosPatrimoniados()->count() > 0) {
            throw new \DomainException('Não é possível excluir esta imagem, pois existem equipamentos patrimoniados vinculados a ela.');
        }

        if ($record->itensEstoque()->count() > 0) {
            throw new \DomainException('Não é possível excluir esta imagem, pois existem itens de estoque vinculados a ela.');
        }

        $this->recordAudit('delete', $record, $record->toArray());

        return $record->delete();
    }

    public function forceDelete(int $id): bool
    {
        $record = ArquivoImagem::withTrashed()->findOrFail($id);

        return $record->forceDelete();
    }

    public function restore(int $id): bool
    {
        $record = ArquivoImagem::withTrashed()->findOrFail($id);

        return $record->restore();
    }
}
