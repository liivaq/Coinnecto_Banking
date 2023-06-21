<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CryptoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
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
    return view('index');
})->middleware('guest');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/accounts', [AccountController::class, 'index'])->name('accounts.index');
    Route::get('/accounts/create', [AccountController::class, 'create'])->name('accounts.create');
    Route::post('/accounts/create', [AccountController::class, 'store'])->name('accounts.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/transactions', [TransactionController::class, 'transfer'])->name('transactions.transfer');
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
});

Route::middleware('auth')->group(function () {
    Route::get('/crypto', [CryptoController::class, 'index'])->name('crypto.index');
    Route::get('/crypto/portfolio', [CryptoController::class, 'userCryptos'])->name('crypto.portfolio');
    Route::get('/crypto/search', [CryptoController::class, 'search'])->name('crypto.search');
    Route::get('/crypto/{id}', [CryptoController::class, 'show'])->name('crypto.show');
    Route::post('/crypto/buy', [CryptoController::class, 'buy'])->name('crypto.buy');
    Route::post('/crypto/sell', [CryptoController::class, 'sell'])->name('crypto.sell');
});

require __DIR__.'/auth.php';
