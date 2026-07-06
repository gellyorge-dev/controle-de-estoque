<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::prefix('tipos')->group(function () {
    Route::get('/', fn () => view('tipos.index'))->name('tipos.index');
});

Route::prefix('fabricantes')->group(function () {
    Route::get('/', fn () => view('fabricantes.index'))->name('fabricantes.index');
});

Route::prefix('localizacoes')->group(function () {
    Route::get('/', fn () => view('localizacoes.index'))->name('localizacoes.index');
});

Route::prefix('itens-de-quantidade')->group(function () {
    Route::get('/', fn () => view('itens-quantidade.index'))->name('itens-quantidade.index');
});

Route::prefix('itens-patrimoniados')->group(function () {
    Route::get('/', fn () => view('itens-patrimoniados.index'))->name('itens-patrimoniados.index');
});
