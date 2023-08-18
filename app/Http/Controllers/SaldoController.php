<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use App\Models\Saldos;
use App\Http\Controllers\CalculaValoresController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SaldoController extends Controller
{

    public function create(Request $req, $id) {
        
        $client = Clientes::find($id);

        $data = $req->validate([
            'saldo' => 'required|numeric|min:0.01'
        ]);

        $possuiSaldo = Saldos::where([
            ['client_id', $client->id]
        ])->first();

        if($possuiSaldo) {

            return response()->json(['error' => 'Já existe um saldo cadastrado para este cliente.'], 400);
        }
        else {
            // Busco o id do cliente e na minha tabela saldos crio o saldo baseado no id_cliente
            $newSaldo = $client->saldos()->create($data);
        }

        return response()->json([ 'saldo' => $newSaldo], 201);
    }


    public function store($id) {

        $client = Clientes::find($id);
        $valorTotal = CalculaValoresController::calValores($id);
        $possuiSaldo = Saldos::where('client_id', $id)->first();
        Cache::get('req');

        if ($possuiSaldo) {
            
            $possuiSaldo->saldo = $valorTotal;
            $possuiSaldo->save();
            Cache::put('req', $possuiSaldo, 300);
            return response()->json(["Saldo Atual" => $possuiSaldo->saldo], 200);
        } else {

            $newSaldo = new Saldos();
            $newSaldo->saldo = $valorTotal;
            $client->saldos()->save($newSaldo);
            return response()->json(["Saldo Atual" => $newSaldo], 200);
        }
    }
}
