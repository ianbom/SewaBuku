@extends('sewa_buku.layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <h1 class="text-3xl font-bold text-center mb-8">Daftar Buku</h1>

    <!-- Filter dan Search -->
    <div class="flex justify-between items-center mb-6">
        <div class="flex space-x-4">
            <button class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">Filter</button>
            <button class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">Sort</button>
        </div>
        <div class="w-1/3">
            <input type="text" placeholder="Search buku..." class="w-full px-4 py-2 border border-gray-300 rounded">
        </div>
    </div>

    <!-- Grid untuk daftar buku -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
        @foreach($buku as $book)
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <!-- Menampilkan cover buku dari relasi coverBuku -->
            @if($book->coverBuku && $book->coverBuku->first())
                <img src="{{ asset('storage/' . $book->coverBuku->first()->file_image) }}" alt="Cover Buku" class="w-full h-48 object-cover">
            @else
                <img src="https://via.placeholder.com/150" alt="Cover Placeholder" class="w-full h-48 object-cover">
            @endif

            <div class="p-4">
                <h3 class="text-xl font-semibold mb-2">{{ $book->judul_buku }}</h3>
                <p class="text-gray-600 mb-4">{{ Str::limit($book->sinopsis, 80) }}</p>
                <p class="text-black-600 mb-4">
                    Rating:
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= floor($book->ratingRerata))
                            <!-- Bintang Penuh -->
                            <i class="fas fa-star text-yellow-500"></i>
                        @elseif($i - $book->ratingRerata < 1)
                            <!-- Bintang Setengah -->
                            <i class="fas fa-star-half-alt text-yellow-500"></i>
                        @else
                            <!-- Bintang Kosong -->
                            <i class="far fa-star text-yellow-500"></i>
                        @endif
                    @endfor
                </p>


              <form action="{{ route('user.order.store', $book->id_buku) }}" method="POST">
                @csrf

                <div class="flex justify-between items-center">
                    <span class="text-gray-900 font-bold text-lg">Rp{{ number_format($book->harga, 0, ',', '.') }}</span>
                    <a href="" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Detail</a>
                    <button
                        class="bg-yellow-500 text-white py-2 px-4 rounded hover:bg-yellow-600 order-btn"
                        type="submit">
                        Order
                    </button>
                </div>
            </form>
            @endforeach
            </div>
        </div>

    </div>




</div>



