<?php

use App\Http\Controllers\PhoneController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PhoneController::class, 'index'])->name('home');
Route::get('/telefonlar', [PhoneController::class, 'phones'])->name('phones.index');
Route::get('/telefon/{phone}', [PhoneController::class, 'show'])->name('phones.show');
Route::get('/iletisim', [PhoneController::class, 'contact'])->name('contact');
