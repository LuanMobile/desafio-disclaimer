<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessLancJob;
use App\Models\Clientes;
use App\Models\Lancamentos;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class LancamentosController extends Controller
{
    //
    public function create(Request $req, $id) {
    
        $client = Clientes::find($id);

        $newLancamento = $req->all();
        $reqCache = Cache::get('req');
        $requisicaoAtualJson = json_encode($newLancamento);
        $requisicaoAnteriorJson = json_encode($reqCache);

        //Aplicando idempotencia
        if ($requisicaoAtualJson === $requisicaoAnteriorJson) {

            return response()->json(['message' => 'Essa requisição foi feita recentemente!']);
        }

        Cache::put('req', $newLancamento, 300);
        ProcessLancJob::dispatch($id, $newLancamento)->onQueue('lancamentos');

        return response()->json($newLancamento, 201);
    }
    
    public function sendFile(Request $req, $id) {

        $client = Clientes::find($id);

        if ($req->hasFile('file')) {
            $file = $req->file('file');
            $fileContent = file_get_contents($file->getRealPath());

            // Criar um novo lançamento para o cliente e salvar o conteúdo do arquivo nele
            $lancamento = new Lancamentos();
            $lancamento->file_lancamentos = $fileContent;
            $client->lancamentos()->save($lancamento);
    
            return response()->json(['message' => 'Arquivo enviado e salvo com sucesso!']);
        } else {
            return response()->json(['message' => 'Nenhum arquivo foi enviado.'], 400);
        }
    }

    public function store($id) {

        $client = Clientes::find($id);
        $dataLanc = Lancamentos::select('created_at')->first();
        $data = $dataLanc->created_at;
        $date = date('Y-m-d', strtotime($data));

        $lancamentos = Lancamentos::select('lancamentos')->where([
            ['client_id', $id],
            ['created_at', '>', Carbon::now()->subDays(90)]
            ])->orderBy('created_at', 'desc')->get();

        return response()->json(
            ["$date" =>
            $lancamentos],
            200);
    }

    public function download($id) {

        $client = Clientes::find($id);
        $lancamentos = Lancamentos::select('lancamentos')->where([
            ['client_id', $id],
            ['created_at', '<', Carbon::now()->subDays(90)]
            ])->orderBy('created_at', 'desc')->get();
        
        $fileLanc = 'lancamentos.txt';
        $fileContent = file_put_contents($fileLanc, $lancamentos);

        return response()->download($fileLanc);
    }
}