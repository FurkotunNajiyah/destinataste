use App\Http\Controllers\HomeController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\Admin\DashboardController;

// Halaman Publik
php
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/wisata', [PlaceController::class, 'wisataIndex'])->name('wisata.index');
Route::get('/kuliner', [PlaceController::class, 'kulinerIndex'])->name('kuliner.index');
Route::get('/tempat/{slug}', [PlaceController::class, 'show'])->name('places.show');

// Panel Admin (Dilindungi middleware autentikasi)
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    // Tambahkan resource controller untuk CRUD tempat, kategori, dll.
});