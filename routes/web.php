<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\Admin\DashboardController;

// Halaman Publik
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/wisata', [PlaceController::class, 'wisataIndex'])->name('wisata.index');
Route::get('/kuliner', [PlaceController::class, 'kulinerIndex'])->name('kuliner.index');
Route::get('/tempat/{slug}', [PlaceController::class, 'show'])->name('places.show');

// Dashboard rekomendasi (publik, tanpa login) -> resources/views/admin/dashboard.blade.php
Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->name('dashboard');

// Alias lama: /demo diarahkan ke /dashboard
Route::redirect('/demo', '/dashboard')->name('demo');

// Login (tidak error jika view auth.login belum dibuat)
Route::get('/login', function () {
    return View::exists('auth.login')
        ? view('auth.login')
        : redirect()->route('dashboard');
})->name('login');

// Panel Admin (tetap dilindungi autentikasi)
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});