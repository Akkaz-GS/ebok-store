<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EbookController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PembeliController;
use App\Http\Controllers\PenjualController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PromoController;

require __DIR__.'/auth.php';

// ─── PUBLIC ───────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/ebook/{slug}', [EbookController::class, 'show'])->name('ebook.show');
Route::get('/kategori/{slug}', [HomeController::class, 'kategori'])->name('home.kategori');

// ─── PEMBELI ──────────────────────────────────────────
Route::middleware(['auth', 'role:pembeli'])
    ->prefix('pembeli')
    ->name('pembeli.')
    ->group(function () {
        Route::get('/dashboard', [PembeliController::class, 'dashboard'])->name('dashboard');
        Route::post('/beli/{ebook}', [OrderController::class, 'store'])->name('order.store');
        Route::get('/riwayat', [OrderController::class, 'index'])->name('order.index');
        Route::post('/order/{order}/bukti', [OrderController::class, 'uploadBukti'])->name('order.bukti');
        Route::get('/unduh/{order}', [DownloadController::class, 'download'])->name('download');
        Route::post('/ulasan/{ebook}', [ReviewController::class, 'store'])->name('review.store');
        Route::get('/library', [PembeliController::class, 'library'])->name('library');
    });

Route::middleware(['auth', 'role:penjual'])
    ->prefix('penjual')
    ->name('penjual.')
    ->group(function () {
        Route::get('/dashboard',  [PenjualController::class, 'dashboard'])->name('dashboard');
        Route::get('/library',    [PenjualController::class, 'library'])->name('library');
        Route::get('/inventory',  [PenjualController::class, 'inventory'])->name('inventory');  // ← TAMBAH
        Route::get('/sales',      [PenjualController::class, 'sales'])->name('sales');
        Route::get('/penjualan',  [PenjualController::class, 'penjualan'])->name('penjualan');
        Route::get('/laporan',    [PenjualController::class, 'laporan'])->name('laporan');
        Route::patch('/order/{order}/status', [PenjualController::class, 'updateStatus'])->name('order.status');
        Route::resource('ebook',  EbookController::class)->except(['show']);
        Route::patch('/ebook/{id}/toggle', [EbookController::class, 'toggle'])->name('ebook.toggle');
        Route::resource('promo',  PromoController::class)->only(['create', 'store', 'destroy']);
    });

// ─── ADMIN ────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::resource('user', UserController::class);
        Route::resource('kategori', CategoryController::class);
        Route::get('/laporan', [AdminController::class, 'laporan'])->name('laporan');
    });