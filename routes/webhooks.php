<?php

Use Illuminate\Support\Facades\Route;

Route::get('/test', function(){
    return response()->json([
        'pesan' => 'test new config Routing'
    ]);
});
