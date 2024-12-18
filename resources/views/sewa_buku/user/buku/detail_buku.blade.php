@extends('sewa_buku.layouts.userApp')

@section('title')
    {{ $buku->judul_buku }}
@endsection

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
                <p><span class="font-semibold">Tentang Penulis:</span> {{ $buku->tentang_penulis }}</p>
                <p><a href="{{ $buku->link_pembelian }}" class="font-semibold text-blue-500">Link Pemberlian: {{ $buku->link_pembelian }}</a> </p>
                <p><span class="font-semibold">Rating Amazon:</span> {{ $buku->rating_amazon }}</p>
                <p><span class="font-semibold">ISBN:</span> {{ $buku->isbn }}</p>
                <p><span class="font-semibold">Tahun Terbit:</span> {{ $buku->tahun_terbit }}</p>
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
                @if($rating)
                    @foreach($rating as $rating)
                        <div class="border-t border-gray-200 pt-4">
                            <p>{{ $rating->user->name }}</p>
                            <p class="text-lg font-semibold">Komentar : {{ $rating->komentar }}</p>
                            <p class="text-yellow-500">Rating : {{ $rating->rating }} / 5</p>
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-500">Belum ada komentar atau rating untuk buku ini.</p>
                @endif
            </div>

            {{-- Submit Rating --}}

            <div class="mt-10">
                @if ($checkLanggananAktif)
                @if ($ratingCheck)
                    <h3 class="text-xl font-semibold mb-4">Rating Anda:</h3>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Rating:</label>
                        <p class="text-gray-900">{{ $ratingCheck->rating }} / 5</p>
                    </div>

                    @if ($ratingCheck->komentar)
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Komentar:</label>
                            <p class="text-gray-900">{{ $ratingCheck->komentar }}</p>
                        </div>
                    @endif
                @else
                    <h3 class="text-xl font-semibold mb-4">Berikan Rating untuk Order Ini:</h3>
                    <form action="{{ route('user.rating.store', $buku->id_buku) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Rating (1-5):</label>
                            <select name="rating" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Komentar:</label>
                            <textarea name="komentar" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"></textarea>
                        </div>
                        <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600">
                            Submit Rating
                        </button>
                    </form>
                @endif
                @else
                <span>Anda belum berlangganan, tidak bisa memberi rating</span>
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
