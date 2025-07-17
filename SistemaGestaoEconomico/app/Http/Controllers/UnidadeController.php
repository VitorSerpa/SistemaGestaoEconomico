<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unidade;
use App\Models\Bandeira;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Exception;
class UnidadeController extends Controller
{

    public function exibirUnidades()
    {

        $bandeiras = Bandeira::with('grupo')->get();
        $unidades = Unidade::all();

        return view('layout.unidades', compact('bandeiras', 'unidades'));
    }

    public function postUnidade(Request $request)
    {
        $dados = $request->validate([
            "nome_fantasia" => 'required|string|max:50',
            "razao_social" => 'required|string|max:100',
            "CNPJ" => 'required|string|max:30',
            "id_bandeira" => 'required|integer'
        ]);

        if (!$this->validar_cnpj($dados["CNPJ"])) {
            return redirect()->back()
                ->with('erro_cnpj', 'CNPJ inválido.')
                ->withInput();
        }

        try {
            $unidade = Unidade::create([
                "nome_fantasia" => $dados["nome_fantasia"],
                "razao_social" => $dados["razao_social"],
                "CNPJ" => $dados["CNPJ"],
                "id_bandeira" => $dados["id_bandeira"],
                'data_criacao' => Carbon::now(),
                'ultima_atualizacao' => Carbon::now(),
            ]);

            return redirect()->back()->with('mensagem', 'Unidade criada! ');


        } catch (QueryException $e) {
            return response()->json([
                'erro' => 'Erro ao inserir no banco: ' . $e->getMessage()
            ], 500);
        } catch (Exception $e) {
            return response()->json([
                'erro' => 'Algo deu errado.'
            ], 500);
        }
    }

    public function deleteUnidade(Request $request)
    {
        try {
            $id = $request->get("id");

            $unidade = Unidade::find($id);

            if (!$unidade) {
                return response()->json(["mensagem" => "Unidade não existe"]);
            }

            $unidade->delete();

            return redirect()->back()->with('mensagem', 'Unidade criado com sucesso!');

        } catch (Exception $e) {
            return response()->json([
                'mensagem' => 'Erro ao deletar a Unidade.',
                'erro' => $e->getMessage()
            ], 500);
        }
    }

    protected function validar_cnpj($cnpj)
    {
        $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);

        // Valida tamanho
        if (strlen($cnpj) != 14)
            return false;

        // Verifica se todos os digitos são iguais
        if (preg_match('/(\d)\1{13}/', $cnpj))
            return false;

        // Valida primeiro dígito verificador
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto))
            return false;

        // Valida segundo dígito verificador
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
    }

    public function updateUnidade(Request $request)
    {
        try {
            $id = $request->input('id_unidade');

            $request->validate([
                'nome_fantasia' => 'required|string|max:255',
                'razao_social' => 'required|string|max:255',
                'CNPJ' => 'required|string|max:20',
                'id_bandeira' => 'required|integer',
            ]);

            $unidade = Unidade::find($id);

            if (!$unidade) {
                return redirect()->back()->withErrors(['error' => 'Unidade não encontrada.']);
            }

            $unidade->nome_fantasia = $request->input('nome_fantasia');
            $unidade->razao_social = $request->input('razao_social');
            $unidade->CNPJ = $request->input('CNPJ');
            $unidade->id_bandeira = $request->input('id_bandeira');

            $unidade->save();

            return redirect()->back()->with('mensagem', 'Unidade atualizada com sucesso!');

        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Erro ao atualizar unidade: ' . $e->getMessage()]);
        }
    }
}
