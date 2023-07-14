<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValLancamentos extends Model
{
    use HasFactory;

    protected $fillable = ['lanc_id', 'descricao', 'salario', 'valor'];

    public function lancamentos() {
        return $this->belongsTo(Lancamentos::class, 'lanc_id');
    }
}
