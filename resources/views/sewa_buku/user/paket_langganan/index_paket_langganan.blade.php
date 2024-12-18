@extends('sewa_buku.layouts.userApp')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Daftar Paket Langganan</h1>

    @if($paketLangganan->isEmpty())
        <p class="text-gray-600">Belum ada paket langganan yang tersedia.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($paketLangganan as $paket)
                <div class="border rounded-lg p-4 shadow hover:shadow-lg transition">
                    <h2 class="text-lg font-semibold text-gray-800">{{ $paket->nama_paket }}</h2>
                    <p class="text-gray-600">Harga: Rp {{ number_format($paket->harga, 0, ',', '.') }}</p>
                    <p class="text-gray-600">Masa Aktif: {{ $paket->masa_waktu }} hari</p>
                    <p class="text-gray-600 mt-2">{{ $paket->deskripsi }}</p>

                    @if($paket->is_active)
                        <div class="mt-4">
                            <form action="{{ route('user.order.store', $paket->id_paket_langganan) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition" > Beli </button>
                            </form>
                        </div>
                    @else
                        <p class="text-red-500 font-semibold mt-4">Paket tidak tersedia</p>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
