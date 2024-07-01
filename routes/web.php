<?php

use App\Http\Controllers\Auth\ProviderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth', 'verified')->group(function () {
    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::get('enkripsi', [HomeController::class, 'enkripsi'])->name('enkripsi');
    Route::post('encrypt', [HomeController::class, 'encrypt'])->name('encrypt');
    Route::get('deskripsi', [HomeController::class, 'deskripsi'])->name('deskripsi');
    Route::post('decrypt', [HomeController::class, 'decrypt'])->name('decrypt');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

// Sign in with social account
Route::get('/auth/{provider}/redirect', [ProviderController::class, 'redirect']);
Route::get('/auth/{provider}/callback', [ProviderController::class, 'callback']);
