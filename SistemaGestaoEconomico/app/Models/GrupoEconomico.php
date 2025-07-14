<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrupoEconomico extends Model
{
    protected $table = "grupoEconomico";

    protected $primaryKey = "id_grupo";

    protected $fillable = [
        "nome_grupo",
        "data_criacao",
        "ultima_atualizacao"
    ];

    public $timestamps = false;
}
