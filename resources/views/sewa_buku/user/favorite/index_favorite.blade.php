@extends('sewa_buku.layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <h1 class="text-3xl font-bold text-center mb-8">Buku Favorit Saya</h1>

    @if($favorite->isEmpty())
        <p class="text-center text-gray-600">Anda belum memiliki buku favorit.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach($favorite as $fav)
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <!-- Menampilkan cover buku dari relasi coverBuku -->
                @if($fav->buku->coverBuku && $fav->buku->coverBuku->first())
                    <img src="{{ asset('storage/' . $fav->buku->coverBuku->first()->file_image) }}" alt="Cover Buku" class="w-full h-48 object-cover">
                @else
                    <img src="https://via.placeholder.com/150" alt="Cover Placeholder" class="w-full h-48 object-cover">
                @endif

                <div class="p-4">
                    <h3 class="text-xl font-semibold mb-2">{{ $fav->buku->judul_buku }}</h3>
                    <p class="text-gray-600 mb-4">{{ Str::limit($fav->buku->sinopsis, 80) }}</p>

                    <!-- Rating bintang -->
                    {{-- <p class="text-black-600 mb-4">
                        Rating:
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($fav->buku->ratingRerata))
                                <!-- Bintang Penuh -->
                                <i class="fas fa-star text-yellow-500"></i>
                            @elseif($i - $fav->buku->ratingRerata < 1)
                                <!-- Bintang Setengah -->
                                <i class="fas fa-star-half-alt text-yellow-500"></i>
                            @else
                                <!-- Bintang Kosong -->
                                <i class="far fa-star text-yellow-500"></i>
                            @endif
                        @endfor
                    </p> --}}

                    <div class="flex justify-between items-center">
                        
                        <a href="{{ route('user.buku.show', $fav->buku->id_buku) }}" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Detail</a>
                    </div>
                    <form action="{{ route('user.favorite.delete', $fav->id_favorite) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600 ml-auto">
                            Hapus Dari Favorit
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
