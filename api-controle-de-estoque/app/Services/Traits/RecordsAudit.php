<?php

namespace App\Services\Traits;

use App\Models\RegistroAuditoria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait RecordsAudit
{
    protected function recordAudit(string $tipoAcao, Model $record, ?array $valorAnterior = null, ?array $valorNovo = null, ?string $observacao = null): void
    {
        $usuarioId = Auth::id();

        if ($usuarioId === null) {
            return;
        }

        RegistroAuditoria::create([
            'usuario_sistema_id' => $usuarioId,
            'nome_tabela' => $record->getTable(),
            'identificador_registro' => $record->id,
            'tipo_acao' => $tipoAcao,
            'valor_anterior' => $valorAnterior !== null ? json_encode($valorAnterior) : null,
            'valor_novo' => $valorNovo !== null ? json_encode($valorNovo) : null,
            'observacao' => $observacao,
        ]);
    }
}
