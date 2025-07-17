<?php

namespace App\Http\Controllers;

use App\Models\Unidade;
use Illuminate\Http\Request;
use App\Models\Colaborador;
use Carbon\Carbon;
use Exception;
class ColaboradorController extends Controller
{
    public function postColaborador(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'CPF' => 'required|string|max:25',
            'id_unidade' => 'required|integer',
        ]);

        if (!$this->validaCPF($dados['CPF'])) {
            return redirect()->back()->with('alert', 'CPF inválido! Por favor, verifique o número informado.');
        }

        try {
            Colaborador::create([
                'nome' => $dados['nome'],
                'email' => $dados['email'],
                'CPF' => $dados['CPF'],
                'id_unidade' => $dados['id_unidade'],
                'data_criacao' => Carbon::now(),
                'ultima_atualizacao' => Carbon::now(),
            ]);

            return redirect()->back()->with('mensagem', 'Colaborador criado com sucesso!');
        } catch (Exception $e) {
            return redirect()->back()->with('erro', 'Erro ao inserir colaborador: ' . $e->getMessage());
        }
    }
    public function deleteColaborador(Request $request)
    {
        try {
            $id = $request->get("id");

            $colaborador = Colaborador::find($id);

            if (!$colaborador) {
                return response()->json(["mensagem" => "Colaborador não existe"], 404);
            }

            $colaborador->delete();

            return redirect()->back()->with('mensagem', 'Colaborador deletado com sucesso!');

        } catch (Exception $e) {
            return response()->json([
                'mensagem' => 'Erro ao deletar o colaborador.',
                'erro' => $e->getMessage()
            ], 500);
        }
    }

    public function exibirColaboradores()
    {
        $unidades = Unidade::all();
        $colaboradores = Colaborador::with('unidade')->get();

        return view('layout.colaboradores', compact('unidades', 'colaboradores'));
    }



    public function updateColaborador(Request $request)
    {
        try {
            $id = $request->input('id_colaborador');

            $request->validate([
                'nome' => 'required|string',
                'email' => 'required|email',
                'CPF' => 'required|string',
                'id_unidade_hidden' => 'required|integer',
            ]);

            $colaborador = Colaborador::find($id);

            if (!$colaborador) {
                return redirect()->back()->withErrors(['error' => 'Colaborador não encontrado.']);
            }

            $colaborador->nome = $request->input('nome');
            $colaborador->email = $request->input('email');
            $colaborador->CPF = $request->input('CPF');
            $colaborador->id_unidade = $request->input('id_unidade_hidden');

            $colaborador->save();

            return redirect()->back()->with('mensagem', 'Colaborador atualizado com sucesso!');

        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Erro ao atualizar colaborador: ' . $e->getMessage()]);
        }
    }

    public function validaCPF($cpf)
    {

        // Extrai somente os números
        $cpf = preg_replace('/[^0-9]/is', '', $cpf);

        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    }
}
