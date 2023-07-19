<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LancamentosController;
use App\Http\Controllers\SaldoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(ClienteController::class)->group(function() {
    
    Route::get('clientes', 'index'); 
    Route::get('clientes/{idCliente}/lancamentos', 'lanc');
    Route::post('cliente/novo', 'create');
});

Route::controller(SaldoController::class)->group(function() {

    Route::post('saldo/{idClient}/novo', 'create');
    Route::get('clientes/{idCliente}/saldo','store');
});

Route::controller(LancamentosController::class)->group( function() {

    Route::get('clientes/{idCliente}/lancamentos', 'store');
    Route::post('lancamentos/{idClient}/novo', 'create');
    Route::post('lancamentos/{idClient}/file', 'sendFile');
});


