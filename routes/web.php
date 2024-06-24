<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/sales-create' , [SaleController::class, 'create'])->name('sales.create');
    Route::post('/sales' , [SaleController::class, 'store'])->name('sales.store');
    Route::get('/sales' , [SaleController::class, 'index'])->name('sales.index');
    Route::delete('/sales/{id}' , [SaleController::class, 'destroy'])->name('sales.destroy');

    Route::post('/customer', [CustomerController::class, 'store'])->name('customer.store');

    Route::post('/product', [ProductController::class, 'store'])->name('product.store');
});

require __DIR__.'/auth.php';
