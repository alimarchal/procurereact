<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Api\V1\BusinessController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/businesses', [BusinessController::class, 'store'])->name('businesses.store');
    Route::get('/businesses', [BusinessController::class, 'index'])->name('businesses.index');

});

Route::middleware('auth')->group(function () {
    Route::get('/quotation', function () {
        return Inertia::render('Quotation');
    })->name('quotation');
});

require __DIR__.'/auth.php';
