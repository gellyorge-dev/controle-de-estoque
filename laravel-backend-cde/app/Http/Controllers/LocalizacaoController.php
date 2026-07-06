<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLocalizacaoRequest;
use App\Http\Requests\UpdateLocalizacaoRequest;
use App\Models\Localizacao;

class LocalizacaoController extends Controller
{
    public function index()
    {
        return Localizacao::all();
    }

    public function trashed()
    {
        return Localizacao::onlyTrashed()->get();
    }

    public function store(StoreLocalizacaoRequest $request)
    {
        $localizacao = Localizacao::create($request->validated());

        return response()->json($localizacao, 201);
    }

    public function show(Localizacao $localizacao)
    {
        return $localizacao;
    }

    public function update(UpdateLocalizacaoRequest $request, Localizacao $localizacao)
    {
        $localizacao->update($request->validated());

        return $localizacao;
    }

    public function destroy(Localizacao $localizacao)
    {
        $localizacao->delete();

        return response()->noContent();
    }

    public function restore(Localizacao $localizacao)
    {
        $localizacao->restore();

        return $localizacao;
    }
}
