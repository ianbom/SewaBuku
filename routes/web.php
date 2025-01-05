<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\LanggananController;
use App\Http\Controllers\OpsiController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaketLanggananController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\SoalController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\IsAdmin;
use App\Models\Langganan;
use App\Models\PaketLangganan;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('user.buku.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['is_admin'])->prefix('admin')->group(function () {
        Route::group(['prefix' => 'buku'], function () {
            Route::get('/index', [BukuController::class, 'index'])->name('admin.buku.index');
            Route::get('/create', [BukuController::class, 'create'])->name('admin.buku.create');
            Route::get('/show/{id}', [BukuController::class, 'show'])->name('admin.buku.show');
            Route::post('/store', [BukuController::class, 'store2'])->name('admin.buku.store');
            Route::get('/edit/{id}', [BukuController::class, 'edit'])->name('admin.buku.edit');
            Route::put('/update/{id}', [BukuController::class, 'updateBuku'])->name('admin.buku.update');
            Route::delete('/delete/cover/{id}', [BukuController::class, 'deleteCover'])->name('admin.buku.deleteCover');
            Route::get('/detail/edit/{id}', [BukuController::class, 'editDetailBuku'])->name('admin.detailBuku.edit');
            Route::put('/detail/update/{id}', [BukuController::class, 'updateDetailBuku'])->name('admin.updateBuku.edit');
            Route::get('/tags/edit{id}', [BukuController::class, 'editTagsBuku'])->name('admin.tagsBuku.edit');
            Route::put('/tags/update{id}', [BukuController::class, 'updateTagsBuku'])->name('admin.tagsBuku.update');
        });
        Route::group(['prefix' => 'order'], function () {
            Route::get('/index', [OrderController::class, 'indexOrderAdmin'])->name('admin.order.index');
            Route::get('/show/{id}', [OrderController::class, 'showOrderAdmin'])->name('admin.order.show');
            Route::delete('/delete/{id}', [OrderController::class, 'deleteOrderAdmin'])->name('admin.order.delete');
        });

        Route::group(['prefix' => 'user'], function () {
            Route::get('/index', [UserController::class, 'indexUserAdmin'])->name('admin.user.index');
        });

        Route::group(['prefix' => 'profile'], function () {
            Route::get('/', [UserController::class, 'profileAdmin'])->name('admin.profile');
            Route::get('/edit', [UserController::class, 'editProfileAdmin'])->name('admin.profile.edit');
            Route::put('/update', [UserController::class, 'updateProfileAdmin'])->name('admin.profile.update');
        });

        Route::group(['prefix' => 'tags'], function () {
            Route::get('/index', [TagsController::class, 'indexTags'])->name('admin.tags.index');
            Route::post('/store', [TagsController::class, 'storetags'])->name('admin.tags.store');
            Route::get('/edit/{id}', [TagsController::class, 'editTags'])->name('admin.tags.edit');
            Route::put('/update/{id}', [TagsController::class, 'updateTags'])->name('admin.tags.update');
        });

        Route::resource('/quiz', QuizController::class)->except('create');
        Route::get('/quiz/create/{id}', [QuizController::class, 'create'])->name('quiz.create');

        Route::resource('/soal', SoalController::class)->except('create');
        Route::get('/soal/create/{id}', [SoalController::class, 'create'])->name('soal.create');

        Route::resource('/opsi', OpsiController::class)->except('create');
        Route::get('/opsi/create/{id}', [OpsiController::class, 'create'])->name('opsi.create');

        Route::resource('/paket-langganan', PaketLanggananController::class);
    });



    Route::group(['prefix' => 'user'], function () {
        Route::group(['prefix' => 'buku'], function () {
            Route::get('/index', [BukuController::class, 'indexBukuUser'])->name('user.buku.index');
            Route::get('/search/judulBuku', [BukuController::class, 'searchJudulBuku'])->name('judulBuku.search');
            Route::get('/show/{id}', [BukuController::class, 'detailBukuUser'])->name('user.buku.show');
            Route::get('/baca/{id}', [LanggananController::class, 'bacaBuku'])->name('user.buku.baca'); // kayae wes ga kepake
            Route::get('/baca/bab/{id}', [LanggananController::class, 'bacaBabBuku'])->name('user.buku.bacaBab');
            Route::get('/quiz/{id}', [QuizController::class, 'kerjakanQuiz'])->name('user.quiz.kerjakan');
            Route::post('/quiz/{id}/submit', [QuizController::class, 'submitQuiz'])->name('user.quiz.submit');
            Route::get('/search', [BukuController::class, 'searchBukuIndex'])->name('user.buku.search');
            Route::get('/search/buku', [BukuController::class, 'searchBuku'])->name('buku.search');
            Route::post('/markFinished/{id}', [LanggananController::class, 'tandaiBabDiselesaikan'])->name('user.mark.finished');
            Route::delete('/deleteMarkFinished/{id}', [LanggananController::class, 'hapusTandaBabDiselesaikan'])->name('user.delete.finished');
            Route::post('/markBookFinished/{id}', [LanggananController::class, 'tandaiBukuDiselesaikan'])->name('user.mark.bookFinished');
            Route::delete('/deleteMarkBookFinished/{id}', [LanggananController::class, 'hapusTandaBukuDiselesaikan'])->name('user.delete.bookFinished');
            Route::get('/collection', [BukuController::class, 'myCollection'])->name('user.myCollection');
            Route::post('/highlight-text', [LanggananController::class, 'highlightText'])->name('user.highlight.text');
        });

        Route::group(['prefix' => 'order'], function () {
            Route::get('/index', [OrderController::class, 'indexOrder'])->name('user.order.index');
            Route::get('/show/{id}', [OrderController::class, 'showOrder'])->name('user.order.show');
            Route::post('/store/{id}', [OrderController::class, 'storeOrder'])->name('user.order.store');
            Route::post('/bayar/{id}', [OrderController::class, 'storePayment'])->name('user.payment.store');
            Route::put('/batal/{id}', [OrderController::class, 'batalkanOrder'])->name('user.order.batal');
            Route::get('/search', [OrderController::class, 'searchOrder'])->name('user.order.search');
        });

        Route::group(['prefix' => 'langganan'], function () {
            Route::get('/index', [LanggananController::class, 'indexUser'])->name('user.langganan.index');
        });

        Route::group(['prefix' => 'rating'], function () {
            Route::post('/store/{id}', [RatingController::class, 'storeRating'])->name('user.rating.store');
        });

        Route::group(['prefix' => 'favorite'], function () {
            Route::get('/index', [FavoriteController::class, 'indexFavorite'])->name('user.favorite.index');
            Route::post('/store/{id}', [FavoriteController::class, 'storeFavorite'])->name('user.favorite.store');
            Route::delete('/delete/{id}', [FavoriteController::class, 'deleteFavorite'])->name('user.favorite.delete');
        });

        Route::group(['prefix' => 'paket-langganan'], function () {
            Route::get('/index', [PaketLanggananController::class, 'indexUser'])->name('user.paketLangganan.index');
        });
    });
});




require __DIR__ . '/auth.php';
