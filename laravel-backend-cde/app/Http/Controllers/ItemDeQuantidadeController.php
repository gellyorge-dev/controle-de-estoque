<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemDeQuantidadeRequest;
use App\Http\Requests\UpdateItemDeQuantidadeRequest;
use App\Models\ItemDeQuantidade;

class ItemDeQuantidadeController extends Controller
{
    public function index()
    {
        return ItemDeQuantidade::with(['tipo', 'fabricante', 'localizacao'])->get();
    }

    public function trashed()
    {
        return ItemDeQuantidade::onlyTrashed()
            ->with(['tipo', 'fabricante', 'localizacao'])
            ->get();
    }

    public function store(StoreItemDeQuantidadeRequest $request)
    {
        $item = ItemDeQuantidade::create($request->validated());

        return response()->json($item->load(['tipo', 'fabricante', 'localizacao']), 201);
    }

    public function show(ItemDeQuantidade $itemDeQuantidade)
    {
        return $itemDeQuantidade->load(['tipo', 'fabricante', 'localizacao']);
    }

    public function update(UpdateItemDeQuantidadeRequest $request, ItemDeQuantidade $itemDeQuantidade)
    {
        $itemDeQuantidade->update($request->validated());

        return $itemDeQuantidade->load(['tipo', 'fabricante', 'localizacao']);
    }

    public function destroy(ItemDeQuantidade $itemDeQuantidade)
    {
        $itemDeQuantidade->delete();

        return response()->noContent();
    }

    public function restore(ItemDeQuantidade $itemDeQuantidade)
    {
        $itemDeQuantidade->restore();

        return $itemDeQuantidade->load(['tipo', 'fabricante', 'localizacao']);
    }
}
