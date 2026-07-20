<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreItemEstoqueRequest;
use App\Http\Requests\UpdateItemEstoqueRequest;
use App\Services\ArquivoImagemService;
use App\Services\EspacoArmazenamentoService;
use App\Services\ImagemUploadService;
use App\Services\ItemEstoqueService;
use App\Services\UnidadeOrganizacionalService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ItemEstoqueController extends Controller
{
    public function __construct(
        private readonly ItemEstoqueService $service,
        private readonly EspacoArmazenamentoService $espacoService,
        private readonly ArquivoImagemService $imagemService,
        private readonly UnidadeOrganizacionalService $unidadeService,
        private readonly ImagemUploadService $imagemUploadService,
    ) {}

    public function index(Request $request): View
    {
        $unidadeId = $request->query('unidade_id');
        $localizacaoId = $request->query('localizacao_id');
        $search = $request->query('search');

        $itens = $this->service->filteredPaginate(
            unidadeId: $unidadeId ? (int) $unidadeId : null,
            localizacaoId: $localizacaoId ? (int) $localizacaoId : null,
            search: $search,
        );

        $espacos = $this->espacoService->all();
        $imagens = $this->imagemService->all();
        $unidades = $this->unidadeService->all();

        return view('itens-estoque.index', compact(
            'itens', 'espacos', 'imagens', 'unidades',
            'unidadeId', 'localizacaoId', 'search'
        ));
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
        $data = $request->validated();

        if ($request->hasFile('arquivo')) {
            $item = $this->service->create($data);
            $imagem = $this->imagemUploadService->upload($request->file('arquivo'), 'estoque', $item->id);
            $item->update(['arquivo_imagem_id' => $imagem->id]);
        } else {
            $this->service->create($data);
        }

        return redirect()->route('itens-estoque.index');
    }

    public function update(UpdateItemEstoqueRequest $request, int $id): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('arquivo')) {
            $imagem = $this->imagemUploadService->upload($request->file('arquivo'), 'estoque', $id);
            $data['arquivo_imagem_id'] = $imagem->id;
        }

        $this->service->update($id, $data);

        return redirect()->route('itens-estoque.index');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->service->delete($id);

        return redirect()->route('itens-estoque.index');
    }
}
