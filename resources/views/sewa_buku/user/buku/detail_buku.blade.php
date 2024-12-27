    @extends('sewa_buku.layouts.userApp')

    @section('title')
        {{ $buku->judul_buku }}
    @endsection

    @section('content')
    <div class="container mx-8 px-4 py-8">
        <div class="max-w-6xl">
            <!-- Main Content -->
            <div class=" max-w">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 p-8">
                    <!-- Left Column - Image -->
                    <div>
                        @if($buku->coverBuku && $buku->coverBuku->count() > 0)
                            <img src="{{ asset('storage/' . $buku->coverBuku->first()->file_image) }}"
                                alt="Cover Buku"
                                class="w-full h-[500px] object-cover rounded-lg ">
                        @endif
                    </div>

                    <!-- Right Column - Book Info -->
                    <div class="flex flex-col">
                        <div class="mb-6">
                            <h1 class="text-3xl font-bold mb-2">{{ $buku->judul_buku }}</h1>
                            <p class="text-gray-600">{{ $buku->penulis }}</p>
                            <p class="text-sm text-gray-500">Published by {{ $buku->penerbit }}</p>
                            <p class="text-sm text-black"> {{ $buku->tentang_penulis }}</p>

                            <hr class="border-t border-black my-4">

                        <!-- Stats -->
                        <div class="grid grid-cols-3 gap-4 mb-6">
                            <div class="text-center p-3 bg-gray-50 rounded-lg">
                                <span class="block text-sm text-gray-500">Reading Time</span>
                                <span class="block text-lg font-semibold">56 Min</span>
                            </div>
                            <div class="text-center p-3 bg-gray-50 rounded-lg">
                                <span class="block text-sm text-gray-500">Rating</span>
                                <span class="block text-lg font-semibold">{{ number_format($averageRating, 1) }}</span>
                            </div>
                            <div class="text-center p-3 bg-gray-50 rounded-lg">
                                <span class="block text-sm text-gray-500">Chapters</span>
                                <span class="block text-lg font-semibold">3</span>
                            </div>
                        </div>

                        <hr class="border-t border-black my-4">
                        <!-- Actions -->
                        <div class="flex gap-4 mb-6">
                            <button class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700">
                                Read & Play
                            </button>
                            <form
                            action="{{ in_array($buku->id_buku, $favorites) ? route('user.favorite.delete', $buku->id_buku) : route('user.favorite.store', $buku->id_buku) }}"
                            method="POST"
                            class="mt-2">
                            @csrf

                            @if(in_array($buku->id_buku, $favorites))
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600 w-full flex items-center justify-center gap-2">
                                    <i class="fas fa-trash-alt"></i> Hapus Favorite
                                </button>
                            @else
                                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 w-full flex items-center justify-center gap-2">
                                    <i class="far fa-heart"></i> Tambah ke Favorite
                                </button>
                            @endif
                        </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mx-8">
             <!-- Synopsis -->
            <div class="mb-6 mx-4">
                <h2 class="text-xl font-semibold mb-3">Synopsis of the Book</h2>
                <p class="text-gray-600">{{ $buku->sinopsis }}</p>
            </div>

            <!-- Audio Preview -->
            @if($buku->teaser_audio)
            <div class="w-full bg-gray-50 p-4 rounded-lg">
                <audio controls class="w-full">
                    <source src="{{ asset('storage/' . $buku->teaser_audio) }}" type="audio/mp3">
                </audio>
            </div>
            @endif


            <!-- Reviews Section -->
            @if($rating)
            <div class="mt-8  rounded-xl p-8">
                <h2 class="text-2xl font-semibold mb-6">Reviews</h2>
                <div class="space-y-6">
                    @foreach($rating as $review)
                    <div class="border-b border-gray-200 pb-6">
                        <div class="flex items-center mb-2">
                            <span class="font-semibold mr-2">{{ $review->user->name }}</span>
                            <span class="text-yellow-400">★</span>
                            <span class="ml-1">{{ $review->rating }}/5</span>
                        </div>
                        <p class="text-gray-600">{{ $review->komentar }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="mt-10 mx-8">
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
                        <h3 class="text-xl font-semibold mb-4">Berikan Rating untuk Buku Ini:</h3>
                        <form action="{{ route('user.rating.store', $buku->id_buku) }}" method="POST" class="bg-gray-50 p-6 rounded-lg">
                            @csrf
                            <div class="mb-4">
                                <label for="rating" class="block text-gray-700 font-bold mb-2">Rating (1-5):</label>
                                <select id="rating" name="rating" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="komentar" class="block text-gray-700 font-bold mb-2">Komentar:</label>
                                <textarea id="komentar" name="komentar" rows="3" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"></textarea>
                            </div>
                            <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600">
                                Submit Rating
                            </button>
                        </form>
                    @endif
                @else
                    <div class="bg-yellow-50 p-4 rounded-lg text-yellow-800">
                        Anda belum berlangganan. Silakan berlangganan untuk memberikan rating.
                    </div>
                @endif
            </div>

        </div>




    </div>
    @endsection
