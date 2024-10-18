<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Langganan;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function indexOrder(){
        $userId = Auth::id();
        $order = Order::where('id', $userId)->get();
        return view('sewa_buku.user.order.index_order', ['order' => $order]);
    }

    public function showOrder($id){
        $order = Order::findOrFail($id);
        $rating = Rating::where('id_order', $order->id_order)->first();
        //return response()->json(['order' => $order]);
        return view('sewa_buku.user.order.order_detail', ['order'=> $order, 'rating' => $rating]);
    }

    public function storeOrder($id){
        try {
            $buku = Buku::findOrFail($id);
            $userId = Auth::id();
            $order = Order::create([
                'id' => $userId,
                'id_buku' => $buku->id_buku,
                'total_bayar' => $buku->harga,
                'status_order' => 'Proses'
            ]);
            return redirect()->route('user.order.show', $order->id_order);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public function storePayment($id){ // Belum ada payment gateway
        try {
            $order = Order::findOrFail($id);
            Payment::create([
                'id_order' => $order->id_order,
                'total_bayar' => $order->total_bayar,
                'metode_pembayaran' => 'Gratis wkwk',
                'status_pembayaran' => 'Dibayar'
            ]);

            $order->status_order = 'Dibayar';

            $order->save();

            if ($order->status_order == 'Dibayar') {
                Langganan::create([
                    'id' => $order->id,
                    'id_buku' => $order->id_buku,
                    'status_langganan' => true,
                    'mulai_langganan' => now(),
                    'akhir_langganan' => now()->addMonth(),
                ]);
            }
            return redirect()->back();
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public function indexOrderAdmin(){
        $order = Order::with('user', 'buku')->get();
        //return response()->json(['order' => $order]);
        return view('sewa_buku.admin.order.index_order', ['order' => $order]);
    }

    public function batalkanOrder($id){
        try {
            $order = Order::findOrFail($id);
            $order->status_order = 'Dibatalkan';
            $order->save();
            return redirect()->back()->with('succes', 'Sukses membatalkan pesanan');
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }
}
