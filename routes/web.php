<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminMainController;

Route::get('/', function () {
    return view('welcome');
});

// admin routes
Route::middleware(['auth', 'verified', 'rolemanager:admin'])->group(function ()
{

    Route::controller(AdminMainController::class)->group(function ()
    {
        Route::prefix('admin')->group(function ()
        {
            Route::get('/dashboard', 'index')->name('admin');

        }
        );        
    });

});

// Route::get('/admin/dashboard', function () {return view('admin'); })->middleware(['auth', 'verified', 'rolemanager:admin'])->name('admin');
Route::get('/vendor/dashboard', function () {return view('vendor'); })->middleware(['auth', 'verified', 'rolemanager:vemdor'])->name('vendor');
Route::get('/dashboard', function () {return view('dashboard'); })->middleware(['auth', 'verified', 'rolemanager:customer'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
