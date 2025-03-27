<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TwoFactorController;

/*************  ✨ Codeium Command 🌟  *************/
Route::get('/', function () {
    return view('welcome');
});
/******  bd06a2aa-efe4-480e-be7c-d7282f31b0b6  *******/

Route::get('/', function () {
    return redirect('/admin/login');
});

// web.php
Route::get('/2fa/verify', [TwoFactorController::class, 'showVerifyForm'])->name('2fa.verify');
Route::post('/2fa/verify', [TwoFactorController::class, 'verify']);




