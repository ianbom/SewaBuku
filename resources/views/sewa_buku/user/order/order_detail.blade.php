@extends('sewa_buku.layouts.userApp')

@section('title')
    Order Detail
@endsection

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold text-blue-900 mb-8 mt-16">Subscription Package</h1>

    <div class="bg-white rounded-2xl shadow p-6 w-full border border-blue-400">
        <div class="flex items-center mb-6">
            <button onclick="history.back()" class="text-gray-600 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Order Detail
            </button>
        </div>

        <div class="bg-blue-100 rounded-xl p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-6">No. {{ $order->id_order }}</h2>

            <!-- Divider bawah No -->
            <hr class="border-t border-black my-4 ">

            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Package Name</span>
                    <span class="text-gray-900">{{ $order->paketLangganan->nama_paket }}</span>
                </div>

                <div class="flex justify-between items-center">
                    <span class="text-gray-600">On behalf of</span>
                    <span class="text-gray-900">{{ $order->user->name }}</span>
                </div>

                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Order Date</span>
                    <span class="text-gray-900">{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, H:i') }}</span>
                </div>

                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Total Payment</span>
                    <span class="text-gray-900">Rp{{ number_format($order->total_bayar, 0, ',', '.') }}</span>
                </div>

                <!-- Divider atas Order Status -->
                <hr class="border-t border-black my-4">

                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Order Status</span>
                    <span class="text-blue-500 font-medium">{{ strtoupper($order->status_order) }}</span>
                </div>
            </div>
        </div>


        <div class="flex justify-end space-x-4 mt-6">
            @if ($order->status_order == 'Proses')
                <form action="{{ route('user.order.batal', $order->id_order) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="px-6 py-2 rounded-lg bg-red-100 text-red-500 hover:bg-red-200 transition">
                        Cancle
                    </button>
                </form>

                <form action="{{ route('user.payment.store', $order->id_order) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-6 py-2 rounded-lg bg-blue-500 text-white hover:bg-blue-600 transition">
                        Pay Now
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
