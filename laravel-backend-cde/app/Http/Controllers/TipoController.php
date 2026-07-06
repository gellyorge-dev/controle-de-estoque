<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTipoRequest;
use App\Http\Requests\UpdateTipoRequest;
use App\Models\Tipo;

class TipoController extends Controller
{
    public function index()
    {
        return Tipo::all();
    }

    public function trashed()
    {
        return Tipo::onlyTrashed()->get();
    }

    public function store(StoreTipoRequest $request)
    {
        $tipo = Tipo::create($request->validated());

        return response()->json($tipo, 201);
    }

    public function show(Tipo $tipo)
    {
        return $tipo;
    }

    public function update(UpdateTipoRequest $request, Tipo $tipo)
    {
        $tipo->update($request->validated());

        return $tipo;
    }

    public function destroy(Tipo $tipo)
    {
        $tipo->delete();

        return response()->noContent();
    }

    public function restore(Tipo $tipo)
    {
        $tipo->restore();

        return $tipo;
    }
}
