<?php

use App\Http\Controllers\PhoneController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PhoneController::class, 'index'])->name('home');
Route::get('/telefonlar', [PhoneController::class, 'phones'])->name('phones.index');
Route::get('/telefon/{phone}', [PhoneController::class, 'show'])->name('phones.show');
Route::get('/iletisim', [PhoneController::class, 'contact'])->name('contact');

// Admin Routes
Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/login', [AdminController::class, 'authenticate'])->name('admin.authenticate');
Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');

// Admin Phone Routes
Route::get('/admin/phones/create', [AdminController::class, 'create'])->name('admin.phones.create');
Route::post('/admin/phones', [AdminController::class, 'store'])->name('admin.phones.store');
