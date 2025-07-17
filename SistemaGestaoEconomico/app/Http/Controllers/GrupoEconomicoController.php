<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\GrupoEconomico;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Services\RegisterClass;

class GrupoEconomicoController extends Controller
{

    public function exibirGrupos()
    {
        $grupos = GrupoEconomico::all();
        return view('layout.grupoEconomico', compact('grupos'));
    }

    public function exibirGrupo($id)
    {
        $grupo = GrupoEconomico::find($id);

        if (!$grupo) {
            return response()->json([
                "mensagem" => "Unidade não encontrada"
            ]);
        }

        return view("layout.grupoEconomicoGerenciar", ["grupo" => $grupo]);
    }


    public function postGrupoEconomico(Request $request)
    {
        $dados = $request->validate([
            'nome_grupo' => 'required|string|max:50',
        ]);

        try {
            GrupoEconomico::create([
                'nome_grupo' => $dados["nome_grupo"],
                'data_criacao' => Carbon::now(),
                'ultima_atualizacao' => Carbon::now(),
            ]);

            RegisterClass::anotateAction( $dados["nome_grupo"] ,"POST", "Grupo Economico");

            return redirect()->back()->with('mensagem', 'Grupo criado!');
        } catch (QueryException $e) {
            return redirect()->back()->with('erro', 'Erro ao inserir no banco: ' . $e->getMessage());
        } catch (Exception $e) {
            return redirect()->back()->with('erro', 'Algo deu errado.');
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

            $grupo = GrupoEconomico::with('bandeiras.unidades.colaboradores')->find($idDelete);

            $nome_grupo = $grupo->nome_grupo;

            if (!$grupo) {
                return response()->json([
                    "mensagem" => "Grupo não encontrado"
                ]);
            }

            foreach ($grupo->bandeiras as $bandeira) {
                foreach ($bandeira->unidades as $unidade) {
                    $unidade->colaboradores()->delete();
                }
                $bandeira->unidades()->delete();
            }

            $grupo->bandeiras()->delete();

            $grupo->delete();

            RegisterClass::anotateAction($nome_grupo , 'DELETE', "Grupo Economico");

            return redirect()->back()->with('mensagem', 'Grupo Excluido!');

        } catch (Exception $e) {
            return response()->json([
                'mensagem' => 'Erro ao deletar o grupo econômico.',
                'erro' => $e->getMessage()
            ], 500);
        }
    }


    public function updateGrupoEconomico(Request $request)
    {
        try {
            $id = $request->get("id_grupo");

            $request->validate([
                'nome_grupo' => 'required|string|max:50',
            ]);

            $grupo = GrupoEconomico::find($id);

            if (!$grupo) {
                return response()->json([
                    'mensagem' => "Grupo não encontrado."
                ], 404);
            }

            $grupo->nome_grupo = $request->input('nome_grupo');
            $grupo->save();

            RegisterClass::anotateAction($grupo->nome_grupo , 'UPDATE', "Grupo Economico");

            return redirect()->back()->with('mensagem', 'Grupo Atualizado!');

        } catch (Exception $e) {
            return response()->json([
                'mensagem' => 'Erro ao atualizar grupo.',
                'erro' => $e->getMessage()
            ], 500);
        }
    }
}