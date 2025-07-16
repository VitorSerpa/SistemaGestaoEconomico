<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = ['username', 'password', 'is_admin'];
    public $timestamps = true;

    protected $hidden = ['password'];

    public function gruposEconomicos()
    {
        return $this->belongsToMany(GrupoEconomico::class, 'grupo_economico_user', 'user_id', 'id_grupo');
    }
}