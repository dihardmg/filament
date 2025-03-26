<?php

use Illuminate\Support\Facades\Route;

/*************  ✨ Codeium Command 🌟  *************/
Route::get('/', function () {
    return view('welcome');
});
/******  bd06a2aa-efe4-480e-be7c-d7282f31b0b6  *******/

Route::get('/', function () {
    return redirect('/admin/login');
});
