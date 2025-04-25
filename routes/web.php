<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MasterItemsController;
use App\Http\Controllers\MasterCategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DetailTransactionController;
use App\Models\Transaction;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    $transactions = Transaction::latest()->take(5)->get();
    return view('dashboard', compact('transactions'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('master-categories', MasterCategoryController::class);

    Route::resource('master-items', MasterItemsController::class);

    Route::resource('transactions', TransactionController::class);

    Route::resource('detail-transactions', DetailTransactionController::class);

    // Cart routes
    Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
    Route::get('/cart/clear', [App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');
    // Cart routes
    Route::post('/cart/decrease/{id}', [App\Http\Controllers\CartController::class, 'decrease'])->name('cart.decrease');
    Route::post('/cart/increase/{id}', [App\Http\Controllers\CartController::class, 'increase'])->name('cart.increase');
});

require __DIR__.'/auth.php';
