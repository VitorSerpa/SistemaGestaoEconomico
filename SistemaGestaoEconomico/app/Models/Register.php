<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    protected $table = 'logs_grupos';

    public $timestamps = false;

    protected $fillable = [
        'grupo',
        'acao',
        'hora',
        'objeto',
    ];
}