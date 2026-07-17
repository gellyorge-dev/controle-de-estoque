<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEquipamentoPatrimoniadoRequest;
use App\Http\Requests\UpdateEquipamentoPatrimoniadoRequest;
use App\Services\ArquivoImagemService;
use App\Services\CondicaoOperacionalEquipamentoService;
use App\Services\EquipamentoPatrimoniadoService;
use App\Services\EspacoArmazenamentoService;
use App\Services\ImagemUploadService;
use App\Services\MarcaEquipamentoService;
use App\Services\TipoEquipamentoService;
use App\Services\UnidadeOrganizacionalService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EquipamentoPatrimoniadoController extends Controller
{
    public function __construct(
        private readonly EquipamentoPatrimoniadoService $service,
        private readonly MarcaEquipamentoService $marcaService,
        private readonly TipoEquipamentoService $tipoService,
        private readonly CondicaoOperacionalEquipamentoService $condicaoService,
        private readonly EspacoArmazenamentoService $espacoService,
        private readonly ArquivoImagemService $imagemService,
        private readonly UnidadeOrganizacionalService $unidadeService,
        private readonly ImagemUploadService $imagemUploadService,
    ) {}

    public function index(): View
    {
        $equipamentos = $this->service->paginate(50);
        $marcas = $this->marcaService->all();
        $tipos = $this->tipoService->all();
        $condicoes = $this->condicaoService->all();
        $espacos = $this->espacoService->all();
        $imagens = $this->imagemService->all();
        $unidades = $this->unidadeService->all();

        return view('equipamentos-patrimoniados.index', compact(
            'equipamentos', 'marcas', 'tipos', 'condicoes', 'espacos', 'imagens', 'unidades'
        ));
    }

    public function create(): View
    {
        $marcas = $this->marcaService->all();
        $tipos = $this->tipoService->all();
        $condicoes = $this->condicaoService->all();
        $espacos = $this->espacoService->all();
        $imagens = $this->imagemService->all();
        $unidades = $this->unidadeService->all();

        return view('equipamentos-patrimoniados.create', compact(
            'marcas', 'tipos', 'condicoes', 'espacos', 'imagens', 'unidades'
        ));
    }

    public function edit(int $id): View
    {
        $equipamento = $this->service->find($id);
        $marcas = $this->marcaService->all();
        $tipos = $this->tipoService->all();
        $condicoes = $this->condicaoService->all();
        $espacos = $this->espacoService->all();
        $imagens = $this->imagemService->all();
        $unidades = $this->unidadeService->all();

        return view('equipamentos-patrimoniados.create', compact(
            'equipamento', 'marcas', 'tipos', 'condicoes', 'espacos', 'imagens', 'unidades'
        ));
    }

    public function store(StoreEquipamentoPatrimoniadoRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('arquivo')) {
            $equipamento = $this->service->create($data);
            $imagem = $this->imagemUploadService->upload($request->file('arquivo'), 'patrimoniados', $equipamento->id);
            $equipamento->update(['arquivo_imagem_id' => $imagem->id]);
        } else {
            $this->service->create($data);
        }

        return redirect()->route('equipamentos-patrimoniados.index');
    }

    public function update(UpdateEquipamentoPatrimoniadoRequest $request, int $id): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('arquivo')) {
            $imagem = $this->imagemUploadService->upload($request->file('arquivo'), 'patrimoniados', $id);
            $data['arquivo_imagem_id'] = $imagem->id;
        }

        $this->service->update($id, $data);

        return redirect()->route('equipamentos-patrimoniados.index');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->imagemUploadService->delete('patrimoniados', $id);
        $this->service->delete($id);

        return redirect()->route('equipamentos-patrimoniados.index');
    }
}
