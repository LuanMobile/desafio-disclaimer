<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Lancamentos extends Model
{
    use HasFactory;
    protected $fillable = ['client_id', 'lancamentos'];
    protected $casts = [
        'lancamentos' => 'array',
        'created_at' => 'datetime:Y-m-d'
    ];

    public function clientes() {
        return $this->belongsTo(Clientes::class, 'client_id');
    } 

    public function valLancamentos() {
        return $this->hasMany(ValLancamentos::class, 'lanc_id');
    }

    public function formatDate($value) {

        return Carbon::parse($value)->format('Y-m-d');
    }
}
