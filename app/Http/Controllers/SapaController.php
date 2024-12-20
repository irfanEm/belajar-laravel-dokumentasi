<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SapaController extends Controller
{
    public function sapa(): string
    {
        return 'Assalamualaikum..saya sapa controller';
    }

    public function route_group_controller1(): string
    {
        return 'hai saya berasal dari method \'route_group_controller1\' dari controller \'sapa\'.';
    }

    public function route_group_controller2(): string
    {
        return 'hai saya berasal dari method \'route_group_controller2\' dari controller \'sapa\'.';
    }
}
