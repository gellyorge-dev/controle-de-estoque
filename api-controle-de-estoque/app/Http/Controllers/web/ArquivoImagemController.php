<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArquivoImagemRequest;
use App\Http\Requests\UpdateArquivoImagemRequest;
use App\Services\ArquivoImagemService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ArquivoImagemController extends Controller
{
    public function __construct(
        private readonly ArquivoImagemService $service
    ) {}

    public function index(): View
    {
        $imagens = $this->service->paginate(50);

        return view('equipamentos.imagens', compact('imagens'));
    }

    public function create(): View
    {
        return view('equipamentos.imagens-create');
    }

    public function edit(int $id): View
    {
        $imagem = $this->service->find($id);

        return view('equipamentos.imagens-create', compact('imagem'));
    }

    public function store(StoreArquivoImagemRequest $request): RedirectResponse
    {
        $data = $request->validated();
        if ($request->hasFile('arquivo')) {
            $file = $request->file('arquivo');
            $data['nome_arquivo'] = $file->getClientOriginalName();
            $data['mime_type'] = $file->getMimeType();
            $data['tamanho'] = $file->getSize();
            $data['hash'] = md5_file($file->getRealPath());
            $data['caminho'] = $file->store('uploads/equipamentos', 'public');
        }
        $this->service->create($data);

        return redirect()->route('equipamentos.imagens');
    }

    public function update(UpdateArquivoImagemRequest $request, int $id): RedirectResponse
    {
        $this->service->update($id, $request->validated());

        return redirect()->route('equipamentos.imagens');
    }

    public function destroy(int $id): RedirectResponse
    {
        try {
            $this->service->delete($id);
        } catch (\DomainException $e) {
            return redirect()->route('equipamentos.imagens')->with('error', $e->getMessage());
        }

        return redirect()->route('equipamentos.imagens');
    }
}
