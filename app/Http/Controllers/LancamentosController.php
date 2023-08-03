<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessLancJob;
use App\Models\Clientes;
use App\Models\Lancamentos;
use Illuminate\Http\Request;

class LancamentosController extends Controller
{
    //
    public function create(Request $req, $id) {
    
        $client = Clientes::find($id);
        
        $lancamentos = $req->all();
        
        ProcessLancJob::dispatch($id, $lancamentos)->onQueue('lancamentos');

        return response()->json($lancamentos, 201);
    }
    
    public function sendFile(Request $req, $id) {

        $client = Clientes::find($id);

        if ($req->hasFile('file')) {
            $file = $req->file('file');
            $fileContent = file_get_contents($file->getRealPath());
    
            // Criar um novo lançamento para o cliente e salvar o conteúdo do arquivo nele
            $lancamento = new Lancamentos();
            $lancamento->file_lancamentos = $fileContent;
            //dd($lancamento);
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
        //dd($date); 

        $lancamentos = Lancamentos::select('lancamentos')->where('client_id', $id)->orderBy('created_at', 'desc')->get();

        return response()->json(
            ["$date" =>
            $lancamentos],
            200);
    }
}