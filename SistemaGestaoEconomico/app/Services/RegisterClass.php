<?php

namespace App\Services;

use App\Models\Register;
use Carbon\Carbon;
class RegisterClass
{

    public static function anotateAction($object, $action, $group)
    {
        Register::create([
            "grupo" => $group,
            "acao" => $action,
            "data" => Carbon::now(),
            "objeto" => $object
        ]);
    }

    
}