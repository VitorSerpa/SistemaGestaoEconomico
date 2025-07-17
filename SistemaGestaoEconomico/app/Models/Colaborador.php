<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Unidade;

class Colaborador extends Model
{
    protected $table = 'Colaborador'; 

    protected $primaryKey = 'id_colaborador';

    public $timestamps = false; 
    protected $fillable = [
        'nome',
        'email',
        'CPF',
        'id_unidade',
        'data_criacao',
        'ultima_atualizacao',
    ];

    public function unidade()
    {
        return $this->belongsTo(Unidade::class, 'id_unidade', 'id_unidade');
    }
}