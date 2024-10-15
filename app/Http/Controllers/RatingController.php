<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Order;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function showRating($id){
        $order = Order::findOrFail($id);
        $rating = Rating::where('id_order', $order->id_order)->first();
        return response()->json($rating);
    }

    public function storeRating(Request $request, $id){
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string',
        ]);

        try {
            $order = Order::findOrFail($id);

            if ($order->status_order == 'Dibayar') {
                Rating::create([
                    'id_order' => $order->id_order,
                    'rating' => $request->rating,
                    'komentar'  => $request->komentar,
                ]);

            return redirect()->back();
            }
        } catch (\Throwable $th) {
            return response()->json(["err" => $th]);
        }

    }
}
