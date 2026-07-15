<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreItemEstoqueRequest;
use App\Http\Requests\UpdateItemEstoqueRequest;
use App\Services\ArquivoImagemService;
use App\Services\EspacoArmazenamentoService;
use App\Services\ItemEstoqueService;
use App\Services\UnidadeOrganizacionalService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ItemEstoqueController extends Controller
{
    public function __construct(
        private readonly ItemEstoqueService $service,
        private readonly EspacoArmazenamentoService $espacoService,
        private readonly ArquivoImagemService $imagemService,
        private readonly UnidadeOrganizacionalService $unidadeService,
    ) {}

    public function index(): View
    {
        $itens = $this->service->paginate(50);
        $espacos = $this->espacoService->all();
        $imagens = $this->imagemService->all();

        return view('itens-estoque.index', compact('itens', 'espacos', 'imagens'));
    }

    public function create(): View
    {
        $espacos = $this->espacoService->all();
        $imagens = $this->imagemService->all();
        $unidades = $this->unidadeService->all();

        return view('itens-estoque.create', compact('espacos', 'imagens', 'unidades'));
    }

    public function edit(int $id): View
    {
        $item = $this->service->find($id);
        $espacos = $this->espacoService->all();
        $imagens = $this->imagemService->all();
        $unidades = $this->unidadeService->all();

        return view('itens-estoque.create', compact('item', 'espacos', 'imagens', 'unidades'));
    }

    public function store(StoreItemEstoqueRequest $request): RedirectResponse
    {
        $this->service->create($request->validated());

        return redirect()->route('itens-estoque.index');
    }

    public function update(UpdateItemEstoqueRequest $request, int $id): RedirectResponse
    {
        $this->service->update($id, $request->validated());

        return redirect()->route('itens-estoque.index');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->service->delete($id);

        return redirect()->route('itens-estoque.index');
    }
}
