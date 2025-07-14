<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\GrupoEconomico;

class GrupoEconomicoController extends Controller
{

    public function exibirGrupos()
    {
        $grupos = GrupoEconomico::all();
        return view('layout.grupoEconomico', compact('grupos'));
    }

    public function postGrupoEconomico(Request $request)
    {

        $dados = $request->validate([
            'nome_grupo' => 'required|string|max:50'
        ]);

        try {
            $grupo = GrupoEconomico::create([
                'nome_grupo' => $dados["nome_grupo"],
                'data_criacao' => Carbon::now(),
                'ultima_atualizacao' => Carbon::now(),
            ]);

            return response()->json([
                "mensagem" => "Grupo economico criado com sucesso",
                "grupo" => $grupo
            ], 201);
        } catch (QueryException $e) {
            return response()->json([
                "mensagem" => "Erro ao inserir dados no banco de dados. $e"
            ], 500);
        } catch (Exception $e) {
            return response()->json([
                "mensagem" => "Algo deu errado"
            ], 500);
        }
    }

    public function getGrupoEconomico(Request $request)
    {
        try {
            $grupos = GrupoEconomico::all();

            return response()->json([
                "mensagem" => $grupos
            ]);
        } catch (QueryException $e) {
            return response()->json([
                "mensagem" => "Erro ao buscar no dados no banco de dados. $e"
            ], 500);
        } catch (Exception $e) {
            return response()->json([
                "mensagem" => "Algo deu errado"
            ], 500);
        }
    }

    public function getGrupoEconomicoURL($nome)
    {
        try {
            $grupo = GrupoEconomico::where("nome_grupo", "like", "%$nome%")->get();

            return response()->json([
                "mensagem" => $grupo
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "mensagem" => "Algo deu errado",
                "" => $e->getMessage()
            ], 500);
        }
    }

    public function deleteGrupoEconomico(Request $request)
    {
        try {
            $idDelete = $request->get("id");

            $grupo = GrupoEconomico::find($idDelete);

            if (!$grupo) {
                return response()->json([
                    "mensagem" => "Grupo não encontrado"
                ]);
            }

            $grupo->delete();

            return response()->json([
                'mensagem' => 'Grupo econômico deletado com sucesso.'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'mensagem' => 'Erro ao deletar o grupo econômico.',
                'erro' => $e->getMessage()
            ], 500);

        }
    }
}