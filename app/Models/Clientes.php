<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function saldos() {
        
        return $this->hasOne(Saldos::class, 'client_id');
    }

    public function lancamentos() {
        return $this->hasMany(Lancamentos::class, 'client_id');
    }
}
