<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LostItemController;
use App\Http\Controllers\FoundItemController;
use App\Http\Controllers\FormFoundItemController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect('/found-items');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'doLogin']);

    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'doRegister']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {

    Route::resource('lost-items', LostItemController::class);
    Route::get('found-items/print', [FoundItemController::class, 'print'])->name('found-items.print');
    Route::resource('found-items', FoundItemController::class)->except(['create', 'store']);

    // Form Found Items (create & store)
    Route::get('/form-found-items/create', [FormFoundItemController::class, 'create'])->name('form-found-items.create');
    Route::post('/form-found-items', [FormFoundItemController::class, 'store'])->name('form-found-items.store');

    Route::get(
        '/claim-items/create/{foundItem}',
        [ClaimController::class, 'create']
    )->name('claim-items.create');

    Route::get(
        '/claim-items/create-for-lost/{lostItem}',
        [ClaimController::class, 'createForLost']
    )->name('claim-items.create-for-lost');

    Route::post(
        '/claim-items',
        [ClaimController::class, 'store']
    )->name('claim-items.store');

    // Edit, Update, Destroy Claim
    Route::get('/claim-items/{claim}/edit', [ClaimController::class, 'edit'])->name('claim-items.edit');
    Route::put('/claim-items/{claim}', [ClaimController::class, 'update'])->name('claim-items.update');
    Route::delete('/claim-items/{claim}', [ClaimController::class, 'destroy'])->name('claim-items.destroy');

    Route::get('/riwayat', [HistoryController::class, 'index'])
        ->name('riwayat.index');
});
