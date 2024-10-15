<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\LanggananController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RatingController;
use App\Models\Langganan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['prefix' => 'admin'], function () {
    Route::group(['prefix' => 'buku'], function () {
        Route::get('/index', [BukuController::class, 'index'])->name('admin.buku.index');
        Route::get('/create', [BukuController::class, 'create'])->name('admin.buku.create');
        Route::get('/show/{id}', [BukuController::class, 'show'])->name('admin.buku.show');
        Route::post('/store', [BukuController::class, 'store'])->name('admin.buku.store');
        Route::get('/edit/{id}', [BukuController::class, 'edit'])->name('admin.buku.edit');
        Route::put('/update/{id}', [BukuController::class, 'updateBuku'])->name('admin.buku.update');
        Route::delete('/delete/cover/{id}', [BukuController::class, 'deleteCover'])->name('admin.buku.deleteCover');
        Route::get('/detail/edit{id}', [BukuController::class, 'editDetailBuku'])->name('admin.detailBuku.edit');
        Route::put('/detail/update/{id}', [BukuController::class, 'updateDetailBuku'])->name('admin.updateBuku.edit');
    });
});

Route::group(['prefix' => 'user'], function () {
    Route::group(['prefix' => 'buku'], function () {
        Route::get('/index', [BukuController::class, 'indexBukuUser'])->name('user.buku.index');
        Route::get('/baca/{id}', [LanggananController::class, 'bacaBuku'])->name('user.buku.baca');
    });

    Route::group(['prefix' => 'order'], function () {
        Route::get('/index', [OrderController::class, 'indexOrder'])->name('user.order.index');
        Route::get('/show/{id}', [OrderController::class, 'showOrder'])->name('user.order.show');
        Route::post('/store/{id}', [OrderController::class,'storeOrder'])->name('user.order.store');
        Route::post('/bayar/{id}', [OrderController::class,'storePayment'])->name('user.payment.store');
    });

    Route::group(['prefix' => 'langganan'], function () {
        Route::get('/index', [LanggananController::class, 'indexUser'])->name('user.langganan.index');

    });

    Route::group(['prefix' => 'rating'], function () {
        Route::post('/store/{id}', [RatingController::class, 'storeRating'])->name('user.rating.store');

    });

});


require __DIR__.'/auth.php';
