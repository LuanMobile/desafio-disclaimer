<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use App\Models\Lancamentos;
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

    public function valores($id) {

    }

    public function store($id) {
        $client = Clientes::find($id);

        $valLanc = Lancamentos::all();
        $lancamentosArray = json_decode($valLanc, true);
        //dd($lancamentosArray);

        foreach ($lancamentosArray as $lancamentoA) {
            //dd($lancamentoA);
            if (isset($lancamentoA['lancamentos']) && !empty($lancamentoA['lancamentos'])) {
                // Inicializar um array para armazenar todos os valores
                $valores = [];
                // Percorrer cada elemento do array "lancamentos"
                foreach ($lancamentoA['lancamentos'] as $lancamento) {
                    // Verificar se o campo "valor" existe no elemento e se não está vazio
                    if (isset($lancamento['valor'])) {
                        // Adicionar o valor ao array de valores
                        $valores[] = $lancamento['valor'];
                        //dd($valores);
                    }
                }
            
                // Exibir os valores encontrados
                print_r($valores);
            }
        }
        
        


        
        
        /* $valor = $lancamentosArray[0]['lancamentos'][0]['valor'];
        echo $valor;
        dd($lancamentosArray); */
        $saldo = Saldos::select('saldo')->where('id', $client->id)->first();

        return response()->json($saldo, 200);
    }

}
