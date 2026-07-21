<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\EquipamentoPatrimoniado;
use App\Models\ItemEstoque;
use App\Services\DashboardService;
use App\Services\ExportCsvService;

class DashboardController extends Controller
{
    public function __construct(
        private readonly DashboardService $dashboardService,
    ) {}

    public function index()
    {
        $counts = $this->dashboardService->getAllCounts();

        return view('dashboard.index', compact('counts'));
    }

    public function exportResumo()
    {
        $counts = $this->dashboardService->getAllCounts();

        $labels = [
            'equipamentos' => 'Equipamentos Patrimoniados',
            'itens' => 'Itens de Estoque',
            'unidades' => 'Unidades Organizacionais',
            'espacos' => 'Espaços de Armazenamento',
            'usuarios' => 'Usuários do Sistema',
            'perfis' => 'Perfis de Usuário',
            'marcas' => 'Marcas de Equipamentos',
            'tipos' => 'Tipos de Equipamentos',
            'condicoes' => 'Condições Operacionais',
            'auditorias' => 'Registros de Auditoria',
        ];

        $headers = ['Categoria', 'Quantidade'];
        $data = [];

        foreach ($counts as $key => $value) {
            $data[] = [$labels[$key] ?? $key, $value];
        }

        $service = new ExportCsvService;

        return $service->download('dashboard-resumo', $data, $headers);
    }

    public function exportEquipamentos()
    {
        $equipamentos = EquipamentoPatrimoniado::with([
            'marcaEquipamento',
            'tipoEquipamento',
            'condicaoOperacionalEquipamento',
            'espacoArmazenamento.unidadeOrganizacional',
        ])->orderBy('numero_patrimonio')->get();

        $headers = [
            'Nº Patrimônio',
            'Nº Série',
            'Marca',
            'Tipo',
            'Condição Operacional',
            'Unidade',
            'Espaço',
            'Informado ao Patrimônio',
            'Ativo',
            'Observações',
            'Criado em',
        ];

        $data = $equipamentos->map(fn ($e) => [
            $e->numero_patrimonio,
            $e->numero_serie,
            $e->marcaEquipamento?->nome,
            $e->tipoEquipamento?->nome,
            $e->condicaoOperacionalEquipamento?->nome,
            $e->espacoArmazenamento?->unidadeOrganizacional?->nome,
            $e->espacoArmazenamento?->nome,
            $e->informado_ao_patrimonio ? 'Sim' : 'Não',
            $e->patrimonio_esta_ativo ? 'Sim' : 'Não',
            $e->observacoes_equipamento,
            $e->created_at?->format('d/m/Y H:i'),
        ])->toArray();

        $service = new ExportCsvService;

        return $service->download('equipamentos-patrimoniados', $data, $headers);
    }

    public function exportItensEstoque()
    {
        $itens = ItemEstoque::with([
            'espacoArmazenamento.unidadeOrganizacional',
        ])->orderBy('nome_item')->get();

        $headers = [
            'Nome',
            'Descrição',
            'Quantidade',
            'Unidade',
            'Espaço',
            'Observações',
            'Criado em',
        ];

        $data = $itens->map(fn ($i) => [
            $i->nome_item,
            $i->descricao_item,
            $i->quantidade,
            $i->espacoArmazenamento?->unidadeOrganizacional?->nome,
            $i->espacoArmazenamento?->nome,
            $i->observacoes_item,
            $i->created_at?->format('d/m/Y H:i'),
        ])->toArray();

        $service = new ExportCsvService;

        return $service->download('itens-estoque', $data, $headers);
    }
}
