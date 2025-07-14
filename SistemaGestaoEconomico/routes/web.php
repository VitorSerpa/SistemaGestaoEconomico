<?php

use App\Http\Controllers\GrupoEconomicoController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/view', function () {
    return view('layout.loginPage');
})->name('home');

Route::get('/view/mainPanel', function () {
    return view('layout.mainPanel');
})->name('home');

Route::get('/view/grupoEconomico', [GrupoEconomicoController::class, 'exibirGrupos'])->name('grupoEconomico.view');


Route::post("/login", [LoginController::class, "login"])->name("login.perform");

Route::post("/grupoEconomico", [GrupoEconomicoController::class, "postGrupoEconomico"])->name("grupoEconomico.criar");

Route::get("/grupoEconomico", [GrupoEconomicoController::class, "getGrupoEconomico"])->name("grupoEconomico");

Route::get("/grupoEconomico/{nome}", [GrupoEconomicoController::class, "getGrupoEconomicoURL"])->name("grupoEconomico");

Route::delete("/grupoEconomico", [GrupoEconomicoController::class, "deleteGrupoEconomico"])->name("grupoEconomico.delete");


