<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SectionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
Auth::routes(/*['register' => false]*/);



//Route::get('/home', [App\Http\Controllers\AdminController::class, 'index'])->name('home');
Route::resource('sections', SectionController::class);
Route::resource('invoices', InvoiceController::class);
Route::get('/{page}', [App\Http\Controllers\AdminController::class, 'index']);
Route::get('/', function () {
    return view('auth.login');
});
