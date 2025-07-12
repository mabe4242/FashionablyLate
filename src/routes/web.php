<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

Route::get('/', [ContactController::class, 'create']);
Route::post('/contacts/confirm', [ContactController::class, 'confirm']);

