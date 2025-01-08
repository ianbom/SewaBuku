@extends('sewa_buku.layouts.userApp')

@section('content')

    <head>
        <style>
            .custom-audio {
                background-color: white;
                color: #1E90FF !important;
                /* Warna teks bawaan */
            }

            .custom-audio::-webkit-media-controls-panel {
                background-color: white;
                /* Background panel transparan */
            }

            .custom-audio::-webkit-media-controls-play-button {
                background-color: white;
                /* Transparansi tombol play */
                color: #1E90FF !important;
                /* Warna tombol play */
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

            /* Tambahan untuk ikon titik tiga */
            .custom-audio::-webkit-media-controls {
                color: #1E90FF !important;
            }
        </style>

    </head>
    <div class="container mx-auto p-10">

        <!-- Header Section -->
        <div class="mb-4">
            <h1 class="text-[40px] font-bold text-left text-[#052D6E] mb-10" style="font-family: 'Libre Baskerville', serif;">
                Koleksi</h1>


            <!-- Last Pickup Section -->
            @if ($terakhirDibaca && $terakhirDibaca->buku->coverBuku->first())
                <h2 class="text-[18px] font-semibold mb-4 text-[#052D6E]" style="font-family: 'Inter', sans-serif;">Terakhir
                    di baca</h2>
                <div class="bg-[#D3E9FF] rounded-[16px] p-4 inline-block mb-10">
                    <div class="flex items-center space-x-4">
                        <img src="{{ asset('storage/' . $terakhirDibaca->buku->coverBuku->first()->file_image) }}"
                            alt="Last Book" class="w-32 h-280 object-cover rounded-[16px] ">
                        <div>
                            <p class="text-[#052D6E] font-bold mb-2 ">
                                {{ $terakhirDibaca->buku->judul_buku ?? 'No book found' }}</p>
                            <p class="text-sm text-[#979797] font-bold"> {{ $terakhirDibaca->buku->penulis ?? '' }}</p>

                            <!-- Audio Player -->
                            <div class="mt-4 bg-white rounded-[16px] h-16 flex items-center px-4 w-full">
                                <audio controls controlsList="nodownload" class="custom-audio">
                                    <source src="{{ asset('storage/' . $terakhirDibaca->buku->ringkasan_audio) }}"
                                        type="audio/mpeg">
                                    Browser Anda tidak mendukung pemutar audio.
                                </audio>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <img src="https://via.placeholder.com/150" alt="Last Book" class="rounded-[16px]">
            @endif
        </div>

        <!-- Saved -->
        <div class="mb-20">
            <div class="flex mt-6 mb-6 items-center">
                <div class="text-center bg-[#052D6E] p-2 rounded-[6px] mr-4 flex items-center justify-center">
                    <i class="fas fa-save text-white text-[18px]"></i>
                </div>
                <h2 class="text-[18px] font-semibold text-[#052D6E]" style="font-family: 'Inter', sans-serif;">Tersimpan
                </h2>

            </div>
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                @foreach ($buku as $book)
                    <div
                        class="bg-white rounded-[16px] overflow-hidden border-2 border-transparent hover:border-[#D3E9FF] transition-all">
                        <!-- Wrap the entire book card in a link to the book detail page -->
                        <a href="{{ route('user.buku.show', $book->id_buku) }}">
                            @if ($book->coverBuku && $book->coverBuku->first())
                                <img src="{{ asset('storage/' . $book->coverBuku->first()->file_image) }}" alt="Cover Buku"
                                    class="w-full h-128 object-cover rounded-[16px]">
                            @else
                                <img src="https://via.placeholder.com/150" alt="Cover Placeholder"
                                    class="w-full h-64 object-cover">
                            @endif
                        </a>

                        <div class="p-4">
                            <h3 class="text-[#052D6E] text-[14px] font-semibold mb-2"
                                style="font-family: 'Inter', sans-serif;">{{ $book->judul_buku }}</h3>
                            <p class="text-[#979797] font-medium text-[14px]" style="font-family: 'Inter', sans-serif;">
                                {{ $book->penulis }}</p>

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
                    </div>
                @endforeach
            </div>




            <!-- Finished -->
            <div class="mt-10">
                <div class="flex mt-6 mb-6 items-center">
                    <div class="text-center bg-[#052D6E] p-2 rounded-[6px] mr-4 flex items-center justify-center">
                        <i class="fas fa-check-circle text-white text-[18px]"></i>
                    </div>
                    <h2 class="text-[18px] font-semibold text-[#052D6E]" style="font-family: 'Inter', sans-serif;">Selesai
                    </h2>

                </div>
                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                    @foreach ($bukuDiselesaikan as $book)
                        <div
                            class="bg-white rounded-[16px] overflow-hidden border-2 border-transparent hover:border-[#D3E9FF] transition-all">
                            <!-- Wrap the entire book card in a link to the book detail page -->
                            <a href="{{ route('user.buku.show', $book->id_buku) }}">
                                @if ($book->coverBuku && $book->coverBuku->first())
                                    <img src="{{ asset('storage/' . $book->coverBuku->first()->file_image) }}"
                                        alt="Cover Buku" class="w-full h-128 object-cover rounded-[16px]">
                                @else
                                    <img src="https://via.placeholder.com/150" alt="Cover Placeholder"
                                        class="w-full h-64 object-cover">
                                @endif
                            </a>

                            <div class="p-4">
                                <h3 class="text-[#052D6E] text-[14px] font-semibold mb-2"
                                    style="font-family: 'Inter', sans-serif;">{{ $book->judul_buku }}</h3>
                                <p class="text-[#979797] font-medium text-[14px]" style="font-family: 'Inter', sans-serif;">
                                    {{ $book->penulis }}</p>

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
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endsection
