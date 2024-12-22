<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;

class SapaController extends Controller
{
    use RefreshDatabase;

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

    // method untuk implict binding pada controller
    public function imbinMethod(User $user)
    {
        return response()->json([
            'data' => [
                'user' => [
                    'nama' => $user->name,
                    'email' => $user->email
                ]
            ]
        ]);
    }
}
