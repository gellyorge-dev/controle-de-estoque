<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEspacoArmazenamentoRequest;
use App\Http\Requests\UpdateEspacoArmazenamentoRequest;
use App\Models\EspacoArmazenamento;
use App\Services\EspacoArmazenamentoService;
use App\Services\UnidadeOrganizacionalService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EspacoArmazenamentoController extends Controller
{
    public function __construct(
        private readonly EspacoArmazenamentoService $service,
        private readonly UnidadeOrganizacionalService $unidadeService,
    ) {}

    public function index(Request $request): View
    {
        $unidadeId = $request->query('unidade_id');
        $unidadeSelecionada = null;

        if ($unidadeId) {
            $espacos = EspacoArmazenamento::where('unidade_organizacional_id', $unidadeId)
                ->orderBy('created_at', 'desc')
                ->paginate(50);
            $unidadeSelecionada = $this->unidadeService->find($unidadeId);
        } else {
            $espacos = $this->service->paginate(50);
        }

        $unidades = $this->unidadeService->all();

        return view('espacos-armazenamento.index', compact('espacos', 'unidades', 'unidadeId', 'unidadeSelecionada'));
    }

    public function create(Request $request): View
    {
        $unidades = $this->unidadeService->all();
        $unidadeId = $request->query('unidade_id');
        $unidadeSelecionada = $unidadeId ? $this->unidadeService->find($unidadeId) : null;

        return view('espacos-armazenamento.create', compact('unidades', 'unidadeId', 'unidadeSelecionada'));
    }

    public function edit(int $id): View
    {
        $espaco = $this->service->find($id);
        $unidades = $this->unidadeService->all();

        return view('espacos-armazenamento.create', compact('espaco', 'unidades'));
    }

    public function store(StoreEspacoArmazenamentoRequest $request): RedirectResponse
    {
        $this->service->create($request->validated());

        $unidadeId = $request->input('unidade_organizacional_id');

        return $unidadeId
            ? redirect('/espacos-armazenamento?unidade_id='.$unidadeId)
            : redirect()->route('espacos-armazenamento.index');
    }

    public function update(UpdateEspacoArmazenamentoRequest $request, int $id): RedirectResponse
    {
        $espaco = $this->service->find($id);
        $this->service->update($id, $request->validated());

        $unidadeId = $espaco->unidade_organizacional_id;

        return $unidadeId
            ? redirect('/espacos-armazenamento?unidade_id='.$unidadeId)
            : redirect()->route('espacos-armazenamento.index');
    }

    public function destroy(int $id): RedirectResponse
    {
        try {
            $espaco = $this->service->find($id);
            $unidadeId = $espaco->unidade_organizacional_id;
            $this->service->delete($id);

            return $unidadeId
                ? redirect('/espacos-armazenamento?unidade_id='.$unidadeId)
                : redirect()->route('espacos-armazenamento.index');
        } catch (\DomainException $e) {
            return redirect()->route('espacos-armazenamento.index')->with('error', $e->getMessage());
        }
    }
}
