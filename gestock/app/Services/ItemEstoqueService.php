<?php

namespace App\Services;

use App\Models\ItemEstoque;
use App\Services\Traits\RecordsAudit;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ItemEstoqueService
{
    use RecordsAudit;

    public function __construct(
        private readonly ImagemUploadService $imagemUploadService,
    ) {}

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
        return ItemEstoque::with(['espacoArmazenamento.unidadeOrganizacional'])
            ->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function filteredPaginate(
        ?int $unidadeId = null,
        ?int $localizacaoId = null,
        ?string $search = null,
        int $perPage = 50,
    ): LengthAwarePaginator {
        $query = ItemEstoque::with(['espacoArmazenamento.unidadeOrganizacional'])
            ->orderBy('created_at', 'desc');

        if ($unidadeId) {
            $query->whereHas('espacoArmazenamento', fn ($q) => $q->where('unidade_organizacional_id', $unidadeId));
        }

        if ($localizacaoId) {
            $query->where('espaco_armazenamento_id', $localizacaoId);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nome_item', 'like', "%{$search}%")
                    ->orWhere('descricao_item', 'like', "%{$search}%");
            });
        }

        return $query->paginate($perPage);
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

        if ($record->arquivo_imagem_id) {
            $record->arquivo_imagem_id = null;
            $record->save();
        }

        $this->imagemUploadService->delete('estoque', $id);

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
