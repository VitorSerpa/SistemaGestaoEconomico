<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bandeira;
use App\Models\GrupoEconomico;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Exception;
use App\Services\RegisterClass;
class BandeiraController extends Controller
{
    public function postBandeira(Request $request)
    {

        $dados = $request->validate([
            "nome_bandeira" => 'required|string|max:50',
            "id_grupo" => 'required|integer'
        ]);

        try {
            $bandeira = Bandeira::create([
                "nome_bandeira" => $dados["nome_bandeira"],
                "id_grupo" => $dados["id_grupo"],
                'data_criacao' => Carbon::now(),
                'ultima_atualizacao' => Carbon::now(),
            ]);

            RegisterClass::anotateAction($dados["nome_bandeira"], "POST", "Bandeira");

            return redirect()->back()->with('mensagem', 'Bandeira criado! ');


        } catch (QueryException $e) {
            return response()->json(['erro', 'Erro ao inserir no banco: ' . $e->getMessage()]);
        } catch (Exception $e) {
            return response()->json(['erro', 'Algo deu errado.']);
        }
    }

    public function deleteBandeira(Request $request)
    {
        try {
            $idDelete = $request->get("id");

            $unidade = Bandeira::find($idDelete);

            if (!$unidade) {
                return response()->json([
                    "mensagem" => "Bandeira não encontrado"
                ]);
            }

            RegisterClass::anotateAction($unidade->nome_bandeira, "DELETE", "Bandeira");

            $unidade->delete();

            return redirect()->back()->with('mensagem', 'Bandeira deletado com sucesso!');


        } catch (Exception $e) {
            return response()->json([
                'mensagem' => 'Erro ao deletar a Bandeira.',
                'erro' => $e->getMessage()
            ], 500);
        }

    }

    public function updateBandeira(Request $request)
    {
        try {
            $id = $request->get('id_bandeira');

            $dadosValidados = $request->validate([
                'novo_nome' => 'required|string|max:50',
                'id_grupo_economico' => 'required|integer|',
            ]);

            $bandeira = Bandeira::find($id);

            if (!$bandeira) {
                return response()->json([
                    'mensagem' => 'Bandeira não encontrada.'
                ], 404);
            }

            $bandeira->nome_bandeira = $dadosValidados['novo_nome'];
            $bandeira->id_grupo = $dadosValidados['id_grupo_economico'];
            $bandeira->save();

            RegisterClass::anotateAction($bandeira->nome_bandeira, "UPDATE", "Bandeira");


            return redirect()->back()->with('mensagem', 'Bandeira atualizada com sucesso!');

        } catch (Exception $e) {
            return response()->json([
                'mensagem' => 'Erro ao atualizar bandeira.',
                'erro' => $e->getMessage()
            ], 500);
        }
    }

    public function exibirBandeiras()
    {
        $bandeiras = Bandeira::with('grupo')->get();
        $grupos = GrupoEconomico::all();

        return view('layout.bandeiras', compact('bandeiras', 'grupos'));
    }
}
