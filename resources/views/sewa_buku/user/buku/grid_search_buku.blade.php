@forelse($buku as $book)
    <div class="bg-white rounded-lg overflow-hidden flex flex-col">
        @if($book->coverBuku && $book->coverBuku->first())
            <img src="{{ asset('storage/' . $book->coverBuku->first()->file_image) }}"
                 alt="{{ $book->judul_buku }}"
                 class="w-full aspect-[9/16] object-cover rounded-xl">
        @endif
        <div class="p-3 flex-1 flex flex-col justify-between">
            <h3 class="font-medium text-sm">{{ $book->judul_buku }}</h3>
            <p class="text-gray-600 text-xs">{{ $book->penulis }}</p>
            <div class="flex items-center justify-between mt-2 text-xs text-gray-500">
                <span class="flex items-center">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    56 Min
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
    @empty
    <h1>Anjay kosong</h1>
@endforelse

