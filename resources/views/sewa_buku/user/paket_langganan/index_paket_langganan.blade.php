@extends('sewa_buku.layouts.userApp')

@section('content')
<div class="container mx-auto p-6">



    <h1 class="text-2xl font-bold text-blue-900 mb-8 mt-16">Subscription Package</h1>

    <!-- Search Bar -->
    <div class="mb-10">
        <div class="relative max-w-xl">
            <input type="text"
                   placeholder="Find a package you like..."
                   class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-blue-500 text-white px-6 py-1.5 rounded-lg">
                Cari
            </button>
        </div>
    </div>

    <!-- Package Cards -->
    @if($paketLangganan->isEmpty())
        <p class="text-gray-600">Belum ada paket langganan yang tersedia.</p>
    @else
        <h2 class="text-lg font-semibold text-gray-800 mb-6">Last Pick Up</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($paketLangganan as $paket)
                <div class="bg-blue-500 rounded-xl p-6 text-white">
                    <!-- Icons -->
                    <div class="flex gap-4 mb-4">
                        <div class="bg-white/20 rounded-lg px-3 py-1 flex items-center space-x-1">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18z"/>
                            </svg>
                            <span>Online</span>
                        </div>
                        <div class="bg-white/20 rounded-lg px-3 py-1 flex items-center space-x-1">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18z"/>
                            </svg>
                            <span>Audiobooks</span>
                        </div>
                    </div>

                    <h3 class="text-xl font-bold mb-2">{{ $paket->nama_paket }}</h3>
                    <p class="mb-6 text-white/90">{{ $paket->deskripsi }}</p>

                    <!-- Time and Price -->
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center space-x-2">
                            <span class="text-sm">Time: {{ $paket->masa_waktu }} Days</span>
                        </div>
                        <div class="text-lg font-bold">
                            Rp. {{ number_format($paket->harga, 0, ',', '.') }}
                        </div>
                    </div>

                    @if($paket->is_active)
                        <form action="{{ route('user.order.store', $paket->id_paket_langganan) }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="w-full bg-white text-blue-500 py-2 rounded-lg font-medium hover:bg-blue-50 transition">
                                Subscribe Now
                            </button>
                        </form>
                    @else
                        <p class="text-red-200 text-center py-2">Paket tidak tersedia</p>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
