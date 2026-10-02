<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServeuseController;
use App\Http\Controllers\BoissonController;
use App\Http\Controllers\DistributionController;
use App\Http\Controllers\PaiementController;

// Routes publiques
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Routes protégées
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Routes pour les serveuses
    Route::prefix('serveuses')->name('serveuses.')->group(function () {
        Route::get('/', [ServeuseController::class, 'index'])->name('index');
        Route::get('/create', [ServeuseController::class, 'create'])->name('create');
        Route::post('/', [ServeuseController::class, 'store'])->name('store');
        Route::get('/{serveuse}', [ServeuseController::class, 'show'])->name('show');
        Route::get('/{serveuse}/edit', [ServeuseController::class, 'edit'])->name('edit');
        Route::put('/{serveuse}', [ServeuseController::class, 'update'])->name('update');
        Route::delete('/{serveuse}', [ServeuseController::class, 'destroy'])->name('destroy');
    });

    // Routes pour les boissons
    Route::prefix('boissons')->name('boissons.')->group(function () {
        Route::get('/', [BoissonController::class, 'index'])->name('index');
        Route::get('/create', [BoissonController::class, 'create'])->name('create');
        Route::post('/', [BoissonController::class, 'store'])->name('store');
        Route::get('/{boisson}/edit', [BoissonController::class, 'edit'])->name('edit');
        Route::put('/{boisson}', [BoissonController::class, 'update'])->name('update');
        Route::delete('/{boisson}', [BoissonController::class, 'destroy'])->name('destroy');
    });

    // Routes pour les distributions
    Route::prefix('distributions')->name('distributions.')->group(function () {
        Route::get('/create', [DistributionController::class, 'create'])->name('create');
        Route::post('/', [DistributionController::class, 'store'])->name('store');
    });

    // Routes pour les paiements
    Route::prefix('paiements')->name('paiements.')->group(function () {
        Route::get('/', [PaiementController::class, 'index'])->name('index');
        Route::get('/create', [PaiementController::class, 'create'])->name('create');
        Route::post('/', [PaiementController::class, 'store'])->name('store');
        Route::get('/export/excel', [PaiementController::class, 'exportExcel'])->name('export.excel');
        Route::get('/export/pdf', [PaiementController::class, 'exportPdf'])->name('export.pdf');
    });

    // Routes API pour la recherche
    Route::prefix('api')->name('api.')->group(function () {
        Route::get('/serveuses/search', [ServeuseController::class, 'search'])->name('serveuses.search');
        Route::get('/boissons/search', [BoissonController::class, 'search'])->name('boissons.search');
    });
});
