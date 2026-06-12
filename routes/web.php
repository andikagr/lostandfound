<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LostItemController;
use App\Http\Controllers\FoundItemController;
use App\Http\Controllers\FormFoundItemController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;

Route::get('/', function () {
    return view('landing');
});

Route::get('/fix-images', function () {
    $foundUpdated = \App\Models\FoundItem::where('image', 'not like', '%supabase.co%')
        ->whereNotNull('image')
        ->update(['image' => null]);
    $lostUpdated = \App\Models\LostItem::where('image', 'not like', '%supabase.co%')
        ->whereNotNull('image')
        ->update(['image' => null]);
    $claimsUpdated = \App\Models\Claim::where('bukti', 'not like', '%supabase.co%')
        ->where('bukti', '!=', '')
        ->update(['bukti' => '']);
    return "Fix complete! FoundItems updated: $foundUpdated, LostItems updated: $lostUpdated, Claims updated: $claimsUpdated. <a href='/dashboard'>Go to dashboard</a>";
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

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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

    // Notifications
    Route::get('/notifications/{id}/read', [NotificationController::class, 'read'])->name('notifications.read');
    Route::get('/notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.read-all');
});
