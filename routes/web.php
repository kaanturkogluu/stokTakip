<?php

use App\Http\Controllers\PhoneController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PhoneController::class, 'index'])->name('home');
Route::get('/telefonlar', [PhoneController::class, 'phones'])->name('phones.index');
Route::get('/telefon/{phone}', [PhoneController::class, 'show'])->name('phones.show');
Route::get('/iletisim', [PhoneController::class, 'contact'])->name('contact');

// Legal Pages Routes
Route::get('/gizlilik-politikasi', function () {
    return view('privacy-policy');
})->name('privacy-policy');

Route::get('/kullanim-sartlari', function () {
    return view('terms-of-use');
})->name('terms-of-use');

Route::get('/cerez-politikasi', function () {
    return view('cookie-policy');
})->name('cookie-policy');

// Admin Authentication (Public)
Route::get('/giris', [AdminController::class, 'login'])->name('admin.login');
Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/login', [AdminController::class, 'authenticate'])->name('admin.authenticate');

// Protected Admin Routes
Route::middleware(['admin.auth'])->group(function () {
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Phone / Device Stock Routes
    Route::get('/admin/phones', [AdminController::class, 'phones'])->name('admin.phones.index');
    Route::get('/admin/phones/create', [AdminController::class, 'create'])->name('admin.phones.create')->middleware('admin.perm:phones.create');
    Route::post('/admin/phones', [AdminController::class, 'store'])->name('admin.phones.store')->middleware('admin.perm:phones.create');
    Route::get('/admin/phones/models-by-brand', [AdminController::class, 'getPhoneModelsByBrand'])->name('admin.phones.models-by-brand');
    Route::get('/admin/phones/colors-by-brand', [AdminController::class, 'getColorsByBrand'])->name('admin.phones.colors-by-brand');
    Route::get('/admin/phones/search-by-serial', [AdminController::class, 'searchPhoneBySerial'])->name('admin.phones.search-by-serial');
    Route::get('/admin/phones/{phone}', [AdminController::class, 'show'])->name('admin.phones.show');
    Route::get('/admin/phones/{phone}/edit', [AdminController::class, 'edit'])->name('admin.phones.edit')->middleware('admin.perm:phones.update');
    Route::put('/admin/phones/{phone}', [AdminController::class, 'update'])->name('admin.phones.update')->middleware('admin.perm:phones.update');
    Route::delete('/admin/phones/{phone}', [AdminController::class, 'destroy'])->name('admin.phones.destroy')->middleware('admin.perm:phones.delete');

    // Sales & Repurchase Routes
    Route::get('/admin/sales', [AdminController::class, 'sales'])->name('admin.sales.index');
    Route::post('/admin/phones/sell', [AdminController::class, 'sellPhone'])->name('admin.phones.sell')->middleware('admin.perm:sales.create');
    Route::post('/admin/phones/repurchase', [AdminController::class, 'repurchasePhone'])->name('admin.phones.repurchase')->middleware('admin.perm:sales.create');
    Route::delete('/admin/sales/{saleId}', [AdminController::class, 'deleteSale'])->name('admin.sales.delete')->middleware('admin.perm:sales.create');

    // Master Data Routes (Brands, Models, Colors, Storages)
    Route::middleware(['admin.perm:data.manage'])->group(function () {
        Route::get('/admin/data', [AdminController::class, 'dataIndex'])->name('admin.data.index');
        Route::get('/admin/data/brands', [AdminController::class, 'brands'])->name('admin.data.brands');
        Route::get('/admin/data/brands/create', [AdminController::class, 'createBrand'])->name('admin.data.brands.create');
        Route::post('/admin/data/brands', [AdminController::class, 'storeBrand'])->name('admin.data.brands.store');
        Route::get('/admin/data/brands/{brand}/edit', [AdminController::class, 'editBrand'])->name('admin.data.brands.edit');
        Route::put('/admin/data/brands/{brand}', [AdminController::class, 'updateBrand'])->name('admin.data.brands.update');
        Route::delete('/admin/data/brands/{brand}', [AdminController::class, 'destroyBrand'])->name('admin.data.brands.destroy');

        Route::get('/admin/data/phone-models', [AdminController::class, 'phoneModels'])->name('admin.data.phone-models');
        Route::get('/admin/data/phone-models/create', [AdminController::class, 'createPhoneModel'])->name('admin.data.phone-models.create');
        Route::post('/admin/data/phone-models', [AdminController::class, 'storePhoneModel'])->name('admin.data.phone-models.store');
        Route::get('/admin/data/phone-models/{phoneModel}/edit', [AdminController::class, 'editPhoneModel'])->name('admin.data.phone-models.edit');
        Route::put('/admin/data/phone-models/{phoneModel}', [AdminController::class, 'updatePhoneModel'])->name('admin.data.phone-models.update');

        Route::get('/admin/data/colors', [AdminController::class, 'colors'])->name('admin.data.colors');
        Route::get('/admin/data/colors/create', [AdminController::class, 'createColor'])->name('admin.data.colors.create');
        Route::post('/admin/data/colors', [AdminController::class, 'storeColor'])->name('admin.data.colors.store');
        Route::get('/admin/data/colors/{color}/edit', [AdminController::class, 'editColor'])->name('admin.data.colors.edit');
        Route::put('/admin/data/colors/{color}', [AdminController::class, 'updateColor'])->name('admin.data.colors.update');

        Route::get('/admin/data/storages', [AdminController::class, 'storages'])->name('admin.data.storages');
        Route::get('/admin/data/storages/create', [AdminController::class, 'createStorage'])->name('admin.data.storages.create');
        Route::post('/admin/data/storages', [AdminController::class, 'storeStorage'])->name('admin.data.storages.store');
        Route::get('/admin/data/storages/{storage}/edit', [AdminController::class, 'editStorage'])->name('admin.data.storages.edit');
        Route::put('/admin/data/storages/{storage}', [AdminController::class, 'updateStorage'])->name('admin.data.storages.update');
    });

    // Store Settings Routes
    Route::middleware(['admin.perm:settings.manage'])->group(function () {
        Route::get('/admin/settings', [AdminController::class, 'settings'])->name('admin.settings');
        Route::post('/admin/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');
        Route::post('/admin/settings/upload-logo', [AdminController::class, 'uploadLogo'])->name('admin.settings.upload-logo');
        Route::post('/admin/settings/upload-favicon', [AdminController::class, 'uploadFavicon'])->name('admin.settings.upload-favicon');
    });

    // Financial Reports
    Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports')->middleware('admin.perm:reports.view');

    // Customer Management Routes
    Route::get('/admin/customers', [CustomerController::class, 'index'])->name('admin.customers.index');
    Route::get('/admin/customers/create', [CustomerController::class, 'create'])->name('admin.customers.create')->middleware('admin.perm:customers.create');
    Route::post('/admin/customers', [CustomerController::class, 'store'])->name('admin.customers.store')->middleware('admin.perm:customers.create');
    Route::get('/admin/customers/{customer}', [CustomerController::class, 'show'])->name('admin.customers.show');
    Route::get('/admin/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('admin.customers.edit')->middleware('admin.perm:customers.update');
    Route::put('/admin/customers/{customer}', [CustomerController::class, 'update'])->name('admin.customers.update')->middleware('admin.perm:customers.update');
    Route::delete('/admin/customers/{customer}', [CustomerController::class, 'destroy'])->name('admin.customers.destroy')->middleware('admin.perm:customers.delete');

    // Customer Payments & Debts
    Route::get('/admin/customers/{customer}/payment', [CustomerController::class, 'payment'])->name('admin.customers.payment');
    Route::get('/admin/customers/{customer}/debts', [CustomerController::class, 'getDebts'])->name('admin.customers.debts');
    Route::post('/admin/customers/{customer}/payment', [CustomerController::class, 'processPayment'])->name('admin.customers.payment.process')->middleware('admin.perm:payments.process');

    // Admin User Management Routes
    Route::middleware(['admin.perm:admins.manage'])->group(function () {
        Route::get('/admin/admins', [AdminController::class, 'admins'])->name('admin.admins.index');
        Route::get('/admin/admins/create', [AdminController::class, 'createAdmin'])->name('admin.admins.create');
        Route::post('/admin/admins', [AdminController::class, 'storeAdmin'])->name('admin.admins.store');
        Route::get('/admin/admins/{admin}/edit', [AdminController::class, 'editAdmin'])->name('admin.admins.edit');
        Route::put('/admin/admins/{admin}', [AdminController::class, 'updateAdmin'])->name('admin.admins.update');
    });
    Route::delete('/admin/admins/{admin}', [AdminController::class, 'destroyAdmin'])->name('admin.admins.destroy')->middleware('admin.perm:admins.delete');

    // Audit Logs
    Route::get('/admin/audit-logs', [AdminController::class, 'auditLogs'])->name('admin.audit-logs.index')->middleware('admin.perm:audit.view');
});
