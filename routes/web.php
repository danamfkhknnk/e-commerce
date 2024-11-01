<?php

use App\Http\Controllers\Admin\Admincontroller;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified','rolemanager:customer'])->name('dashboard');


//admin route
Route::middleware(['auth', 'verified','rolemanager:admin'])->group(function () {
    Route::controller(Admincontroller::class)->group(function () {
        Route::prefix('admin')->group(function () {
            Route::get('/dashboard','index')->name('admin');
            Route::get('/settings','setting')->name('admin.setting');
            Route::get('/manage/users','manage_user')->name('admin.manage.user');
            Route::get('/manage/stores','manage_stores')->name('admin.manage.stores');
            Route::get('/cart/histori','cart_histori')->name('admin.manage.stores');
        });
    });
});



Route::get('/vendor/dashboard', function () {
    return view('vendor');
})->middleware(['auth', 'verified','rolemanager:vendor'])->name('vendor');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';