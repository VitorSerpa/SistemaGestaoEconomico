<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request){
    $credenciais = $request->validate([
        "usuario" => ["required"],
        "password" => ["required"]
    ]);

    if (Auth::attempt([
        'name' => $credenciais['usuario'],
        'password' => $credenciais['password'],
    ])) {
        $request->session()->regenerate();
        return redirect()->intended("mainPanel");
    }

    return redirect()->back()->with("error", "Usuário ou senha inválido");
}
}
