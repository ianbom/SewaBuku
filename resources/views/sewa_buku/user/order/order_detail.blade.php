@extends('sewa_buku.layouts.userApp')

@section('title')
    Detail Order
@endsection

@section('content')
<div class="container mx-auto mt-10 px-4">
    <h1 class="text-3xl font-bold text-center mb-8">Detail Order</h1>

    <!-- Card Detail Order -->
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-semibold mb-6">Order ID: {{ $order->id_order }}</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Informasi Pembeli -->
            <div>
                <p class="text-gray-700 font-semibold mb-2">Pembeli:</p>
                <p class="text-gray-900">{{ $order->user->name }}</p>
            </div>
            <!-- Nama Paket -->
            <div>
                <p class="text-gray-700 font-semibold mb-2">Nama Paket:</p>
                <p class="text-gray-900">{{ $order->paketLangganan->nama_paket }}</p>
            </div>
            <!-- Total Bayar -->
            <div>
                <p class="text-gray-700 font-semibold mb-2">Total Bayar:</p>
                <p class="text-gray-900">Rp{{ number_format($order->total_bayar, 0, ',', '.') }}</p>
            </div>
            <!-- Status Order -->
            <div>
                <p class="text-gray-700 font-semibold mb-2">Status Order:</p>
                @if($order->status_order === 'Proses')
                    <span class="text-yellow-500 font-bold">Proses</span>
                @elseif($order->status_order === 'Selesai')
                    <span class="text-green-500 font-bold">Selesai</span>
                @else
                    <span class="text-red-500 font-bold">{{ $order->status_order }}</span>
                @endif
            </div>
        </div>

        <!-- Tanggal Order -->
        <div class="mb-6">
            <p class="text-gray-700 font-semibold mb-2">Tanggal Order:</p>
            <p class="text-gray-900">{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, H:i') }}</p>
        </div>

        <!-- Aksi -->
        <div class="flex flex-wrap gap-4 justify-end">
            <!-- Tombol Kembali -->
            <a href="{{ url()->previous() }}" class="bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-600">
                Kembali
            </a>

            <!-- Batalkan Order -->
            @if ($order->status_order == 'Proses')
            <form action="{{ route('user.order.batal', $order->id_order) }}" method="POST">
                @csrf
                @method('PUT')
                <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600">
                    Batalkan Order
                </button>
            </form>
            @endif

            <!-- Cetak Invoice -->
            <a href="#" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                Cetak Invoice
            </a>

            <!-- Tombol Bayar -->
            @if ($order->status_order == 'Proses')
            <form action="{{ route('user.payment.store', $order->id_order) }}" method="POST">
                @csrf
                <button type="submit" class="bg-yellow-500 text-white py-2 px-4 rounded hover:bg-yellow-600">
                    Bayar Sekarang
                </button>
            </form>
            @endif
        </div>

        <!-- Section Rating -->
        @if ($order->status_order === 'Selesai')
        <div class="mt-10 border-t pt-6">
            <h3 class="text-xl font-bold mb-4">Berikan Rating untuk Order Ini:</h3>
            @if ($rating)
                <!-- Tampilkan Rating Jika Sudah Ada -->
                <div class="mb-4">
                    <p class="text-gray-700 font-semibold">Rating:</p>
                    <p class="text-yellow-500">{{ $rating->rating }} / 5</p>
                </div>
                @if ($rating->komentar)
                <div>
                    <p class="text-gray-700 font-semibold">Komentar:</p>
                    <p class="text-gray-900">{{ $rating->komentar }}</p>
                </div>
                @endif
            @else
                <!-- Form untuk Memberikan Rating -->
                <form action="{{ route('user.rating.store', $order->id_order) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Rating (1-5):</label>
                        <select name="rating" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Komentar:</label>
                        <textarea name="komentar" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200"></textarea>
                    </div>
                    <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600">
                        Submit Rating
                    </button>
                </form>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection
