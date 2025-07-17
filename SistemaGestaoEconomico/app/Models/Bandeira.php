<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\GrupoEconomico;

class Bandeira extends Model
{
    protected $table = "Bandeira";

    protected $primaryKey = "id_bandeira";


    protected $fillable = [
        "nome_bandeira",
        "id_grupo",
        "data_criacao",
        "ultima_atualizacao"
    ];

    public $timestamps = false;

    public function grupo()
    {
        return $this->belongsTo(GrupoEconomico::class, 'id_grupo', 'id_grupo');
    }

    public function unidades()
    {
        return $this->hasMany(Unidade::class, 'id_bandeira', 'id_bandeira');
    }
}


