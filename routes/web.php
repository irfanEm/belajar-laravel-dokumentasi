<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// basic route laravel
Route::get('/salam', function(){
    return 'Assalamualaikum';
});
