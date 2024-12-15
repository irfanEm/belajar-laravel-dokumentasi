<?php

use App\Http\Controllers\SapaController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// basic route laravel
Route::get('/salam', function(){
    return 'Assalamualaikum';
});

Route::get('/sapa', [SapaController::class, 'sapa'])->name('sapa_controller');

Route::get('/rec/{id}/{nama}', function(int $id, string $nama):JsonResponse
{
    return response()->json([
        'data' => [
            'id' => $id,
            'nama' => $nama,
        ],
    ]);
})->where(['id'=>'[0-9]+', 'nama'=>'[a-zA-Z]+']);

// Global Constraint
Route::get('/gb_id/{gb_id}', function($gb_id) {
    return response()->json([
        'data' => [
            'global constraint Id' => $gb_id,
        ],
    ]);
});

// Encoded forward slashes
Route::get('/encoded-forward-slashes/test/{param}', function(string $param) {
    return response()->json([
        'data' => [
            'encoded forward slashes' => $param,
        ],
    ]);
})->where('param','.*');

// Named Routes
Route::get('/named-route1', function(){
    return response()->json([
        'data' => [
            'pesan'=> 'named route test 1'
        ]
    ]);
})->name('test_named_routes1');

Route::get('/url-named-route', function(){
    $url1 = route('test_named_routes1');
    $url2 = route('sapa_controller');
    return response()->json([
        'data' => [
            'url' => [
                'test-named-route' => $url1,
                'sapa-controller' => $url2,
            ],
        ],
    ]);
});
