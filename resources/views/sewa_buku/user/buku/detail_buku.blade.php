@extends('sewa_buku.layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg overflow-hidden">
        <!-- Bagian Cover Buku -->
        <div class="relative grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @if($buku->coverBuku && $buku->coverBuku->count() > 0)
                @foreach($buku->coverBuku as $cover)
                    <img src="{{ asset('storage/' . $cover->file_image) }}" alt="Cover Buku" class="w-full h-96 object-cover">
                @endforeach
            @else
                <img src="https://via.placeholder.com/150" alt="Cover Placeholder" class="w-full h-96 object-cover">
            @endif
        </div>

        <!-- Bagian Informasi Buku -->
        <div class="p-6">
            <h1 class="text-3xl font-bold mb-4">{{ $buku->judul_buku }}</h1>

            <div class="mb-4">
                <p><span class="font-semibold">Penulis:</span> {{ $buku->penulis }}</p>
                <p><span class="font-semibold">Penerbit:</span> {{ $buku->penerbit }}</p>
                <p><span class="font-semibold">Jumlah Halaman:</span> {{ $buku->jumlah_halaman }}</p>
                <p><span class="font-semibold">ISBN:</span> {{ $buku->isbn }}</p>
                <p><span class="font-semibold">Tahun Terbit:</span> {{ $buku->tahun_terbit }}</p>
            </div>

            <div class="mb-4">
                <h2 class="text-2xl font-semibold mb-2">Harga:</h2>
                <p class="text-lg font-bold text-green-500">Rp{{ number_format($buku->harga, 0, ',', '.') }}</p>
            </div>

            <div class="mb-4">
                <h2 class="text-2xl font-semibold mb-2">Sinopsis:</h2>
                <p>{{ $buku->sinopsis }}</p>
            </div>

            <div class="mb-4">
                <h2 class="text-2xl font-semibold mb-2">Tags:</h2>
                @if($buku->tags->isNotEmpty())
                    <ul>
                        @foreach ($buku->tags as $tag)
                            <li>{{ $tag->nama_tags }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>Tidak ada tag untuk buku ini.</p>
                @endif
            </div>


            <!-- Bagian Teaser Audio -->
            @if($buku->teaser_audio)
            <div class="mb-4">
                <h2 class="text-2xl font-semibold mb-2">Teaser Audio:</h2>
                <audio controls>
                    <source src="{{ asset('storage/' . $buku->teaser_audio) }}" type="audio/mp3">
                    Your browser does not support the audio element.
                </audio>
            </div>
            @endif

            <!-- Bagian Ringkasan Audio -->
            {{-- @if($buku->ringkasan_audio)
            <div class="mb-4">
                <h2 class="text-2xl font-semibold mb-2">Ringkasan Audio:</h2>
                <audio controls>
                    <source src="{{ asset('storage/' . $buku->ringkasan_audio) }}" type="audio/mp3">
                    Your browser does not support the audio element.
                </audio>
            </div>
            @endif --}}

            <!-- Bagian Rata-rata Rating -->
            @if($averageRating)
            <div class="mb-4">
                <h2 class="text-2xl font-semibold mb-2">Rata-rata Rating:</h2>
                <p class="text-lg font-bold text-yellow-500">{{ number_format($averageRating, 1) }} / 5</p>
            </div>
            @endif

            <!-- Bagian Komentar dan Rating dari User -->
            <div class="mb-4">
                <h2 class="text-2xl font-semibold mb-2">Komentar dan Rating:</h2>
                @if($buku->order->whereNotNull('rating')->count() > 0)
                    @foreach($buku->order->whereNotNull('rating') as $order)
                        <div class="border-t border-gray-200 pt-4">
                            <p>{{ $order->user->name }}</p>
                            <p class="text-lg font-semibold">Komentar : {{ $order->rating->komentar }}</p>
                            <p class="text-yellow-500">Rating : {{ $order->rating->rating }} / 5</p>
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-500">Belum ada komentar atau rating untuk buku ini.</p>
                @endif
            </div>

            <!-- Tombol Favorite -->
            <form action="{{ route('user.favorite.store', $buku->id_buku) }}" method="POST" class="mt-4">
                @csrf
                @if(in_array($buku->id_buku, $favorites))
                    <!-- Jika buku sudah ada di favorite -->
                    <button disabled class="bg-red-500 text-white py-2 px-4 rounded w-full">
                        <i class="fas fa-heart"></i> Favorited
                    </button>
                @else
                    <!-- Jika buku belum ada di favorite -->
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 w-full">
                        <i class="far fa-heart"></i> Add to Favorite
                    </button>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection
