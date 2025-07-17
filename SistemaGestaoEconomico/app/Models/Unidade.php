<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
    protected $table = "Unidade";

    protected $primaryKey = "id_unidade";

    protected $fillable = [
        "nome_fantasia",
        "razao_social",
        "CNPJ",
        "id_bandeira",
        "data_criacao",
        "ultima_atualizacao"
    ];

    public $timestamps = false;

    public function bandeira()
    {
        return $this->belongsTo(Bandeira::class, 'id_bandeira', 'id_bandeira');
    }

    public function colaboradores()
    {
        return $this->hasMany(Colaborador::class, 'id_unidade', 'id_unidade');
    }
}
