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
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{
    public function __construct()
    {
        // Set Midtrans configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function indexOrder()
    {
        $userId = Auth::id();
        $order = Order::where('id', $userId)->paginate(5);
        return view('sewa_buku.user.order.index_order', ['order' => $order]);
    }

    public function showOrder($id)
    {
        $order = Order::findOrFail($id);

        //return response()->json(['order' => $order]);
        return view('sewa_buku.user.order.order_detail', ['order' => $order]);
    }

    public function storeOrder($id)
    {
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

    public function storePayment($id)
    {
        try {
            $user = Auth::user();
            $checkLangganan = Langganan::where('id', $user->id)->first();
            $checkLanggananAktif = Langganan::where('id', $user->id)->where('status_langganan', true)->first();
            $order = Order::find($id);
            if (!$order) {
                return formatResponse('error', 'Pembelian Paket gagal', null, 'Order tidak ditemukan', 422);
            }
            $payment = Payment::where('id_order', $order->id_order)->first();
            /** @var object $status */
            $status = \Midtrans\Transaction::status($payment->id_payment_gateway);

            $payment->update([
                'id_order' => $order->id_order,
                'total_bayar' => $status->gross_amount,
                'metode_pembayaran' => $status->payment_type,
                'fraud_status' => $status->fraud_status ?? null,
                'status_pembayaran' => $status->transaction_status == 'settlement' ? 'Dibayar' : 'Proses',
            ]);

            $order->status_order = $status->transaction_status == 'settlement' ? 'Dibayar' : 'Proses';
            $order->save();

            if ($order->status_order == 'Dibayar') {
                if ($checkLanggananAktif) {
                    $checkLanggananAktif->update([
                        'id_paket_langganan' => $order->id_paket_langganan,
                        'status_langganan' => true,
                        'mulai_langganan' => now(),
                        'akhir_langganan' => Carbon::parse($checkLanggananAktif->akhir_langganan)->addDays($order->masa_waktu)
                    ]);
                }
                if ($checkLangganan) {
                    $checkLangganan->update([
                        'id_paket_langganan' => $order->id_paket_langganan,
                        'status_langganan' => true,
                        'mulai_langganan' => now(),
                        'akhir_langganan' => Carbon::parse($checkLangganan->akhir_langganan)->addDays($order->masa_waktu)
                    ]);
                } else {
                    Langganan::create([
                        'id' => $order->id,
                        'id_paket_langganan' => $order->id_paket_langganan,
                        'status_langganan' => true,
                        'mulai_langganan' => now(),
                        'akhir_langganan' => now()->addDays($order->masa_waktu),
                    ]);
                }
            }

            return formatResponse(true, 'Transaksi berhasil dimulai', [
                'snap_token' => $payment->snap_token,
                'status' => $status->transaction_status,
            ]);
        } catch (\Exception $e) {
            $id_payment_gateway = $order->id . '-' . Str::uuid();
            $transactionDetails = [
                'order_id' => $id_payment_gateway,
                'gross_amount' => $order->total_bayar,
            ];

            // Customer details
            $customerDetails = [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ];

            // Payload for Midtrans Snap
            $params = [
                'transaction_details' => $transactionDetails,
                'customer_details' => $customerDetails,
            ];
            $snapToken = Snap::getSnapToken($params);
            Payment::create([
                'id_order' => $order->id_order,
                'total_bayar' => $order->total_bayar,
                'metode_pembayaran' => 'Belum Pilih',
                'status_pembayaran' => 'Proses',
                'snap_token' => $snapToken,
                'id_payment_gateway' => $id_payment_gateway
            ]);

            return formatResponse(true, 'Transaksi berhasil dimulai', [
                'snap_token' => $snapToken,
            ]);
        }
    }

    public function indexOrderAdmin()
    {
        $order = Order::with('user', 'buku')->get();
        //return response()->json(['order' => $order]);
        return view('sewa_buku.admin.order.index_order', ['order' => $order]);
    }

    public function showOrderAdmin($id)
    {
        $order = Order::findOrFail($id);
        return view('sewa_buku.admin.order.show_order', ['order' => $order]);
    }

    public function deleteOrderAdmin($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->back()->with('success', 'Order deleted successfully');
    }

    public function batalkanOrder($id)
    {
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
