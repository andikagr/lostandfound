<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LostFoundController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/found-items', [LostFoundController::class, 'indexFoundItems']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/lost-items', [LostFoundController::class, 'storeLostItem']);
    Route::get('/lost-items', [LostFoundController::class, 'indexLostItems']);
    Route::get('/lost-items/{id}', [LostFoundController::class, 'showLostItem']);
    Route::put('/lost-items/{id}', [LostFoundController::class, 'updateLostItem']); 
    Route::delete('/lost-items/{id}', [LostFoundController::class, 'deleteLostItem']); 

    Route::post('/found-items', [LostFoundController::class, 'storeFoundItem']);
    Route::put('/found-items/{id}', [LostFoundController::class, 'updateFoundItem']);
    Route::delete('/found-items/{id}', [LostFoundController::class, 'deleteFoundItem']);

    Route::post('/found-items/{id}/claim', [LostFoundController::class, 'claimItem']);

    // Update & Delete Claim (API)
    Route::put('/claim-items/{id}', [LostFoundController::class, 'updateClaim']);
    Route::delete('/claim-items/{id}', [LostFoundController::class, 'deleteClaim']);

    Route::get('/history', [LostFoundController::class, 'history']);
});