<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFabricanteRequest;
use App\Http\Requests\UpdateFabricanteRequest;
use App\Models\Fabricante;

class FabricanteController extends Controller
{
    public function index()
    {
        return Fabricante::all();
    }

    public function trashed()
    {
        return Fabricante::onlyTrashed()->get();
    }

    public function store(StoreFabricanteRequest $request)
    {
        $fabricante = Fabricante::create($request->validated());

        return response()->json($fabricante, 201);
    }

    public function show(Fabricante $fabricante)
    {
        return $fabricante;
    }

    public function update(UpdateFabricanteRequest $request, Fabricante $fabricante)
    {
        $fabricante->update($request->validated());

        return $fabricante;
    }

    public function destroy(Fabricante $fabricante)
    {
        $fabricante->delete();

        return response()->noContent();
    }

    public function restore(Fabricante $fabricante)
    {
        $fabricante->restore();

        return $fabricante;
    }
}
