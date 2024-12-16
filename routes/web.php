<?php

use App\Http\Controllers\SapaController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

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
})->name('make_url');
Route::get('/redirect-named-route2', function() {
    return to_route('make_url');
})->name('redirect2');
Route::get('/redirect-named-route', function() {
    return redirect()->route('redirect2');
});


// Named Route dengan parameter
Route::get('/nrp/{param}', function($param){
    return $param;
})->whereAlpha('param')->name('named_route_param');

Route::get('/named-route-param', function(){
    $url = route('named_route_param',['param' => 'qwerty99']);
    return response()->json([
        'data' => [
            'url' => $url,
        ],
    ]);
});

Route::get('/named-param-query', function(){
    $url = route('named_route_param',['param' => 'balqis farah', 'query' => 'anabila']);
    return response()->json([
        'data' => [
            'url' => $url,
        ],
    ]);
});

Route::get('/default-url/{default}', function($defult) {
    return response()->json([
        'data' => [
            'default' => $defult,
        ],
    ]);
})->name('default_param');

Route::get('/def-param', function() {
    $url = route('default_param');
    return response()->json([
        'data' => [
            'url' => $url,
        ],
    ]);
});
