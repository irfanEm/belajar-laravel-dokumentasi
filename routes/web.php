<?php

use App\Enums\Category;
use App\Http\Controllers\BelajarMiddlewareController;
use App\Http\Controllers\LocationsController;
use App\Http\Controllers\SapaController;
use App\Http\Controllers\UploadController;
use App\Http\Middleware\EnsureSecurityToken;
use App\Models\Item;
use App\Models\ItemDetail;
use App\Models\Post;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
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

// Soft Deletes dan Implict Binding
Route::get('/softdel/{user}', [SapaController::class, 'softDelMeth'])->withTrashed()->name('softDelImBin');

// Customizing the key Implict Binding
Route::get("/custom_key_route/{user:email}", function(User $user){
    if($user->trashed())
    {
        return response()->json([
            'message' => 'User telah dihapus.',
            'nama' => $user->name,
            'email' => $user->email,
        ]);
    }

    return response()->json([
        'message' => 'User active.',
        'nama' => $user->name,
        'email' => $user->email,
    ]);

})->name("custom_key_imbin")->withTrashed();

Route::get("/custom_key_controller/{user:email}", [SapaController::class, "custome_key_imbin"])->name("custome_key_controller")->withTrashed();

// custome key with getRouteKeyName method
Route::get("/getroutekeyname/{user}", [SapaController::class, "custome_key_imbin"])->name("customeWithGetRouteKeyNameMethod");

// Route custome key & scoping
Route::get("/custom_key_and_scoping/controller/user/{user}/post/{post:slug}", [SapaController::class, 'customKeyAndScoping'])->name('customKeyAndScopingController');
Route::get("/custom_key_and_scoping/route/user/{user}/post/{post:slug}", function(User $user, Post $post) {
    return response()->json([
        'data' => [
            'user' => [
                'name' => $user->name,
                'email' => $user->email
            ],
            'post' => [
                'title' => $post->title,
                'slug' => $post->slug,
                'content' => $post->content,
            ]
        ]
    ]);
})->name('customKeyAndScopingRoute');

// Route for custome model binding behavior
Route::name('locations.')->group(function() {
    Route::get("/custom_model_binding_behavior/locations",[LocationsController::class, 'index'])->name('index');
    Route::get("/custome_model_binding_behavior/location/show/{location:slug}", [LocationsController::class, 'show'])->name('show')
        ->missing(function (Request $request) {
            return Redirect::route('locations.index');
        });
});

// Route implicit enum binding
Route::get("/implicit_enum_binding/{category}", function(Category $category){
    return response()->json([
        'data' => [
            'category' => $category->value,
        ]
    ]);
})->name("route-implicit-enum-binding");

// Route Explicit Binding
Route::get("/explicit_binding/{user}", function(User $user) {
    return response()->json([
        'data' => [
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
            ]
        ],
    ]);
})->name('explicit_binding_route');

// Route for customizing resolve logic
Route::get("/custom_resolve_logic/{item}", function(Item $item) {
return response()->json([
    'data' => [
        'item' => [
            'name' => $item->name,
            'description' => $item->description,
            'quantity' => $item->quantity,
        ]
    ],
]);
})->name("custom_resolve_logic_with_bind_method");

Route::get("/custome_resolve_logic/item/{item}/detail/{item_detail}", function(Item $item, ItemDetail $itemDetail) {
    return response()->json([
        'data' => [
            'item' => [
                'name' => $item->name,
                'description' => $item->description,
                'quantity' => $item->quantity,
                'detail' => $itemDetail->id,
            ]
        ]
    ]);
})->name("custom_resolve_logic_with_resolve_child_route_binding");

// Fallback Route
Route::fallback(function(){
    return response()->view('errors.404', [], 404);
})->name('fallback');

// Route for RouteLimiter
Route::middleware('throttle:upload')->group(function() {
    Route::post('/route-limiter/upload', [UploadController::class, 'upload'])->name('upload_rate_limiter');
})->name('RouteLImiterTest');

// BELAJAR MIDDLEWARE

Route::get('/global-middleware', [BelajarMiddlewareController::class, 'globalMiddleware'])->middleware(EnsureSecurityToken::class);

// stream

Route::get('/stream', function(){

    return response()->stream(function(){
        $handle = fopen('php://output', 'w');

        fputcsv($handle, ['ID', 'Nama', 'Email']);

        $students = Student::chunk(100, function($students) use ($handle){
            foreach($students as $student) {
                fputcsv($handle, [
                    $student->id,
                    $student->name,
                    $student->email
                ]);
                ob_flush();
                flush();
            }
        });

        fclose($handle);
    }, 200, [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="students.csv"',
        'X-Accel-Buffering' => 'no'
    ]);
});
// streamDownload Route Test

Route::withoutMiddleware([EnsureSecurityToken::class])->group(function(){

    Route::get('/stream-download-page', function() {
        // Pastikan view-nya ada
        return response()
            ->view('stream-download');
    });

    Route::get('/stream-download', function(){
        $filename = 'users-' . now()->format('Y-m-d H:i:s') . '.csv';

        return response()->streamDownload(function(){
            $handle = fopen('php://output', 'w');

            fputcsv ($handle, ['ID', 'Nama', 'Email', 'Tgl Daftar']);

            Student::chunk(100, function($students) use ($handle) {
                foreach($students as $student) {
                    fputcsv($handle, [
                        $student->id,
                        $student->name,
                        $student->email,
                        $student->created_at->format('d-m-Y'),
                    ]);
                }
            });

            fclose($handle);

        }, $filename);
    });

});
