<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUnidadeOrganizacionalRequest;
use App\Http\Requests\UpdateUnidadeOrganizacionalRequest;
use App\Services\UnidadeOrganizacionalService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UnidadeOrganizacionalController extends Controller
{
    public function __construct(
        private readonly UnidadeOrganizacionalService $service
    ) {}

    public function index(): View
    {
        $unidades = $this->service->paginate(50);

        return view('unidades-organizacionais.index', compact('unidades'));
    }

    public function create(): View
    {
        return view('unidades-organizacionais.create');
    }

    public function edit(int $id): View
    {
        $unidade = $this->service->find($id);

        return view('unidades-organizacionais.create', compact('unidade'));
    }

    public function store(StoreUnidadeOrganizacionalRequest $request): RedirectResponse
    {
        $this->service->create($request->validated());

        return redirect()->route('unidades-organizacionais.index');
    }

    public function update(UpdateUnidadeOrganizacionalRequest $request, int $id): RedirectResponse
    {
        $this->service->update($id, $request->validated());

        return redirect()->route('unidades-organizacionais.index');
    }

    public function destroy(int $id): RedirectResponse
    {
        try {
            $this->service->delete($id);
        } catch (\DomainException $e) {
            return redirect()->route('unidades-organizacionais.edit', $id)->with('error', $e->getMessage());
        }

        return redirect()->route('unidades-organizacionais.index');
    }
}
