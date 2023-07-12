<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function saldo($id) {

        
    }

    public function create(Request $request) {

        $data = $request->validate([
            'name' => 'required|string',
        ]);

        $newClient = Clientes::create($data);

        return response()->json(['cliente' => $newClient, 201]);
    }
}
