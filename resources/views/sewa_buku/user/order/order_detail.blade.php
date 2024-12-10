@extends('sewa_buku.layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <h1 class="text-3xl font-bold text-center mb-8">Detail Order</h1>

    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-semibold mb-4">Order ID: {{ $order->id_order }}</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Detail Informasi Order -->
            <div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Pembeli:</label>
                    <p class="text-gray-900">{{ $order->user->name }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Nama Paket:</label>
                    <p class="text-gray-900">{{ $order->paketLangganan->nama_paket }}</p>
                </div>
            </div>


            <!-- Informasi Pembayaran -->
            <div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Total Bayar:</label>
                    <p class="text-gray-900">Rp{{ number_format($order->total_bayar, 0, ',', '.') }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Status Order:</label>
                    <p class="text-gray-900">{{ $order->status_order }}</p>
                </div>



            </div>
        </div>

        <!-- Tanggal Order -->
        <div class="mt-6">
            <label class="block text-gray-700 font-bold mb-2">Tanggal Order:</label>
            <p class="text-gray-900">{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, H:i') }}</p>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex justify-end mt-8">
            <a href="{{ url()->previous() }}" class="bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-600 mr-4">
                Kembali
            </a>

            @if ($order->status_order == 'Proses')
            <form action="{{ route('user.order.batal', $order->id_order) }}" method="POST">
                @csrf
                @method('PUT')

                <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600">Batalkan</button>
            </form>
        @endif


            <a href="#" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                Cetak Invoice
            </a>


            @if ($order->status_order == 'Proses')
                <form action="{{ route('user.payment.store', $order->id_order) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-yellow-500 text-white py-2 px-4 rounded hover:bg-yellow-600">Bayar</button>
                </form>
            @endif
        </div>

        <!-- Rating Section -->
        {{-- @if ($order->status_order == 'Dibayar')
            <div class="mt-10">
                @if ($rating)
                    <h3 class="text-xl font-semibold mb-4">Rating Anda:</h3>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Rating:</label>
                        <p class="text-gray-900">{{ $rating->rating }} / 5</p>
                    </div>

                    @if ($rating->komentar)
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Komentar:</label>
                            <p class="text-gray-900">{{ $rating->komentar }}</p>
                        </div>
                    @endif
                @else
                    <h3 class="text-xl font-semibold mb-4">Berikan Rating untuk Order Ini:</h3>

                    <form action="{{ route('user.rating.store', $order->id_order) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Rating (1-5):</label>
                            <select name="rating" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Komentar:</label>
                            <textarea name="komentar" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"></textarea>
                        </div>

                        <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600">
                            Submit Rating
                        </button>
                    </form>
                @endif
            </div>
        @endif --}}

    </div>
</div>
@endsection
