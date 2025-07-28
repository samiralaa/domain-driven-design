<?php



use Illuminate\Support\Facades\Route;
use App\Domains\User\Http\Controllers\Api\UserController;
use App\Http\Controllers\CustomCacheManagerController;

Route::prefix('user')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('user.index');
    // You can add more user-related routes here.
});

Route::prefix('cache')->group(function () {
    Route::get('/', [CustomCacheManagerController::class, 'index'])->name('cache.index');
});
    
