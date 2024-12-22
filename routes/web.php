<?php

use App\Http\Controllers\SapaController;
use App\Models\User;
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
})->name('def_param')->middleware('cek.profile');

//Route Group
// Group by name
Route::name('group_by_name')->group(function() {
    Route::get('/name_one', function() {
        return response()->json([
            'message' => 'hi, im route name_one form route group by name.',
        ]);
    })->name('one');

        Route::get('/name_two', function() {
            return response()->json([
                'message' => 'hi, im route name_two form route group by name.',
            ]);
        })->name('two');
});

// Group by prefix
Route::prefix('group_prefix')->group(function() {
    Route::get('/alpha', function() {
        return response()->json([
            'message' => 'hi, im route alpha with prefix group_prefix, and group by prefix route.'
        ]);
    })->name('group_prefix_alpha');

    Route::get('/beta', function() {
        return response()->json([
            'message' => 'hi, im route beta with prefix group_prefix, and group by prefix route.'
        ]);
    })->name('group_prefix_beta');
});

//Group by middleware
Route::middleware('route.group.middleware')->group(function() {
    Route::get('/group_mid_one', function() {
        return response()->json([
            'message' => 'hi, im route group_mid_one, by route group middleware.'
        ]);
    })->name('group_mid_one');

    Route::get('/group_mid_two', function() {
        return response()->json([
            'message' => 'hi, im route group_mid_two, by route group middleware.'
        ]);
    })->name('route_group_two');
});

// group by middleware more than one
Route::middleware(['cek.profile', 'route.group.middleware'])->group(function() {
    Route::get('/gbm2to', function() {
        return response()->json([
            'message' => 'Route group by middleware more than one.',
        ]);
    });
});

// group by controller
Route::controller(SapaController::class)->group(function(){
    Route::get('/method_sapa1', 'route_group_controller1')->name('rgc1');
    Route::get('/method_sapa2', 'route_group_controller2')->name('rgc2');
});

// group by prefix
Route::prefix('prefix')->group(function() {
    Route::get('/test_pref1', function(){
        return response()->json([
            'message' => route('pref2'),
        ]);
    })->name('pref1');

    Route::get('/test_pref2', function(){
        return response()->json([
            'message' => route('pref1'),
        ]);
    })->name('pref2');
});

// group by name
Route::name('test_name.')->group(function() {
    Route::get('/group_name', function(){
        return response()->json([
            'pesan' => 'ini adalah route dengan nama \'test_name.1\'.',
        ]);
    })->name('1');

    Route::get('/group_name2', function(){
        return response()->json([
            'pesan' => 'ini adalah route dengan nama \'test_name.2\'.',
        ]);
    })->name('2');
});

// Route Model Binding - Implict binding
Route::get('/user/{user}', function(User $user) {
    return response()->json([
        'data' => $user,
    ]);
});

Route::get('/imbin/{user}', [SapaController::class, 'imbinMethod']);
