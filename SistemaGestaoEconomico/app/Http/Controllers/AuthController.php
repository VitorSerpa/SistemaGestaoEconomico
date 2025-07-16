<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\GrupoEconomico;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('mainPage');
        }

        return back()->withErrors([
            'username' => 'Usuário ou senha inválidos.',
        ]);
    }

    public function mainPage()
    {
        $user = Auth::user();
        $grupos = $user->gruposEconomicos()->get();

        return view('grupoEconomico', compact('grupos'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}