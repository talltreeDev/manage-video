<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\VideoUpload;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Dashboard route (requires login & verification)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated routes
Route::middleware('auth')->group(function () {

    // Profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 👇 New: Video Upload page (protected)
    Route::get('/upload', VideoUpload::class)->name('upload');
});

// Admin-only routes
Route::middleware(['auth', 'can:admin'])->prefix('admin')->group(function () {
    // Role update (POST form submission)
    Route::post('/promote-user/{user}', [AdminController::class, 'promoteUser'])->name('admin.promote');

    // Admin user management page
    Route::get('/users', [AdminController::class, 'listUsers'])->name('admin.users');
});

require __DIR__.'/auth.php';
