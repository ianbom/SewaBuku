@extends('sewa_buku.layouts.userApp')

@section('title')
    Buku Favorit Saya
@endsection

@section('content')
<div class="container mx-auto mt-10 px-4">
    <h1 class="text-3xl font-bold text-center mb-8">Buku Favorit Saya</h1>

    @if($favorite->isEmpty())
        <!-- Pesan jika tidak ada favorit -->
        <p class="text-center text-gray-600">Anda belum memiliki buku favorit.</p>
    @else
        <!-- Grid untuk daftar buku favorit -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach($favorite as $fav)
            <div class="bg-white shadow-md rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <!-- Cover Buku -->
                @if($fav->buku->coverBuku && $fav->buku->coverBuku->first())
                    <img src="{{ asset('storage/' . $fav->buku->coverBuku->first()->file_image) }}"
                         alt="Cover Buku"
                         class="w-full h-48 object-cover">
                @else
                    <img src="https://via.placeholder.com/150"
                         alt="Cover Placeholder"
                         class="w-full h-48 object-cover">
                @endif

                <!-- Informasi Buku -->
                <div class="p-4">
                    <h3 class="text-xl font-semibold mb-2">{{ $fav->buku->judul_buku }}</h3>
                    <p class="text-gray-600 mb-4">{{ Str::limit($fav->buku->sinopsis, 80) }}</p>

                    <!-- Tombol dan Rating -->
                    <div class="flex flex-col gap-2">
                        <a href="{{ route('user.buku.show', $fav->buku->id_buku) }}"
                           class="text-center bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                            Lihat Detail
                        </a>

                        <form action="{{ route('user.favorite.delete', $fav->id_favorite) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="w-full bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600">
                                Hapus dari Favorit
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
