@extends('sewa_buku.layouts.userApp')

@section('title')
    Langganan Anda
@endsection

@section('content')
<div class="container mx-auto mt-10 px-4">
    <h1 class="text-3xl font-bold text-center mb-8">Langganan Anda</h1>

    @if($langganan->isEmpty())
        <!-- Pesan jika tidak ada langganan -->
        <div class="text-center">
            <p class="text-lg text-gray-600">Anda belum memiliki paket langganan saat ini.</p>
            <a href="{{ route('paket-langganan.index') }}"
               class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                Lihat Paket Langganan
            </a>
        </div>
    @else
        <!-- Daftar Langganan -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($langganan as $item)
            <div class="bg-white shadow-md rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="p-6">
                    <!-- Nama Paket -->
                    <h3 class="text-2xl font-bold mb-4 text-blue-600">{{ $item->paketLangganan->nama_paket }}</h3>

                    <!-- Status Langganan -->
                    <p class="mb-2">
                        <span class="font-semibold text-gray-700">Status Langganan:</span>
                        @if($item->status_langganan)
                            <span class="text-green-500 font-bold">Aktif</span>
                        @else
                            <span class="text-red-500 font-bold">Tidak Aktif</span>
                        @endif
                    </p>

                    <!-- Tanggal Langganan -->
                    <p class="text-gray-600 mb-1">
                        <span class="font-semibold">Mulai Langganan:</span>
                        {{ \Carbon\Carbon::parse($item->mulai_langganan)->format('d M Y') }}
                    </p>
                    <p class="text-gray-600 mb-4">
                        <span class="font-semibold">Akhir Langganan:</span>
                        {{ \Carbon\Carbon::parse($item->akhir_langganan)->format('d M Y') }}
                    </p>

                    <!-- Pesan Pembaruan -->
                    @if(\Carbon\Carbon::parse($item->akhir_langganan)->isPast())
                        <p class="text-red-600 font-semibold mb-4">Langganan Anda telah berakhir.</p>
                        <a href="{{ route('paket-langganan.index') }}"
                           class="block bg-yellow-500 text-white text-center py-2 px-4 rounded hover:bg-yellow-600">
                            Perbarui Langganan
                        </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
