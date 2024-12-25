@extends('sewa_buku.layouts.userApp')


@section('content')
<div class="container mx-auto m-10" >
    <h1 class="text-3xl font-bold text-center mb-8">Daftar Buku</h1>

    <!-- Filter dan Search -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
        <!-- Filter and Sort Buttons -->
        <div class="flex space-x-4 mb-4 md:mb-0">
            <button class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">Filter</button>
            <button class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">Sort</button>
        </div>

        <!-- Search Bar -->
        <div class="w-full md:w-1/3">
            <form action="{{ route('judulBuku.search') }}" method="GET" class="flex items-center">
                <input type="text" name="query" placeholder="Cari judul buku..."
                       class="w-full border rounded-l p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-r hover:bg-blue-600">Cari</button>
            </form>
        </div>
    </div>

    <!-- Grid untuk Daftar Buku -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($buku as $book)
        <div class="bg-white shadow-md rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300">
            <!-- Cover Buku -->
            @if($book->coverBuku && $book->coverBuku->first())
                <img src="{{ asset('storage/' . $book->coverBuku->first()->file_image) }}" alt="Cover Buku" class="w-full h-48 object-cover">
            @else
                <img src="https://via.placeholder.com/150" alt="Cover Placeholder" class="w-full h-48 object-cover">
            @endif

            <!-- Informasi Buku -->
            <div class="p-4">
                <h3 class="text-xl font-semibold mb-2">{{ $book->judul_buku }}</h3>
                <p class="text-gray-600 mb-4">{{ Str::limit($book->sinopsis, 80) }}</p>

                <!-- Rating -->
                <div class="mb-4">
                    <span class="text-black font-semibold">Rating:</span>
                    <div class="inline-block ml-2">
                        @if($book->ratingRerata > 0)
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($book->ratingRerata))
                                    <i class="fas fa-star text-yellow-500"></i>
                                @elseif($i - $book->ratingRerata < 1)
                                    <i class="fas fa-star-half-alt text-yellow-500"></i>
                                @else
                                    <i class="far fa-star text-yellow-500"></i>
                                @endif
                            @endfor
                        @else
                            <span class="text-gray-500">Belum ada rating</span>
                        @endif
                    </div>
                </div>

                <!-- Tombol Detail -->
                <div class="mb-4">
                    <a href="{{ route('user.buku.show', $book->id_buku) }}"
                       class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Detail</a>
                </div>

                <!-- Akses Buku -->
                @if ($book->is_free || $checkLangganan)
                    <a href="{{ route('user.buku.baca', $book->id_buku) }}"
                       class="block bg-yellow-500 text-white py-2 px-4 rounded hover:bg-yellow-600 text-center">Baca Buku</a>
                @else
                    <span class="block bg-gray-400 text-white py-2 px-4 rounded text-center">Langganan untuk membaca</span>
                @endif

                <!-- Tombol Favorite -->
                <form action="{{ route('user.favorite.store', $book->id_buku) }}" method="POST" class="mt-2">
                    @csrf
                    @if(in_array($book->id_buku, $favorites))
                        <button disabled class="w-full bg-red-500 text-white py-2 px-4 rounded">
                            <i class="fas fa-heart"></i> Favorited
                        </button>
                    @else
                        <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                            <i class="far fa-heart"></i> Add to Favorite
                        </button>
                    @endif
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
