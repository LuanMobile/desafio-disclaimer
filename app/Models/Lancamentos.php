<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lancamentos extends Model
{
    use HasFactory;
    protected $fillable = ['descricao', 'salario', 'valor'];

    public function clientes() {
        return $this->hasMany(Clientes::class, 'client_id');
    } 
}
