<?php

namespace App\Services;

use App\Models\EquipamentoPatrimoniado;
use App\Services\Traits\RecordsAudit;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class EquipamentoPatrimoniadoService
{
    use RecordsAudit;

    public function __construct(
        private readonly ImagemUploadService $imagemUploadService,
    ) {}

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
        return EquipamentoPatrimoniado::with(['marcaEquipamento', 'tipoEquipamento', 'condicaoOperacionalEquipamento', 'espacoArmazenamento.unidadeOrganizacional'])
            ->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function filteredPaginate(
        ?int $marcaId = null,
        ?int $tipoId = null,
        ?int $condicaoId = null,
        ?int $unidadeId = null,
        ?int $localizacaoId = null,
        ?string $status = null,
        ?string $search = null,
        int $perPage = 50,
    ): LengthAwarePaginator {
        $query = EquipamentoPatrimoniado::with(['marcaEquipamento', 'tipoEquipamento', 'condicaoOperacionalEquipamento', 'espacoArmazenamento.unidadeOrganizacional'])
            ->orderBy('created_at', 'desc');

        if ($marcaId) {
            $query->where('marca_equipamento_id', $marcaId);
        }

        if ($tipoId) {
            $query->where('tipo_equipamento_id', $tipoId);
        }

        if ($condicaoId) {
            $query->where('condicao_operacional_equipamento_id', $condicaoId);
        }

        if ($unidadeId) {
            $query->whereHas('espacoArmazenamento', fn ($q) => $q->where('unidade_organizacional_id', $unidadeId));
        }

        if ($localizacaoId) {
            $query->where('espaco_armazenamento_id', $localizacaoId);
        }

        if ($status === 'informado') {
            $query->where('informado_ao_patrimonio', true);
        } elseif ($status === 'ativo') {
            $query->where('informado_ao_patrimonio', false);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nome_equipamento', 'like', "%{$search}%")
                    ->orWhere('numero_patrimonio', 'like', "%{$search}%")
                    ->orWhere('numero_serie', 'like', "%{$search}%");
            });
        }

        return $query->paginate($perPage);
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
        $this->validatePatrimonio($data);

        $data['informado_ao_patrimonio'] = $data['informado_ao_patrimonio'] ?? false;

        $record = EquipamentoPatrimoniado::create($data);

        $this->recordAudit('create', $record, null, $data);

        return $record;
    }

    public function update(int $id, array $data): EquipamentoPatrimoniado
    {
        $record = $this->findOrFail($id);
        $old = $record->toArray();

        $this->validatePatrimonio($data);

        $data['informado_ao_patrimonio'] = $data['informado_ao_patrimonio'] ?? false;

        $record->update($data);

        $this->recordAudit('update', $record, $old, $data);

        return $record->fresh();
    }

    private function validatePatrimonio(array $data): void
    {
        if (isset($data['numero_patrimonio']) && $data['numero_patrimonio'] < 1) {
            throw ValidationException::withMessages([
                'numero_patrimonio' => 'O número de patrimônio não pode ser negativo ou zero.',
            ]);
        }
    }

    public function delete(int $id): bool
    {
        $record = $this->findOrFail($id);

        if ($record->arquivo_imagem_id) {
            $record->arquivo_imagem_id = null;
            $record->save();
        }

        $this->imagemUploadService->delete('patrimoniados', $id);

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
