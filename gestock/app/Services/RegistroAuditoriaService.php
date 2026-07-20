<?php

namespace App\Services;

use App\Models\RegistroAuditoria;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class RegistroAuditoriaService
{
    public function all(): Collection
    {
        return RegistroAuditoria::all();
    }

    public function paginate(int $perPage = 50): LengthAwarePaginator
    {
        return RegistroAuditoria::orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function find(int $id): ?RegistroAuditoria
    {
        return RegistroAuditoria::find($id);
    }

    public function findOrFail(int $id): RegistroAuditoria
    {
        return RegistroAuditoria::findOrFail($id);
    }

    public function create(array $data): RegistroAuditoria
    {
        return RegistroAuditoria::create($data);
    }
}
