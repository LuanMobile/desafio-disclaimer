<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use App\Models\Saldos;
use App\Http\Controllers\CalculaValoresController;
use Illuminate\Http\Request;

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
        $valorTotal = CalculaValoresController::calValores();

        $possuiSaldo = Saldos::where('client_id', $id)->first();
        $saldoAnt = $possuiSaldo->saldo;

        if(!$possuiSaldo) {

            $newSaldo = new Saldos();
            $newSaldo->saldo = $valorTotal;
            $client->saldos()->save($newSaldo);
        }

        return response()->json(["Saldo Atual" => $saldoAtual], 200);
    }
}
