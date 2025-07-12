<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// お問い合わせフォーム画面
Route::get('/', [ContactController::class, 'create'])->name('contacts.create');
Route::post('/confirm', [ContactController::class, 'confirm']);
Route::get('/contacts/back', [ContactController::class, 'back'])->name('contacts.back');
Route::post('/contacts', [ContactController::class, 'store']);

// 認証が必要な管理画面
Route::middleware('auth')->group(function () {
    Route::get('/admin', [ContactController::class, 'index']);
    Route::delete('/delete', [ContactController::class, 'destroy']);
    Route::get('/search', [ContactController::class, 'search']);
    Route::get('/export', [ContactController::class, 'export'])->name('contacts.export');
});

// ログアウト先
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
