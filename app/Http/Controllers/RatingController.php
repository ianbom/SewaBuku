<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Langganan;
use App\Models\Order;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function showRating($id){
        $order = Order::findOrFail($id);
        $rating = Rating::where('id_order', $order->id_order)->first();
        return response()->json($rating);
    }

    public function storeRating(Request $request, $id)
    {
        $request->validate([

            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string',
        ]);


        $user = Auth::user();
        $buku = Buku::findOrFail($id);
        $checkLanggananAktif = Langganan::where('id', $user->id)
            ->where('status_langganan', true)
            ->exists();
        $checkRating = Rating::where('id', $user->id)->where('id_buku', $buku->id_buku)->exists();


        try {


            if ($checkLanggananAktif && !$checkRating) {
                Rating::create([
                    'id_buku' => $buku->id_buku,
                    'id' => $user->id,
                    'rating' => $request->rating,
                    'komentar' => $request->komentar,
                ]);

                return redirect()->back()->with('success', 'Rating berhasil disimpan.');
            } else {
                return  redirect()->back();
            }
        } catch (\Throwable $th) {
            return  redirect()->back();
        }
    }

}
