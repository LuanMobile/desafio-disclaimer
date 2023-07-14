<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lancamentos extends Model
{
    use HasFactory;
    protected $fillable = ['client_id', 'lancamentos'];
    protected $casts = [
        'lancamentos' => 'array'
    ];

    public function clientes() {
        return $this->belongsTo(Clientes::class, 'client_id');
    } 

    public function valLancamentos() {
        return $this->hasMany(ValLancamentos::class, 'lanc_id');
    }
}
