<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use App\Models\Lancamentos;
use Illuminate\Http\Request;

class LancamentosController extends Controller
{
    //
    public function create(Request $req, $id) {
    
        $client = Clientes::find($id);
        
        $lancamentos = $req->all();
        
        $data = $client->lancamentos()->create($lancamentos);

        return response()->json($data, 201);
    }
    
    public function store() {
    
        $lancamentos = Lancamentos::select('lancamentos')->orderBy('created_at', 'desc')->get();
        //dd($lancamentos);
        return response()->json(
         $lancamentos,
            200);
    }
}


/* TABELA Lançamentos */                                                /* valores-lacamentos */
/* id | client_id | lanc1 | lanc2 | created_at | updated_at */                          /* id | lanc_id | descricao | salario | valor */