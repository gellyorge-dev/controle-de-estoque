<?php

use App\Http\Controllers\Api\ArquivoImagemController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CondicaoOperacionalEquipamentoController;
use App\Http\Controllers\Api\EquipamentoPatrimoniadoController;
use App\Http\Controllers\Api\EspacoArmazenamentoController;
use App\Http\Controllers\Api\ItemEstoqueController;
use App\Http\Controllers\Api\MarcaEquipamentoController;
use App\Http\Controllers\Api\PerfilUsuarioController;
use App\Http\Controllers\Api\RegistroAuditoriaController;
use App\Http\Controllers\Api\TipoEquipamentoController;
use App\Http\Controllers\Api\UnidadeOrganizacionalController;
use App\Http\Controllers\Api\UsuarioSistemaController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);
});

Route::apiResource('unidades-organizacionais', UnidadeOrganizacionalController::class);
Route::apiResource('espacos-armazenamento', EspacoArmazenamentoController::class);
Route::apiResource('marcas-equipamento', MarcaEquipamentoController::class);
Route::apiResource('tipos-equipamento', TipoEquipamentoController::class);
Route::apiResource('condicoes-operacionais', CondicaoOperacionalEquipamentoController::class);
Route::apiResource('perfis-usuario', PerfilUsuarioController::class);
Route::apiResource('arquivos-imagem', ArquivoImagemController::class);
Route::apiResource('usuarios-sistema', UsuarioSistemaController::class);
Route::apiResource('equipamentos-patrimoniados', EquipamentoPatrimoniadoController::class);
Route::apiResource('itens-estoque', ItemEstoqueController::class);
Route::apiResource('registros-auditoria', RegistroAuditoriaController::class);
