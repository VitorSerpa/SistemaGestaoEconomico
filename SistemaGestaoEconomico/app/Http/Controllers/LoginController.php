<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class LoginController extends Controller
{
    public function autenticar(Request $request)
    {
        $dados = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $dados['username'])->first();

        if ($user && Hash::check($dados['password'], $user->password)) {
            Auth::login($user);
            return redirect()->route('grupoEconomico.view');
        }

        return back()->withErrors(['login' => 'Usuário ou senha incorretos']);
    }
}
