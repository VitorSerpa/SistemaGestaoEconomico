<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layout.loginPage');
})->name('home');

Route::post("/login", [LoginController::class, "login"])->name("login.perform");
