<?php

namespace App\Http\View\Composers;

use App\Models\Buku;
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
        // Ambil ID dari view data (jika dikirim oleh controller ke view)
        $idBuku = $view->getData()['idBuku'] ?? null;

        // Jika ID tersedia, ambil buku dari database
        $buku = $idBuku ? Buku::findOrFail($idBuku) : null;

        // Bagikan data ke view
        $view->with('buku', $buku);
    }
}
