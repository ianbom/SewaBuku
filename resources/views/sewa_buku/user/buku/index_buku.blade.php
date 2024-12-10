@extends('sewa_buku.layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <h1 class="text-3xl font-bold text-center mb-8">Daftar Buku</h1>

    <!-- Filter dan Search -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
        <div class="flex space-x-4 mb-4 md:mb-0">
            <button class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">Filter</button>
            <button class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">Sort</button>
        </div>
        <div class="w-full md:w-1/3">
            <form action="{{ route('judulBuku.search') }}" method="GET" class="mb-4">
                <input type="text" name="query" placeholder="Cari judul buku..." class="border rounded p-2">
                <button type="submit" class="bg-blue-500 text-white rounded px-4 py-2">Cari</button>
            </form>

        </div>
    </div>

    <!-- Grid untuk daftar buku -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
        @foreach($buku as $book)
        <div class="bg-white shadow-md rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
            <!-- Menampilkan cover buku dari relasi coverBuku -->
            @if($book->coverBuku && $book->coverBuku->first())
                <img src="{{ asset('storage/' . $book->coverBuku->first()->file_image) }}" alt="Cover Buku" class="w-full h-48 object-cover">
            @else
                <img src="https://via.placeholder.com/150" alt="Cover Placeholder" class="w-full h-48 object-cover">
            @endif

            <div class="p-4">
                <h3 class="text-xl font-semibold mb-2">{{ $book->judul_buku }}</h3>
                <p class="text-gray-600 mb-4">{{ Str::limit($book->sinopsis, 80) }}</p>
                <div class="mb-4">
                    <span class="text-black font-semibold">Rating:</span>
                    <div class="inline-block ml-2">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($book->ratingRerata))
                                <i class="fas fa-star text-yellow-500"></i>
                            @elseif($i - $book->ratingRerata < 1)
                                <i class="fas fa-star-half-alt text-yellow-500"></i>
                            @else
                                <i class="far fa-star text-yellow-500"></i>
                            @endif
                        @endfor
                    </div>
                </div>

                <!-- Harga dan tombol order -->
                <div class="flex justify-between items-center mb-4">
                    <span class="text-gray-900 font-bold text-lg">Rp{{ number_format($book->harga, 0, ',', '.') }}</span>
                    <a href="{{ route('user.buku.show', $book->id_buku) }}" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Detail</a>
                </div>

                @if ($book->is_free == true || $checkLangganan)
                <!-- Jika buku gratis atau user memiliki langganan -->
                <a href="{{ route('user.buku.baca', $book->id_buku) }}" class="bg-yellow-500 text-white py-2 px-4 rounded hover:bg-yellow-600 w-full">Baca Buku</a>
          @else
                <!-- Jika buku berbayar dan user tidak memiliki langganan -->
                <span class="bg-yellow-500 text-white py-2 px-4 rounded w-full disabled">Langganan untuk membaca</span>
            @endif


                <!-- Tombol Favorite -->
                <form action="{{ route('user.favorite.store', $book->id_buku) }}" method="POST" class="mt-2">
                    @csrf
                    @if(in_array($book->id_buku, $favorites))
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
        @endforeach
    </div>
</div>
@endsection
