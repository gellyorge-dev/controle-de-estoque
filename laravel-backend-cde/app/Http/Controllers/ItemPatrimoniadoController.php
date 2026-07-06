<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemPatrimoniadoRequest;
use App\Http\Requests\UpdateItemPatrimoniadoRequest;
use App\Models\ItemPatrimoniado;

class ItemPatrimoniadoController extends Controller
{
    public function index()
    {
        return ItemPatrimoniado::with(['tipo', 'fabricante', 'localizacao'])->get();
    }

    public function trashed()
    {
        return ItemPatrimoniado::onlyTrashed()
            ->with(['tipo', 'fabricante', 'localizacao'])
            ->get();
    }

    public function store(StoreItemPatrimoniadoRequest $request)
    {
        $item = ItemPatrimoniado::create($request->validated());

        return response()->json($item->load(['tipo', 'fabricante', 'localizacao']), 201);
    }

    public function show(ItemPatrimoniado $itemPatrimoniado)
    {
        return $itemPatrimoniado->load(['tipo', 'fabricante', 'localizacao']);
    }

    public function update(UpdateItemPatrimoniadoRequest $request, ItemPatrimoniado $itemPatrimoniado)
    {
        $itemPatrimoniado->update($request->validated());

        return $itemPatrimoniado->load(['tipo', 'fabricante', 'localizacao']);
    }

    public function destroy(ItemPatrimoniado $itemPatrimoniado)
    {
        $itemPatrimoniado->delete();

        return response()->noContent();
    }

    public function restore(ItemPatrimoniado $itemPatrimoniado)
    {
        $itemPatrimoniado->restore();

        return $itemPatrimoniado->load(['tipo', 'fabricante', 'localizacao']);
    }
}
