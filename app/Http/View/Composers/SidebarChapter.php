<?php

namespace App\Http\View\Composers;

use App\Models\Buku;
use App\Models\Dibaca;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class SidebarChapter
{
    /**
     * Logika untuk mengikat data ke tampilan.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $userId = Auth::id();

        $idBuku = $view->getData()['idBuku'] ?? null;

        $buku = $idBuku ? Buku::findOrFail($idBuku) : null;

        $dibaca = Dibaca::where('id', $userId)->get();

        $view->with('buku', $buku);
        $view->with('dibaca', $dibaca);
    }
}
