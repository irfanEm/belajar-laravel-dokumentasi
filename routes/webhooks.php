<?php

use Illuminate\Http\Request;
Use Illuminate\Support\Facades\Route;

Route::get('/test', function(){
    return response()->json([
        'pesan' => 'test new config Routing'
    ]);
});

// Route parameter
Route::get('/route-par/{nama}', function(string $nama) {
    return response()->json([
        'route-parameter' => $nama
    ]);
});

// Route parameter & dependencies injection
Route::get('/rp-depend/{nama}', function(Request $request, $nama) {
    return response()->json([
        'data' => [
            'request' => $request->header(),
            'nama' => $nama
        ],
    ]);
});

// Optional route parameter
Route::get('/opt-param/{nama?}', function (?string $nama = 'fulan') {
    return response()->json([
        'data' => [
            'nama' => $nama
        ]
    ]);
});
