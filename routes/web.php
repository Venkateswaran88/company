<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [CompanyController::class, 'dashboard']);
    Route::get('/dashboard', [CompanyController::class, 'dashboard'])->name('dashboard');
 
    Route::resource('company', CompanyController::class);
    Route::resource('product', ProductController::class);
});

require __DIR__.'/auth.php';
