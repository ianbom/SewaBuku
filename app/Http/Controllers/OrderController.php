<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Langganan;
use App\Models\Order;
use App\Models\PaketLangganan;
use App\Models\Payment;
use App\Models\Rating;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function indexOrder(){
        $userId = Auth::id();
        $order = Order::where('id', $userId)->paginate(5);
        return view('sewa_buku.user.order.index_order', ['order' => $order]);
    }

    public function showOrder($id){
        $order = Order::findOrFail($id);

        //return response()->json(['order' => $order]);
        return view('sewa_buku.user.order.order_detail', ['order'=> $order]);
    }

    public function storeOrder($id){
        try {
            $paketLangganan = PaketLangganan::findOrFail($id);
            $userId = Auth::id();
            $order = Order::create([
                'id' => $userId,
                'id_paket_langganan' => $paketLangganan->id_paket_langganan,
                'total_bayar' => $paketLangganan->harga,
                'nama_paket' => $paketLangganan->nama_paket,
                'masa_waktu' => $paketLangganan->masa_waktu,
                'status_order' => 'Proses'
            ]);
            return redirect()->route('user.order.show', $order->id_order);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public function storePayment($id){ // Belum ada payment gateway
        try {
            $user = Auth::user();
            $checkLangganan = Langganan::where('id', $user->id)->first();
            $checkLanggananAktif = Langganan::where('id', $user->id)->where('status_langganan', true)->first();
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

                if ($checkLanggananAktif) {
                  $checkLanggananAktif->update([
                        'id_paket_langganan' => $order->id_paket_langganan,
                        'status_langganan' => true,
                        'mulai_langganan' => now(),
                        'akhir_langganan' => Carbon::parse($checkLanggananAktif->akhir_langganan)->addDays($order->masa_waktu)
                    ]);

                } if ($checkLangganan) {
                    $checkLangganan->update([
                        'id_paket_langganan' => $order->id_paket_langganan,
                        'status_langganan' => true,
                        'mulai_langganan' => now(),
                        'akhir_langganan' => Carbon::parse($checkLangganan->akhir_langganan)->addDays($order->masa_waktu)
                    ]);
                }
                else {
                    Langganan::create([
                        'id' => $order->id,
                        'id_paket_langganan' => $order->id_paket_langganan,
                        'status_langganan' => true,
                        'mulai_langganan' => now(),
                        'akhir_langganan' => now()->addDays($order->masa_waktu),
                    ]);

                }


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

    public function showOrderAdmin($id){
        $order = Order::findOrFail($id);
        return view('sewa_buku.admin.order.show_order', ['order' => $order]);
    }

    public function deleteOrderAdmin($id){
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->back()->with('success', 'Order deleted successfully');
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


    public function searchOrder(Request $request)
    {
        $userId = Auth::id();
        $search = $request->input('search');

        $order = Order::where('id', $userId)  // Assuming the column is user_id, not id
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($q) use ($search) {
                    $q->whereHas('paketLangganan', function ($subQuery) use ($search) {
                        $subQuery->where('nama_paket', 'like', "%{$search}%");
                    })
                    ->orWhere('total_bayar', 'like', "%{$search}%")
                    ->orWhere('created_at', 'like', "%{$search}%")
                    ->orWhere('id_order', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(5)
            ->appends(['search' => $search]);
            
        if ($request->ajax()) {
            return response()->json([
                'html' => view('sewa_buku.user.order.table_order', compact('order'))->render()
            ]);
        }

        return view('sewa_buku.user.order.index_order', compact('order'));
    }

}
