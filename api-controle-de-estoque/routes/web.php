<?php

use App\Http\Controllers\Web\ArquivoImagemController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\CondicaoOperacionalEquipamentoController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\EquipamentoPatrimoniadoController;
use App\Http\Controllers\Web\EspacoArmazenamentoController;
use App\Http\Controllers\Web\ImagemUploadController;
use App\Http\Controllers\Web\ItemEstoqueController;
use App\Http\Controllers\Web\MarcaEquipamentoController;
use App\Http\Controllers\Web\RegistroAuditoriaController;
use App\Http\Controllers\Web\TipoEquipamentoController;
use App\Http\Controllers\Web\UnidadeOrganizacionalController;
use App\Http\Controllers\Web\UsuarioSistemaController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/perfil-usuario', [UsuarioSistemaController::class, 'editLoggedUser']);
    Route::put('/perfil-usuario', [UsuarioSistemaController::class, 'updateLoggedUser']);

    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('is.administrador:administrador');

    Route::redirect('/', '/equipamentos-patrimoniados');

    Route::get('/registros-auditoria', [RegistroAuditoriaController::class, 'index']);

    Route::post('/imagens/{tipo}/{entidadeId}', [ImagemUploadController::class, 'upload']);
    Route::delete('/imagens/{tipo}/{entidadeId}', [ImagemUploadController::class, 'delete']);
    Route::get('/imagens/{tipo}/{entidadeId}', [ImagemUploadController::class, 'servir']);

    // === ADMIN + OPERADOR + CONSULTA (read-only) ===
    Route::middleware('is.administrador:administrador,operador,consulta')->group(function () {
        Route::get('/equipamentos-patrimoniados', [EquipamentoPatrimoniadoController::class, 'index'])->name('equipamentos-patrimoniados.index');
        Route::get('/equipamentos-patrimoniados/{id}/editar', [EquipamentoPatrimoniadoController::class, 'edit'])->name('equipamentos-patrimoniados.edit');
        Route::get('/itens-estoque', [ItemEstoqueController::class, 'index'])->name('itens-estoque.index');
        Route::get('/itens-estoque/{id}/editar', [ItemEstoqueController::class, 'edit'])->name('itens-estoque.edit');
    });

    // === ADMIN + OPERADOR ===
    Route::middleware('is.administrador:administrador,operador')->group(function () {
        Route::prefix('equipamentos-patrimoniados')->name('equipamentos-patrimoniados.')->group(function () {
            Route::get('/novo', [EquipamentoPatrimoniadoController::class, 'create'])->name('create');
            Route::post('/', [EquipamentoPatrimoniadoController::class, 'store']);
            Route::put('/{id}', [EquipamentoPatrimoniadoController::class, 'update']);
            Route::delete('/{id}', [EquipamentoPatrimoniadoController::class, 'destroy']);
        });

        Route::prefix('itens-estoque')->name('itens-estoque.')->group(function () {
            Route::get('/novo', [ItemEstoqueController::class, 'create'])->name('create');
            Route::post('/', [ItemEstoqueController::class, 'store']);
            Route::put('/{id}', [ItemEstoqueController::class, 'update']);
            Route::delete('/{id}', [ItemEstoqueController::class, 'destroy']);
        });

        Route::prefix('equipamentos/condicoes')->name('equipamentos.condicoes')->group(function () {
            Route::get('/', [CondicaoOperacionalEquipamentoController::class, 'index']);
            Route::get('/novo', [CondicaoOperacionalEquipamentoController::class, 'create'])->name('.create');
            Route::post('/', [CondicaoOperacionalEquipamentoController::class, 'store']);
            Route::get('/{id}/editar', [CondicaoOperacionalEquipamentoController::class, 'edit'])->name('.edit');
            Route::put('/{id}', [CondicaoOperacionalEquipamentoController::class, 'update']);
            Route::delete('/{id}', [CondicaoOperacionalEquipamentoController::class, 'destroy']);
        });

        Route::prefix('equipamentos/imagens')->name('equipamentos.imagens')->group(function () {
            Route::get('/', [ArquivoImagemController::class, 'index']);
            Route::get('/novo', [ArquivoImagemController::class, 'create'])->name('.create');
            Route::post('/', [ArquivoImagemController::class, 'store']);
            Route::get('/{id}/editar', [ArquivoImagemController::class, 'edit'])->name('.edit');
            Route::put('/{id}', [ArquivoImagemController::class, 'update']);
            Route::delete('/{id}', [ArquivoImagemController::class, 'destroy']);
        });
    });

    // === ADMIN ONLY ===
    Route::middleware('is.administrador:administrador')->group(function () {
        Route::prefix('espacos-armazenamento')->name('espacos-armazenamento.')->group(function () {
            Route::get('/', [EspacoArmazenamentoController::class, 'index'])->name('index');
            Route::get('/novo', [EspacoArmazenamentoController::class, 'create'])->name('create');
            Route::post('/', [EspacoArmazenamentoController::class, 'store']);
            Route::get('/{id}/editar', [EspacoArmazenamentoController::class, 'edit'])->name('edit');
            Route::put('/{id}', [EspacoArmazenamentoController::class, 'update']);
            Route::delete('/{id}', [EspacoArmazenamentoController::class, 'destroy']);
        });

        Route::prefix('unidades-organizacionais')->name('unidades-organizacionais.')->group(function () {
            Route::get('/', [UnidadeOrganizacionalController::class, 'index'])->name('index');
            Route::get('/novo', [UnidadeOrganizacionalController::class, 'create'])->name('create');
            Route::post('/', [UnidadeOrganizacionalController::class, 'store']);
            Route::get('/{id}/editar', [UnidadeOrganizacionalController::class, 'edit'])->name('edit');
            Route::put('/{id}', [UnidadeOrganizacionalController::class, 'update']);
            Route::delete('/{id}', [UnidadeOrganizacionalController::class, 'destroy']);
        });

        Route::prefix('usuarios-sistema')->name('usuarios-sistema.')->group(function () {
            Route::get('/', [UsuarioSistemaController::class, 'index'])->name('index');
            Route::get('/novo', [UsuarioSistemaController::class, 'create'])->name('create');
            Route::post('/', [UsuarioSistemaController::class, 'store']);
            Route::get('/{id}/editar', [UsuarioSistemaController::class, 'edit'])->name('edit');
            Route::put('/{id}', [UsuarioSistemaController::class, 'update']);
            Route::delete('/{id}', [UsuarioSistemaController::class, 'destroy']);
            Route::patch('/{id}/toggle-ativo', [UsuarioSistemaController::class, 'toggleActive'])->name('toggle-ativo');
        });

        Route::get('/equipamentos/marcas', [MarcaEquipamentoController::class, 'index'])->name('equipamentos.marcas');
        Route::get('/equipamentos/marcas/novo', [MarcaEquipamentoController::class, 'create'])->name('equipamentos.marcas.create');
        Route::post('/equipamentos/marcas', [MarcaEquipamentoController::class, 'store']);
        Route::get('/equipamentos/marcas/{id}/editar', [MarcaEquipamentoController::class, 'edit'])->name('equipamentos.marcas.edit');
        Route::put('/equipamentos/marcas/{id}', [MarcaEquipamentoController::class, 'update']);
        Route::delete('/equipamentos/marcas/{id}', [MarcaEquipamentoController::class, 'destroy']);

        Route::get('/equipamentos/tipos', [TipoEquipamentoController::class, 'index'])->name('equipamentos.tipos');
        Route::get('/equipamentos/tipos/novo', [TipoEquipamentoController::class, 'create'])->name('equipamentos.tipos.create');
        Route::post('/equipamentos/tipos', [TipoEquipamentoController::class, 'store']);
        Route::get('/equipamentos/tipos/{id}/editar', [TipoEquipamentoController::class, 'edit'])->name('equipamentos.tipos.edit');
        Route::put('/equipamentos/tipos/{id}', [TipoEquipamentoController::class, 'update']);
        Route::delete('/equipamentos/tipos/{id}', [TipoEquipamentoController::class, 'destroy']);
    });
});
