<?php

namespace App\Services;

use App\Models\Register;
use Carbon\Carbon;
class RegisterClass
{

    public static function anotateAction($action, $group)
    {
        Register::create([
            "grupo" => $group,
            "acao" => "$action",
            "hora" => Carbon::now()
        ]);
    }



}