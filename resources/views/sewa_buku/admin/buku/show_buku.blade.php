@extends('sewa_buku.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-4">{{ $buku->nama_buku }}</h1>

    <div class="mb-4">
        <span class="text-lg font-semibold">Harga:</span>
        <span class="text-lg text-green-500">Rp {{ number_format($buku->harga, 2, ',', '.') }}</span>
    </div>

    <div class="mb-4">
        <span class="text-lg font-semibold">Sinopsis:</span>
        <p class="text-gray-700">{{ $buku->sinopsis }}</p>
    </div>

    <div class="mb-4">
        <span class="text-lg font-semibold">Full Cerita:</span>
        <p class="text-gray-700">{{ $buku->full_cerita }}</p>
    </div>

    <div class="mb-4">
        <span class="text-lg font-semibold">Trailer:</span>
        <audio controls>
            <source src="{{ asset('storage/' . $buku->trailer_voice) }}" type="audio/mp3">
            Your browser does not support the audio tag.
        </audio>
    </div>

    <div class="mb-4">
        <span class="text-lg font-semibold">Full Voice:</span>
        <audio controls>
            <source src="{{ asset('storage/' . $buku->full_voice) }}" type="audio/mp3">
            Your browser does not support the audio tag.
        </audio>
    </div>

    <h2 class="text-xl font-bold mt-6 mb-4">Cover Buku:</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($buku->coverBuku as $cover)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <img src="{{ asset('storage/' . $cover->file_image) }}" alt="{{ $buku->nama_buku }}" class="w-full h-48 object-cover">
        </div>
        @endforeach
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.buku.index') }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Kembali ke Daftar Buku
        </a>
    </div>
</div>

{{-- <div class="flex flex-wrap gap-4 mb-4">
    @foreach ($buku->coverBuku as $cover)
        <div class="relative">
            <img src="{{ Storage::url($cover->file_image) }}" alt="Cover Buku" class="w-32 h-48 object-cover border border-gray-300 rounded-md">
           <form action="{{ route('admin.buku.deleteCover', $cover->id_cover_buku) }}" method="POST" class="absolute top-0 right-0">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white rounded-full text-xs p-1">Delete</button>
            </form>
        </div>
    @endforeach
</div> --}}

