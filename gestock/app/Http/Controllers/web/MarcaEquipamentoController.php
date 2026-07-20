<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMarcaEquipamentoRequest;
use App\Http\Requests\UpdateMarcaEquipamentoRequest;
use App\Services\MarcaEquipamentoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MarcaEquipamentoController extends Controller
{
    public function __construct(
        private readonly MarcaEquipamentoService $service
    ) {}

    public function index(): View
    {
        $marcas = $this->service->paginate(50);

        return view('equipamentos.marcas', compact('marcas'));
    }

    public function create(): View
    {
        return view('equipamentos.marcas-create');
    }

    public function edit(int $id): View
    {
        $marca = $this->service->find($id);

        return view('equipamentos.marcas-create', compact('marca'));
    }

    public function store(StoreMarcaEquipamentoRequest $request): RedirectResponse
    {
        $this->service->create($request->validated());

        return redirect()->route('equipamentos.marcas');
    }

    public function update(UpdateMarcaEquipamentoRequest $request, int $id): RedirectResponse
    {
        $this->service->update($id, $request->validated());

        return redirect()->route('equipamentos.marcas');
    }

    public function destroy(int $id): RedirectResponse
    {
        try {
            $this->service->delete($id);
        } catch (\DomainException $e) {
            return redirect()->route('equipamentos.marcas')->with('error', $e->getMessage());
        }

        return redirect()->route('equipamentos.marcas');
    }
}
