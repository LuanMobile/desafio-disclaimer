<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use App\Models\Saldos;
use App\Http\Controllers\CalculaValoresController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SaldoController extends Controller
{

    public function store($id) {

        $client = Clientes::find($id);
        $valorTotal = new CalculaValoresController();
        $valorT = $valorTotal->calValores($id);
        $possuiSaldo = Saldos::where('client_id', $id)->first();
        Cache::get('req');

        if ($possuiSaldo) {
            
            $possuiSaldo->saldo = $valorT;
            $possuiSaldo->save();
            Cache::put('req', $possuiSaldo, 300);
            return response()->json(["Saldo Atual" => $possuiSaldo->saldo], 200);
        } else {

            $newSaldo = new Saldos();
            $newSaldo->saldo = $valorT;
            $client->saldos()->save($newSaldo);
            return response()->json(["Saldo Atual" => $newSaldo], 200);
        }
    }
}
