<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ResumeController;

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
    Route::resource('resume', ResumeController::class);
    Route::post('search-resume', [ResumeController::class, 'searchResume']);
});

require __DIR__.'/auth.php';
