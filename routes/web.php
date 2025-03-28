<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\TwoFactorSetupController;
use App\Http\Controllers\TwoFactorVerifyController;

/*************  ✨ Codeium Command 🌟  *************/
Route::get('/', function () {
    return view('welcome');
});
/******  bd06a2aa-efe4-480e-be7c-d7282f31b0b6  *******/

Route::get('/', function () {
    return redirect('/admin/login');
});

// // web.php
// Route::get('/2fa/verify', [TwoFactorController::class, 'showVerifyForm'])->name('2fa.verify');
// Route::post('/2fa/verify', [TwoFactorController::class, 'verify']);

Route::get('/2fa/setup', [TwoFactorSetupController::class, 'show'])->name('2fa.setup');
Route::post('/2fa/setup/verify', [TwoFactorSetupController::class, 'verify'])->name('2fa.setup.verify');

Route::get('/2fa/verify', [TwoFactorVerifyController::class, 'form'])->name('2fa.verify');
Route::post('/2fa/verify', [TwoFactorVerifyController::class, 'check']);




