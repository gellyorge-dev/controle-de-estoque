<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCondicaoOperacionalEquipamentoRequest;
use App\Http\Requests\UpdateCondicaoOperacionalEquipamentoRequest;
use App\Services\CondicaoOperacionalEquipamentoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CondicaoOperacionalEquipamentoController extends Controller
{
    public function __construct(
        private readonly CondicaoOperacionalEquipamentoService $service
    ) {}

    public function index(): View
    {
        $condicoes = $this->service->paginate(50);

        return view('equipamentos.condicoes', compact('condicoes'));
    }

    public function create(): View
    {
        return view('equipamentos.condicoes-create');
    }

    public function edit(int $id): View
    {
        $condicao = $this->service->find($id);

        return view('equipamentos.condicoes-create', compact('condicao'));
    }

    public function store(StoreCondicaoOperacionalEquipamentoRequest $request): RedirectResponse
    {
        $this->service->create($request->validated());

        return redirect()->route('equipamentos.condicoes');
    }

    public function update(UpdateCondicaoOperacionalEquipamentoRequest $request, int $id): RedirectResponse
    {
        $this->service->update($id, $request->validated());

        return redirect()->route('equipamentos.condicoes');
    }

    public function destroy(int $id): RedirectResponse
    {
        try {
            $this->service->delete($id);
        } catch (\DomainException $e) {
            return redirect()->route('equipamentos.condicoes')->with('error', $e->getMessage());
        }

        return redirect()->route('equipamentos.condicoes');
    }
}
