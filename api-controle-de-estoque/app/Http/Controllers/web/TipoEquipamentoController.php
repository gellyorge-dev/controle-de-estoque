<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTipoEquipamentoRequest;
use App\Http\Requests\UpdateTipoEquipamentoRequest;
use App\Services\TipoEquipamentoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TipoEquipamentoController extends Controller
{
    public function __construct(
        private readonly TipoEquipamentoService $service
    ) {}

    public function index(): View
    {
        $tipos = $this->service->paginate(50);

        return view('equipamentos.tipos', compact('tipos'));
    }

    public function create(): View
    {
        return view('equipamentos.tipos-create');
    }

    public function edit(int $id): View
    {
        $tipo = $this->service->find($id);

        return view('equipamentos.tipos-create', compact('tipo'));
    }

    public function store(StoreTipoEquipamentoRequest $request): RedirectResponse
    {
        $this->service->create($request->validated());

        return redirect()->route('equipamentos.tipos');
    }

    public function update(UpdateTipoEquipamentoRequest $request, int $id): RedirectResponse
    {
        $this->service->update($id, $request->validated());

        return redirect()->route('equipamentos.tipos');
    }

    public function destroy(int $id): RedirectResponse
    {
        try {
            $this->service->delete($id);
        } catch (\DomainException $e) {
            return redirect()->route('equipamentos.tipos')->with('error', $e->getMessage());
        }

        return redirect()->route('equipamentos.tipos');
    }
}
