<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

Route::get('/', [ContactController::class, 'create'])->name('contacts.create');
Route::post('/confirm', [ContactController::class, 'confirm']);
Route::get('/contacts/back', [ContactController::class, 'back'])->name('contacts.back');
Route::post('/contacts', [ContactController::class, 'store']);
Route::get('/admin', [ContactController::class, 'index']);
Route::delete('/delete', [ContactController::class, 'destroy']);
