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

    public function grupo()
    {
        return $this->belongsTo(GrupoEconomico::class, 'id_grupo', 'id_grupo');
    }

    public function bandeiras()
    {
        return $this->hasMany(Bandeira::class, 'id_grupo', 'id_grupo');
    }

    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'grupo_economico_user', 'id_grupo', 'user_id');
    }
}

