<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saldos extends Model
{
    use HasFactory;

    protected $fillable = ['saldo', 'client_id', 'de'];
    
    public function clientes() {
        return $this->belongsTo(Clientes::class, 'client_id');
    }
}
