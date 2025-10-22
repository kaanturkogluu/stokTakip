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
Route::get('/admin/phones', [AdminController::class, 'phones'])->name('admin.phones.index');
Route::get('/admin/phones/create', [AdminController::class, 'create'])->name('admin.phones.create');
Route::post('/admin/phones', [AdminController::class, 'store'])->name('admin.phones.store');
Route::get('/admin/phones/models-by-brand', [AdminController::class, 'getPhoneModelsByBrand'])->name('admin.phones.models-by-brand');
Route::get('/admin/phones/colors-by-brand', [AdminController::class, 'getColorsByBrand'])->name('admin.phones.colors-by-brand');
Route::get('/admin/phones/{phone}', [AdminController::class, 'show'])->name('admin.phones.show');
Route::get('/admin/phones/{phone}/edit', [AdminController::class, 'edit'])->name('admin.phones.edit');
Route::put('/admin/phones/{phone}', [AdminController::class, 'update'])->name('admin.phones.update');
Route::delete('/admin/phones/{phone}', [AdminController::class, 'destroy'])->name('admin.phones.destroy');

// Admin Data Routes
Route::get('/admin/data', [AdminController::class, 'dataIndex'])->name('admin.data.index');
Route::get('/admin/data/brands', [AdminController::class, 'brands'])->name('admin.data.brands');
Route::get('/admin/data/phone-models', [AdminController::class, 'phoneModels'])->name('admin.data.phone-models');
Route::get('/admin/data/phone-models/create', [AdminController::class, 'createPhoneModel'])->name('admin.data.phone-models.create');
Route::post('/admin/data/phone-models', [AdminController::class, 'storePhoneModel'])->name('admin.data.phone-models.store');
Route::get('/admin/data/phone-models/{phoneModel}/edit', [AdminController::class, 'editPhoneModel'])->name('admin.data.phone-models.edit');
Route::put('/admin/data/phone-models/{phoneModel}', [AdminController::class, 'updatePhoneModel'])->name('admin.data.phone-models.update');
Route::get('/admin/data/colors', [AdminController::class, 'colors'])->name('admin.data.colors');
Route::get('/admin/data/storages', [AdminController::class, 'storages'])->name('admin.data.storages');
Route::get('/admin/data/rams', [AdminController::class, 'rams'])->name('admin.data.rams');
Route::get('/admin/data/screens', [AdminController::class, 'screens'])->name('admin.data.screens');
Route::get('/admin/data/cameras', [AdminController::class, 'cameras'])->name('admin.data.cameras');
Route::get('/admin/data/batteries', [AdminController::class, 'batteries'])->name('admin.data.batteries');

// Admin Data Create Routes
Route::get('/admin/data/brands/create', [AdminController::class, 'createBrand'])->name('admin.data.brands.create');
Route::post('/admin/data/brands', [AdminController::class, 'storeBrand'])->name('admin.data.brands.store');
Route::get('/admin/data/brands/{brand}/edit', [AdminController::class, 'editBrand'])->name('admin.data.brands.edit');
Route::put('/admin/data/brands/{brand}', [AdminController::class, 'updateBrand'])->name('admin.data.brands.update');
Route::get('/admin/data/colors/create', [AdminController::class, 'createColor'])->name('admin.data.colors.create');
Route::post('/admin/data/colors', [AdminController::class, 'storeColor'])->name('admin.data.colors.store');
Route::get('/admin/data/colors/{color}/edit', [AdminController::class, 'editColor'])->name('admin.data.colors.edit');
Route::put('/admin/data/colors/{color}', [AdminController::class, 'updateColor'])->name('admin.data.colors.update');
Route::get('/admin/data/storages/create', [AdminController::class, 'createStorage'])->name('admin.data.storages.create');
Route::post('/admin/data/storages', [AdminController::class, 'storeStorage'])->name('admin.data.storages.store');
Route::get('/admin/data/storages/{storage}/edit', [AdminController::class, 'editStorage'])->name('admin.data.storages.edit');
Route::put('/admin/data/storages/{storage}', [AdminController::class, 'updateStorage'])->name('admin.data.storages.update');
Route::get('/admin/data/rams/create', [AdminController::class, 'createRam'])->name('admin.data.rams.create');
Route::post('/admin/data/rams', [AdminController::class, 'storeRam'])->name('admin.data.rams.store');
Route::get('/admin/data/rams/{ram}/edit', [AdminController::class, 'editRam'])->name('admin.data.rams.edit');
Route::put('/admin/data/rams/{ram}', [AdminController::class, 'updateRam'])->name('admin.data.rams.update');
Route::get('/admin/data/screens/create', [AdminController::class, 'createScreen'])->name('admin.data.screens.create');
Route::post('/admin/data/screens', [AdminController::class, 'storeScreen'])->name('admin.data.screens.store');
Route::get('/admin/data/screens/{screen}/edit', [AdminController::class, 'editScreen'])->name('admin.data.screens.edit');
Route::put('/admin/data/screens/{screen}', [AdminController::class, 'updateScreen'])->name('admin.data.screens.update');
Route::get('/admin/data/cameras/create', [AdminController::class, 'createCamera'])->name('admin.data.cameras.create');
Route::post('/admin/data/cameras', [AdminController::class, 'storeCamera'])->name('admin.data.cameras.store');
Route::get('/admin/data/cameras/{camera}/edit', [AdminController::class, 'editCamera'])->name('admin.data.cameras.edit');
Route::put('/admin/data/cameras/{camera}', [AdminController::class, 'updateCamera'])->name('admin.data.cameras.update');
Route::get('/admin/data/batteries/create', [AdminController::class, 'createBattery'])->name('admin.data.batteries.create');
Route::post('/admin/data/batteries', [AdminController::class, 'storeBattery'])->name('admin.data.batteries.store');
