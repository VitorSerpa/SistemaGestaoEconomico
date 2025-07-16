<?php

use App\Http\Controllers\BandeiraController;
use App\Http\Controllers\GrupoEconomicoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UnidadeController;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('layout.loginPage');
})->name('login');

Route::post('/login', [LoginController::class, 'autenticar'])->name('login.auth');

Route::middleware(['auth'])->group(function () {

    Route::get('/view/mainPanel', function () {
        return view('layout.mainPanel');
    })->name('main.panel');

    // Grupo Econômico
    Route::get('/view/grupoEconomico', [GrupoEconomicoController::class, 'exibirGrupos'])->name('grupoEconomico.view');
    Route::post("/grupoEconomico", [GrupoEconomicoController::class, "postGrupoEconomico"])->name("grupoEconomico.criar");
    Route::get("/grupoEconomico", [GrupoEconomicoController::class, "getGrupoEconomico"])->name("grupoEconomico");
    Route::delete("/grupoEconomico", [GrupoEconomicoController::class, "deleteGrupoEconomico"])->name("grupoEconomico.delete");

    // Bandeiras
    Route::get("/view/bandeiras", [BandeiraController::class, "exibirBandeiras"])->name("bandeira.get");
    Route::post("/bandeiras", [BandeiraController::class, "postBandeira"])->name("bandeira.post");
    Route::delete("/bandeiras", [BandeiraController::class, "deleteBandeira"])->name("bandeira.delete");

    // Unidades
    Route::get("/view/unidades", [UnidadeController::class, "exibirUnidades"])->name("unidades.get");
    Route::post("/unidades", [UnidadeController::class, "postUnidade"])->name("unidades.post");
    Route::delete("/unidades", [UnidadeController::class, "deleteUnidade"])->name("unidades.delete");

    // Logout
    Route::post('/logout', function () {
        auth()->logout();
        return redirect('/login');
    })->name('logout');
});