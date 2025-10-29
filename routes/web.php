<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoiceAttachmentsController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\InvoiceDetailsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
Auth::routes(/*['register' => false]*/);



//Route::get('/home', [App\Http\Controllers\AdminController::class, 'index'])->name('home');
Route::resource('sections', SectionController::class);
Route::resource('invoices', InvoiceController::class);
Route::resource('products', ProductController::class);
Route::get('section/{id}', [InvoiceController::class, 'getproducts']);
Route::post('invoice-pay', [InvoiceController::class, 'pay'])->name('invoices.pay');
Route::get('InvoicesDetails/{invoiceDetails}', [InvoiceDetailsController::class, 'edit']);
Route::get('view_file/{invoice_number}/{file_name}', [InvoiceDetailsController::class, 'openFile']);
Route::get('download/{invoice_number}/{file_name}', [InvoiceDetailsController::class, 'downLoadFile']);
Route::resource('InvoiceAttachments', InvoiceAttachmentsController::class);
Route::get('/edit_invoice/{id}', [InvoiceController::class, 'edit']);
Route::get('/{page}', [AdminController::class, 'index']);

Route::get('/', function () {
    return view('auth.login');
});
