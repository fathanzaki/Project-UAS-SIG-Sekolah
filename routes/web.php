<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SekolahWebController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/master', function () {
    return view('master');
})->middleware(['auth', 'verified'])->name('master');

Route::put('/sekolah/{sekolah}', [SekolahWebController::class, 'update'])->name('sekolah.update');




Route::put('/sekolah/{id}', [SekolahWebController::class, 'update'])->name('sekolah.update');
Route::post('/sekolah', [SekolahWebController::class, 'store'])->name('sekolah.store');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
