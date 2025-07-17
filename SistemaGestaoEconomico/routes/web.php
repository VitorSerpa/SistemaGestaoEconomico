<?php

use App\Http\Controllers\BandeiraController;
use App\Http\Controllers\ColaboradorController;
use App\Http\Controllers\GrupoEconomicoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UnidadeController;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('layout.loginPage');
})->name('login');

Route::post('/login', [LoginController::class, 'autenticar'])->name('login.auth');


Route::get('/view/mainPanel', function () {
    return view('layout.mainPanel');
})->name('main.panel');

// Grupo Econômico
Route::get('/view/grupoEconomico', [GrupoEconomicoController::class, 'exibirGrupos'])->name('grupoEconomico.view');
Route::post("/grupoEconomico", [GrupoEconomicoController::class, "postGrupoEconomico"])->name("grupoEconomico.criar");
Route::get("/grupoEconomico", [GrupoEconomicoController::class, "getGrupoEconomico"])->name("grupoEconomico");
Route::delete("/grupoEconomico", [GrupoEconomicoController::class, "deleteGrupoEconomico"])->name("grupoEconomico.delete");
Route::put("/grupoEconomico", [GrupoEconomicoController::class, "updateGrupoEconomico"])->name("grupoEconomico.atualizar");

// Bandeiras
Route::get("/view/bandeiras", [BandeiraController::class, "exibirBandeiras"])->name("bandeira.get");
Route::post("/bandeiras", [BandeiraController::class, "postBandeira"])->name("bandeira.post");
Route::delete("/bandeiras", [BandeiraController::class, "deleteBandeira"])->name("bandeira.delete");
Route::put("/bandeiras", [BandeiraController::class, "updateBandeira"])->name("bandeira.atualizar");

// Unidades
Route::get("/view/unidades", [UnidadeController::class, "exibirUnidades"])->name("unidades.get");
Route::post("/unidades", [UnidadeController::class, "postUnidade"])->name("unidades.post");
Route::delete("/unidades", [UnidadeController::class, "deleteUnidade"])->name("unidades.delete");
Route::put("/unidades", [UnidadeController::class, "updateUnidade"])->name("unidades.atualizar");

//Colaboradores
Route::post("/colaboradores", [ColaboradorController::class, "postColaborador"])->name("colaborador.post");
Route::get("/view/colaboradores", [ColaboradorController::class, "exibirColaboradores"])->name("colaborador.get");
Route::put("/colaborador", [ColaboradorController::class, "updateColaborador"])->name("colaborador.atualizar");
Route::delete("/colaborador", [ColaboradorController::class, "deleteColaborador"])->name("colaborador.delete");

