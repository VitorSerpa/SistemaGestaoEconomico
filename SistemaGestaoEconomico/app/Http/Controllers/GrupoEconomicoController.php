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


class GrupoEconomicoController extends Controller
{

    public function exibirGrupos()
    {
        $grupos = auth()->user()->gruposEconomicos;
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
            'usuario' => 'required|string',
            'senha' => 'required|string',
        ]);

        // Buscar o usuário manualmente
        $usuarioVerificado = User::where('username', $dados['usuario'])->first();

        if (!$usuarioVerificado || !Hash::check($dados['senha'], $usuarioVerificado->password)) {
            return redirect()->back()->with('erro', 'Usuário ou senha incorretos.');
        }

        try {
            $grupo = GrupoEconomico::create([
                'nome_grupo' => $dados["nome_grupo"],
                'data_criacao' => Carbon::now(),
                'ultima_atualizacao' => Carbon::now(),
            ]);

            // Aqui associa ao usuário logado de verdade (que está na sessão)
            $usuarioLogado = Auth::user();
            $usuarioLogado->gruposEconomicos()->attach($grupo->id);

            return redirect()->back()->with('mensagem', 'Grupo criado e associado ao seu usuário!');
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