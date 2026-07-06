<?php

use App\Http\Controllers\FabricanteController;
use App\Http\Controllers\ItemDeQuantidadeController;
use App\Http\Controllers\ItemPatrimoniadoController;
use App\Http\Controllers\LocalizacaoController;
use App\Http\Controllers\TipoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/', function () {
    return 'A api esta funcionando!';
});

Route::get('tipos/trashed', [TipoController::class, 'trashed']);
Route::put('tipos/{tipo}/restore', [TipoController::class, 'restore'])->withTrashed();
Route::apiResource('tipos', TipoController::class);

Route::get('fabricantes/trashed', [FabricanteController::class, 'trashed']);
Route::put('fabricantes/{fabricante}/restore', [FabricanteController::class, 'restore'])->withTrashed();
Route::apiResource('fabricantes', FabricanteController::class);

Route::get('localizacoes/trashed', [LocalizacaoController::class, 'trashed']);
Route::put('localizacoes/{localizacao}/restore', [LocalizacaoController::class, 'restore'])->withTrashed();
Route::apiResource('localizacoes', LocalizacaoController::class)
    ->parameters(['localizacoes' => 'localizacao']);

Route::get('itens-de-quantidade/trashed', [ItemDeQuantidadeController::class, 'trashed']);
Route::put('itens-de-quantidade/{item_de_quantidade}/restore', [ItemDeQuantidadeController::class, 'restore'])->withTrashed();
Route::apiResource('itens-de-quantidade', ItemDeQuantidadeController::class)
    ->parameters(['itens-de-quantidade' => 'item_de_quantidade']);

Route::get('itens-patrimoniados/trashed', [ItemPatrimoniadoController::class, 'trashed']);
Route::put('itens-patrimoniados/{item_patrimoniado}/restore', [ItemPatrimoniadoController::class, 'restore'])->withTrashed();
Route::apiResource('itens-patrimoniados', ItemPatrimoniadoController::class)
    ->parameters(['itens-patrimoniados' => 'item_patrimoniado']);
