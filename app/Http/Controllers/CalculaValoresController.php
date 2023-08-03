<?php

namespace App\Http\Controllers;

use App\Models\Lancamentos;

class CalculaValoresController extends Controller
{

    static function calValores() {

        $valLanc = Lancamentos::all();
        $lancamentosArray = json_decode($valLanc, true);

        foreach ($lancamentosArray as $lancamentoA) {

            if (isset($lancamentoA['lancamentos']) && !empty($lancamentoA['lancamentos'])) {
                // Inicializar um array para armazenar todos os valores
                $valores = [];
                // Percorrer cada elemento do array "lancamentos"
                foreach ($lancamentoA['lancamentos'] as $lancamento) {
                    // Verificar se o campo "valor" existe no elemento e se não está vazio
                    if (isset($lancamento['valor'])) {
                        // Adicionar o valor ao array de valores
                        $valores[] = $lancamento['valor'];
                        
                    }
                }

                if($valores) {

                    $totalValor[] = array_sum($valores);
                    //print_r($totalValor);
                    $collect = collect($totalValor);
                    $total = $collect->sum();

                }
            }
        }

        return $total;
    }
}
