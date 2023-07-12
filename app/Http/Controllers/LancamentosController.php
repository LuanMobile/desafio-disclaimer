<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use App\Models\Lancamentos;
use Illuminate\Http\Request;

class LancamentosController extends Controller
{
    
    public function create(Request $req, $id) {
    
        $client = Clientes::find($id);
    
        $data = $req->validate([
            'descricao' => 'required|string',
            'salario' => 'required|string',
            'valor' => 'required|numeric'
        ]); 
        dd($data);
        /* $data = $client->lancamentos()->create([
            'descricao' => ]); */

        return response()->json($data, 201);
    }
    
    public function store() {
    
        $lancamentos = Lancamentos::orderBy('created_at', 'desc')->get();
    
        return response()->json([
            'lancamentos:' => $lancamentos],
            200);
    }
}


/* TABELA Lançamentos */                                                /* valores-lacamentos */
/* id | client_id | lanc1 | lanc2 | created_at | updated_at */                          /* id | lanc_id | descricao | salario | valor */