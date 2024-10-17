<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function indexFavorite(){
        $userId = Auth::id();
        $favorite = Favorite::where('id', $userId)->get();
        return view('sewa_buku.user.favorite.index_favorite', ['favorite' => $favorite]);
    }

    public function storeFavorite(Request $request, $id)
    {
        $userId = Auth::id();
        $buku = Buku::findOrFail($id);

        $existingFavorite = Favorite::where('id', $userId)
                                    ->where('id_buku', $id)
                                    ->first();

        if ($existingFavorite) {
            return redirect()->back()->with('error', 'Buku ini sudah ada di daftar favorit Anda.');
        }
        Favorite::create([
            'id' => $userId,
            'id_buku' => $buku->id_buku,
        ]);

        return redirect()->back()->with('success', 'Buku berhasil ditambahkan ke daftar favorit!');
    }

    public function deleteFavortie($id){
        $favorite = Favorite::findOrFail($id);
        $favorite->delete();

        return redirect()->back()->with('success', 'Buku berhasil dihapus dari daftar favorit!');
    }
}
