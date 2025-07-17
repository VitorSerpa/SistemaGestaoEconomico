<?php

namespace App\Http\Controllers;

use App\Models\Register;
use Illuminate\Http\Request;

class RelatoriosController extends Controller
{
    public function exibirRelatorios()
    {
        $relatorios = Register::orderBy('hora', 'desc')->get();

        return view('layout.relatorios', compact('relatorios'));
    }
}
