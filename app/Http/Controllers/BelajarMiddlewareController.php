<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BelajarMiddlewareController extends Controller
{
    public function globalMiddleware()
    {
        return response()->json([
            'message' => 'sukses !'
        ], 200);
    }
}
