<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layout.main');
});

Route::get("/grupoEconomico", function(){

    $nome = "Serpa";
    $idade = 18;

    return view("layout.grupoEconomico", 
    [
        'nome' => $nome,
        'idade' => $idade
    ]);
});
