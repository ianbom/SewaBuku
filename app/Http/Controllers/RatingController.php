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
        $checkLanggananAktif = Langganan::where('id', $user->id)
            ->where('status_langganan', true)
            ->exists();

        try {
            $buku = Buku::findOrFail($id);

            if ($checkLanggananAktif) {
                Rating::create([
                    'id_buku' => $buku->id_buku,
                    'id' => $user->id,
                    'rating' => $request->rating,
                    'komentar' => $request->komentar,
                ]);

                return redirect()->back()->with('success', 'Rating berhasil disimpan.');

            } else {
                return response()->json(['error', 'Anda perlu memiliki langganan aktif untuk memberikan rating.']);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

}
