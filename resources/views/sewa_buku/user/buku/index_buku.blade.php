@extends('sewa_buku.layouts.userApp')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold text-blue-900 mb-8 mt-16">Explore</h1>

    <!-- Last Pick Up Section -->
    <div class="mb-10">
        <h2 class="text-lg font-semibold mb-4">Last Pick Up</h2>
        <div class="bg-blue-50 rounded-lg p-4">
             <div class="flex items-center space-x-4">
                @if($terakhirDibaca && $terakhirDibaca->buku->coverBuku->first())
                    <img src="{{ asset('storage/' . $terakhirDibaca->buku->coverBuku->first()->file_image) }}"
                         alt="Last Book"
                         class="w-24 h-32 object-cover rounded-lg shadow">
                @endif
                <div>
                    <h3 class="font-medium">{{ $terakhirDibaca->buku->judul_buku ?? 'No book found' }}</h3>
                    <p class="text-gray-600">{{ $terakhirDibaca->buku->penulis ?? '' }}</p>
                    <!-- Audio Player -->
                    <div class="mt-4 bg-white rounded-full h-10 flex items-center px-4 w-64">
                        <div class="flex-1 bg-blue-500 h-1 rounded-full"></div>
                        <audio controls class="w-100">
                            <source src="{{ asset('storage/' . $terakhirDibaca->buku->ringkasan_audio) }}" type="audio/mpeg">
                            Browser Anda tidak mendukung pemutar audio.
                        </audio>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Book Recommendations -->
    <div class="mb-10">
        <h2 class="text-lg font-semibold mb-4">Book Recommendation</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-12 ">
            @foreach($buku as $book)
            <div class="bg-white rounded-lg overflow-hidden flex flex-col">
                @if($book->coverBuku && $book->coverBuku->first())
                    <a href="{{ route('user.buku.show', $book->id_buku) }}">
                        <img src="{{ asset('storage/' . $book->coverBuku->first()->file_image) }}"
                             alt="{{ $book->judul_buku }}"
                             class="w-full aspect-[9/16] object-cover rounded-xl">
                    </a>
                @endif
                <div class="p-3 flex-1 flex flex-col justify-between">
                    <h3 class="font-medium text-sm">{{ $book->judul_buku }}</h3>
                    <p class="text-gray-600 text-xs">{{ $book->penulis }}</p>
                    <!-- Duration and Rating -->
                    <div class="flex items-center justify-between mt-2 text-xs text-gray-500">
                        <span class="flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ floor($book->totalWaktu / 60) }} Min
                        </span>
                        <span class="flex items-center">
                            <svg class="w-3 h-3 mr-1 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            {{ number_format($book->ratingRerata, 1) }}
                        </span>
                    </div>
                </div>
            </div>

            @endforeach
        </div>
    </div>



    <div>
        @foreach ($parentTags as $parentTags)
            @php
                $colors = ['red', 'blue', 'green', 'yellow', 'orange', 'purple'];
            @endphp

            <h2 class="text-lg font-semibold mb-4">{{ $parentTags->nama_tags }}</h2>
            <div class="flex flex-wrap gap-4">
                @foreach ($parentTags->child as $item)
                    @php
                        $color = $colors[array_rand($colors)];
                    @endphp
                    <a href="#" class="px-2 py-2 bg-{{ $color }}-100 text-{{ $color }}-700 rounded-full">
                        {{ $item->nama_tags }}
                    </a>
                @endforeach
            </div>
        @endforeach
    </div>

</div>
@endsection
