<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/dashboard/sendMessage', [App\Http\Controllers\DashboardController::class, 'sendMessage'])->name('dashboard.sendMessage');
    Route::get('/dashboard/sendWhatsapp', [App\Http\Controllers\DashboardController::class, 'sendWhatsapp'])->name('dashboard.sendWhatsapp');

    Route::get('/pengguna', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
    Route::post('/pengguna', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');
    Route::get('/pengguna/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
    Route::delete('/pengguna/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('user.destroy');

    Route::get('/pelanggan', [App\Http\Controllers\CustomerController::class, 'index'])->name('customer.index');
    Route::get('/pelanggan/tambah', [App\Http\Controllers\CustomerController::class, 'create'])->name('customer.create');
    Route::post('/pelanggan', [App\Http\Controllers\CustomerController::class, 'store'])->name('customer.store');
    Route::post('/pelanggan/{id}', [App\Http\Controllers\CustomerController::class, 'update'])->name('customer.update');
    Route::get('/pelanggan/{id}', [App\Http\Controllers\CustomerController::class, 'edit'])->name('customer.edit');
    Route::delete('/pelanggan/{id}', [App\Http\Controllers\CustomerController::class, 'destroy'])->name('customer.destroy');
});
