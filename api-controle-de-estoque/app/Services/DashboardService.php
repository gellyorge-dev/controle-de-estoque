<?php

namespace App\Services;

use App\Models\CondicaoOperacionalEquipamento;
use App\Models\EquipamentoPatrimoniado;
use App\Models\EspacoArmazenamento;
use App\Models\ItemEstoque;
use App\Models\MarcaEquipamento;
use App\Models\PerfilUsuario;
use App\Models\RegistroAuditoria;
use App\Models\TipoEquipamento;
use App\Models\UnidadeOrganizacional;
use App\Models\UsuarioSistema;

readonly class DashboardService
{
    public function getAllCounts(): array
    {
        return [
            'equipamentos' => EquipamentoPatrimoniado::count(),
            'itens' => ItemEstoque::count(),
            'unidades' => UnidadeOrganizacional::count(),
            'espacos' => EspacoArmazenamento::count(),
            'usuarios' => UsuarioSistema::count(),
            'perfis' => PerfilUsuario::count(),
            'marcas' => MarcaEquipamento::count(),
            'tipos' => TipoEquipamento::count(),
            'condicoes' => CondicaoOperacionalEquipamento::count(),
            'auditorias' => RegistroAuditoria::count(),
        ];
    }
}
