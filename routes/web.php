<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
Auth::routes(/*['register' => false]*/);



//Route::get('/home', [App\Http\Controllers\AdminController::class, 'index'])->name('home');
Route::get('/{page}', [App\Http\Controllers\AdminController::class, 'index']);
Route::get('/', function () {
    return view('auth.login');
});
