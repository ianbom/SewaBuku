@extends('sewa_buku.layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <h1 class="text-3xl font-bold text-center mb-8">Langganan Anda</h1>

    @if($langganan->isEmpty())
        <div class="text-center">
            <p class="text-lg text-gray-600">Anda belum memiliki paket langganan saat ini.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($langganan as $item)
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h3 class="text-xl font-semibold mb-2">Nama Paket: {{ $item->paketLangganan->nama_paket }}</h3>

                <!-- Status Langganan -->
                <p class="text-gray-700 mb-4">
                    Status Langganan:
                    @if($item->status_langganan)
                        <span class="text-green-500 font-bold">Aktif</span>
                    @else
                        <span class="text-red-500 font-bold">Tidak Aktif</span>
                    @endif
                </p>

                <!-- Tanggal Langganan -->
                <p class="text-gray-600">Mulai Langganan: {{ \Carbon\Carbon::parse($item->mulai_langganan)->format('d M Y') }}</p>
                <p class="text-gray-600 mb-4">Akhir Langganan: {{ \Carbon\Carbon::parse($item->akhir_langganan)->format('d M Y') }}</p>


            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
