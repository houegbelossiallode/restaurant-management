<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\BoissonController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\ServeuseController;
use App\Http\Controllers\SousmenuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StatistiqueController;
use App\Http\Controllers\DistributionController;
use App\Http\Controllers\RolePermissionController;

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
        Route::get('/dettes', [ServeuseController::class, 'dettes'])->name('dettes');
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
        Route::get('/', [DistributionController::class, 'index'])->name('index');
        Route::get('/export/excel', [DistributionController::class, 'exportExcel'])->name('export.excel');
        Route::get('/export/pdf', [DistributionController::class, 'exportPdf'])->name('export.pdf');
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

    // Routes pour les modules
    Route::prefix('modules')->name('modules.')->group(function () {
        Route::get('/', [ModuleController::class, 'index'])->name('index');
        Route::post('/', [ModuleController::class, 'store'])->name('store');
        Route::put('/{id}', [ModuleController::class, 'update'])->name('update');
        Route::delete('/{module}', [ModuleController::class, 'destroy'])->name('destroy');
    });

    // Routes pour les menus
    Route::prefix('menus')->name('menus.')->group(function () {
        Route::get('/', [MenuController::class, 'index'])->name('index');
        Route::post('/', [MenuController::class, 'store'])->name('store');
        Route::put('/{id}', [MenuController::class, 'update'])->name('update');
        Route::delete('/{menu}', [MenuController::class, 'destroy'])->name('destroy');
    });

    // Routes pour les sous-menus
    Route::prefix('sousmenus')->name('sousmenus.')->group(function () {
        Route::get('/', [SousmenuController::class, 'index'])->name('index');
        Route::post('/', [SousmenuController::class, 'store'])->name('store');
        Route::put('/{id}', [SousmenuController::class, 'update'])->name('update');
        Route::delete('/{sousmenu}', [SousmenuController::class, 'destroy'])->name('destroy');
    });

    // Routes pour les rôles
    Route::prefix('roles')->name('roles.')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('index');
        Route::post('/', [RoleController::class, 'store'])->name('store');
        Route::put('/{id}', [RoleController::class, 'update'])->name('update');
        Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy');
    });

    // Routes pour les permissions de rôles
    Route::prefix('roles/permissions')->name('roles.permissions.')->group(function () {
        Route::get('/', [RolePermissionController::class, 'index'])->name('index');
        Route::put('/{permission}', [RolePermissionController::class, 'update'])->name('update');
    });

    // Routes pour les utilisateurs
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    });

    // Routes pour les statistiques
    Route::prefix('statistiques')->name('statistiques.')->group(function () {
        Route::get('/', [StatistiqueController::class, 'index'])->name('index');
    });
});
