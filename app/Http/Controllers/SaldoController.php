<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use App\Models\Saldos;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Exists;

class SaldoController extends Controller
{

    public function index() {

    }

    public function create(Request $req, $id) {
        //Resolver metodo de crição do saldo baseado no id do cliente
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

        $saldo = Saldos::where('id', $client->id)->first();

        return response()->json($saldo, 200);
    }

}
