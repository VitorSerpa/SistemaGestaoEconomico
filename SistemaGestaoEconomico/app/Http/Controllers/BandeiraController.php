<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bandeira;
use App\Models\GrupoEconomico;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Exception;
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

            $unidade->delete();

            return response()->json([
                'mensagem' => 'Bandeira deletada com sucesso.'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'mensagem' => 'Erro ao deletar a Bandeira.',
                'erro' => $e->getMessage()
            ], 500);
        }

    }

    public function exibirBandeiras()
    {
        $user = auth()->user();
        $grupos = $user->gruposEconomicos()->pluck('grupoEconomico.id_grupo')->toArray();
        $bandeiras = Bandeira::whereIn('id_grupo', $grupos)->with('grupo')->get();
        $grupos = GrupoEconomico::whereIn('id_grupo', $grupos)->get();

        return view('layout.bandeiras', compact('bandeiras', 'grupos'));
    }
}
