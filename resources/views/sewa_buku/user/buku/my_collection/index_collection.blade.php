@extends('sewa_buku.layouts.userApp')

@section('content')

<head>
    <style>
        .custom-audio {
            background-color: white;
            color: #1E90FF !important;
        }

        .custom-audio::-webkit-media-controls-panel {
            background-color: white;
        }

        .custom-audio::-webkit-media-controls-play-button {
            background-color: white;
            color: #1E90FF !important;
        }

        .custom-audio::-webkit-media-controls-timeline {
            color: #1E90FF !important;
        }

        .custom-audio::-webkit-media-controls-current-time-display,
        .custom-audio::-webkit-media-controls-time-remaining-display {
            color: #1E90FF !important;
        }

        .custom-audio::-webkit-media-controls-play-button,
        .custom-audio::-webkit-media-controls-pause-button,
        .custom-audio::-webkit-media-controls-mute-button,
        .custom-audio::-webkit-media-controls-timeline,
        .custom-audio::-webkit-media-controls-volume-slider-container,
        .custom-audio::-webkit-media-controls-current-time-display,
        .custom-audio::-webkit-media-controls-time-remaining-display,
        .custom-audio::-webkit-media-controls-button,
        .custom-audio::-webkit-media-controls-panel {
            color: #1E90FF !important;
        }

        .custom-audio::-webkit-media-controls {
            color: #1E90FF !important;
        }
    </style>

</head>
<div>
<div class="container mx-auto p-10">

    <!-- Header Section -->
    <div class="mb-4">
        <h1 class="text-[40px] font-bold text-left text-[#052D6E] mb-10" style="font-family: 'Libre Baskerville', serif;">
            Collection</h1>


        <!-- Last Read Section -->
        @if ($terakhirDibaca && $terakhirDibaca->buku && $terakhirDibaca->buku->coverBuku->first())
    <!-- Last Read Section -->
    <h2 class="text-[18px] font-semibold mb-4 text-[#052D6E]" style="font-family: 'Inter', sans-serif;">Progres</h2>
    <div class="bg-[#D3E9FF] rounded-[16px] p-4 inline-block mb-10">
        <div class="flex items-center space-x-4">
            <img src="{{ asset('storage/' . $terakhirDibaca->buku->coverBuku->first()->file_image) }}"
                alt="Last Book" class="w-32 h-280 object-cover rounded-[16px] ">
            <div>
                <p class="text-[#052D6E] font-bold mb-2 ">
                    {{ $terakhirDibaca->buku->judul_buku ?? 'No book found' }}</p>
                <p class="text-sm text-[#979797] font-bold"> {{ $terakhirDibaca->buku->penulis ?? '' }}</p>

                <!-- Audio Player -->
                @if ($terakhirDibaca->buku->ringkasan_audio)
                    <div class="mt-4 bg-white rounded-[16px] h-16 flex items-center px-4 w-full">
                        <audio controls controlsList="nodownload" class="custom-audio">
                            <source src="{{ asset('storage/' . $terakhirDibaca->buku->ringkasan_audio) }}"
                                type="audio/mpeg">
                            Your browser does not support the audio player.
                        </audio>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endif

    </div>

   <!-- Saved -->
<div class="mb-20">
    <!-- Header -->
    <div class="flex items-center justify-between mt-6 mb-6">
        <div class="flex items-center">
            <div class="text-center bg-[#052D6E] p-2 rounded-[6px] mr-4 flex items-center justify-center">
                <i class="fas fa-save text-white text-[18px]"></i>
            </div>
            <h2 class="text-[18px] font-semibold text-[#052D6E]">Saved</h2>
        </div>

        @if ($buku->count() > 5)
            <button id="toggle-saved-books" class="text-[#1E90FF] font-semibold text-[16px] cursor-pointer">See All</button>
        @endif
    </div>

    @if ($buku->isEmpty())
        <p class="text-start text-[#979797] text-[16px]">Belum menambahkan buku</p>
    @else
        <div id="saved-books" class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
            @foreach ($buku as $index => $book)
                <div class="book-item bg-white rounded-[16px] overflow-hidden border-2 border-transparent hover:border-[#D3E9FF] transition-all {{ $index >= 5 ? 'hidden' : '' }}">
                    <a href="{{ route('user.buku.show', $book->id_buku) }}">
                        @if ($book->coverBuku && $book->coverBuku->first())
                            <img src="{{ asset('storage/' . $book->coverBuku->first()->file_image) }}" alt="Book Cover" class="w-full aspect-[1/1] object-cover rounded-[16px]">
                        @else
                            <img src="https://via.placeholder.com/150" alt="Cover Placeholder" class="w-full h-64 object-cover">
                        @endif
                    </a>
                    <div class="p-4">
                        <h3 class="text-[#052D6E] text-[14px] font-semibold mb-2">{{ $book->judul_buku }}</h3>
                        <p class="text-[#979797] font-medium text-[14px]">{{ $book->penulis }}</p>

                    </div>
                    <div class="flex justify-between items-center text-[#979797] text-sm mt-4">
                        <div class="flex items-center">
                            <i class="fa fa-clock mr-2 p-2 rounded-[8px] text-[12px]"
                                style="background-color: #D3E9FF; color: #1E90FF;"></i>
                            <span class="font-inter font-medium text-[12px]"
                                style="color: #979797; font-family: 'Inter', sans-serif;">{{ floor($book->totalWaktu / 60) }}
                                Min</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-star mr-2 p-2 rounded-[8px] text-[12px]"
                                style="background-color: #FAFAD8; color: #B79F54; "></i>
                            <span class="font-inter font-medium text-[12px]"
                                style="color: #979797;font-family: 'Inter', sans-serif;">{{ number_format($book->ratingRerata, 1) }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggleSavedBooks = document.getElementById("toggle-saved-books");
        if (toggleSavedBooks) {
            const savedBooks = document.querySelectorAll("#saved-books .book-item");

            toggleSavedBooks.addEventListener("click", function () {
                const isExpanded = toggleSavedBooks.textContent === "See Less";

                savedBooks.forEach((book, index) => {
                    if (index >= 5) {
                        book.classList.toggle("hidden", isExpanded);
                    }
                });

                toggleSavedBooks.textContent = isExpanded ? "See All" : "See Less";
            });
        }
    });
</script>

<!-- Finished -->
<div class="mt-10">
    <div class="flex items-center justify-between mt-6 mb-6">
        <div class="flex items-center">
            <div class="text-center bg-[#052D6E] p-2 rounded-[6px] mr-4 flex items-center justify-center">
                <i class="fas fa-check-circle text-white text-[18px]"></i>
            </div>
            <h2 class="text-[18px] font-semibold text-[#052D6E]">Finished</h2>
        </div>

        @if ($bukuDiselesaikan->count() > 5)
            <button id="toggle-finished-books" class="text-[#1E90FF] font-semibold text-[16px] cursor-pointer">See All</button>
        @endif
    </div>

    @if ($bukuDiselesaikan->isEmpty())
        <p class="text-start text-[#979797] text-[16px]">Belum menyelesaikan buku</p>
    @else
        <div id="finished-books" class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
            @foreach ($bukuDiselesaikan as $index => $book)
                <div class="book-item bg-white rounded-[16px] overflow-hidden border-2 border-transparent hover:border-[#D3E9FF] transition-all {{ $index >= 5 ? 'hidden' : '' }}">
                    <a href="{{ route('user.buku.show', $book->id_buku) }}">
                        @if ($book->coverBuku && $book->coverBuku->first())
                            <img src="{{ asset('storage/' . $book->coverBuku->first()->file_image) }}" alt="Book Cover" class="w-full aspect-[1/1] object-cover rounded-[16px]">
                        @else
                            <img src="https://via.placeholder.com/150" alt="Cover Placeholder" class="w-full h-64 object-cover">
                        @endif
                    </a>
                    <div class="p-4">
                        <h3 class="text-[#052D6E] text-[14px] font-semibold mb-2">{{ $book->judul_buku }}</h3>
                        <p class="text-[#979797] font-medium text-[14px]">{{ $book->penulis }}</p>
                    </div>
                    <div class="flex justify-between items-center text-[#979797] text-sm mt-4">
                        <div class="flex items-center">
                            <i class="fa fa-clock mr-2 p-2 rounded-[8px] text-[12px]"
                                style="background-color: #D3E9FF; color: #1E90FF;"></i>
                            <span class="font-inter font-medium text-[12px]"
                                style="color: #979797; font-family: 'Inter', sans-serif;">{{ floor($book->totalWaktu / 60) }}
                                Min</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-star mr-2 p-2 rounded-[8px] text-[12px]"
                                style="background-color: #FAFAD8; color: #B79F54; "></i>
                            <span class="font-inter font-medium text-[12px]"
                                style="color: #979797;font-family: 'Inter', sans-serif;">{{ number_format($book->ratingRerata, 1) }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggleFinishedBooks = document.getElementById("toggle-finished-books");
        if (toggleFinishedBooks) {
            const finishedBooks = document.querySelectorAll("#finished-books .book-item");

            toggleFinishedBooks.addEventListener("click", function () {
                const isExpanded = toggleFinishedBooks.textContent === "See Less";

                finishedBooks.forEach((book, index) => {
                    if (index >= 5) {
                        book.classList.toggle("hidden", isExpanded);
                    }
                });

                toggleFinishedBooks.textContent = isExpanded ? "See All" : "See Less";
            });
        }
    });
</script>


    </div>

    <footer class="bg-[#1E90FF] text-white pt-12 pb-12 mt-20">
        <div class="max-w-6xl mx-auto px-6">
            <div class="flex flex-col sm:flex-row justify-between items-center text-center sm:text-left">
                <!-- Deskripsi Website -->
                <div class="max-w-xs sm:max-w-sm">
                    <p class="font-semibold text-lg" style="font-family: 'Inter', sans-serif;">Shae Insight</p>
                    <p class="text-sm mt-2" style="font-family: 'Inter', sans-serif;">
                        Empowering your personal growth with insights that drive lasting change and deepen understanding in just 1 minute.
                    </p>
                </div>

                <!-- Copyright (Dipusatkan di antara dua elemen lainnya) -->
                <div class="flex-grow flex justify-center">
                    <h4 class="font-semibold text-white mb-3" style="font-family: 'Inter', sans-serif;">
                        &copy; 2025 Shae Insight. All Rights Reserved.
                    </h4>
                </div>

                <!-- Social Media Links -->
                <div>
                    <h4 class="font-semibold text-white mb-3" style="font-family: 'Inter', sans-serif;">Follow Us</h4>
                    <ul class="flex space-x-6 justify-center sm:justify-start">
                        <li>
                            <a href="https://facebook.com" target="_blank" class="hover:text-[#052D6E]">
                                <i class="fab fa-facebook-f text-2xl"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://twitter.com" target="_blank" class="hover:text-[#052D6E]">
                                <i class="fab fa-twitter text-2xl"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://linkedin.com" target="_blank" class="hover:text-[#052D6E]">
                                <i class="fab fa-linkedin-in text-2xl"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://instagram.com" target="_blank" class="hover:text-[#052D6E]">
                                <i class="fab fa-instagram text-2xl"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

</div>
@endsection
