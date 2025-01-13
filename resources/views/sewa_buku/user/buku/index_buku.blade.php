@extends('sewa_buku.layouts.userApp')

@section('content')

    <head>
        <style>
            .custom-audio {
                background-color: white;
                color: #1E90FF !important;
                /* Default text color */
            }

            .custom-audio::-webkit-media-controls-panel {
                background-color: white;
                /* Transparent background panel */
            }

            .custom-audio::-webkit-media-controls-play-button {
                background-color: white;
                /* Transparent play button */
                color: #1E90FF !important;
                /* Play button color */
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

            /* Additional for the three-dot icon */
            .custom-audio::-webkit-media-controls {
                color: #1E90FF !important;
            }
        </style>
    </head>
    <div class="container mx-auto sm:p-10 p-12 px-6">
        <!-- Header Section -->
        <div class="mb-4">
            <h1 class="text-[40px] font-bold text-left text-[#052D6E] sm:mb-10 mt-10"
                style="font-family: 'Libre Baskerville', serif;">
                Explore</h1>

            <!-- Last Pickup Section -->
            @if ($terakhirDibaca && $terakhirDibaca->buku->coverBuku->first())
                <h2 class="text-[18px] font-semibold mb-4 text-[#052D6E]" style="font-family: 'Inter', sans-serif;">Last read
                </h2>
                <div class="bg-transparent sm:bg-[#D3E9FF] rounded-[16px] p-4 inline-block mb-10">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4">
                        <img src="{{ asset('storage/' . $terakhirDibaca->buku->coverBuku->first()->file_image) }}"
                            alt="Last Book" class="w-32 h-48 sm:w-48 sm:h-72 object-cover rounded-[16px] mb-4 sm:mb-0">

                        <div class="sm:w-80">
                            <p class="text-[#052D6E] font-bold mb-2 ">
                                {{ $terakhirDibaca->buku->judul_buku ?? 'No book found' }}</p>
                            <p class="text-sm text-[#979797] font-bold"> {{ $terakhirDibaca->buku->penulis ?? '' }}</p>

                            <!-- Audio Player -->
                            <div class="mt-4 bg-white rounded-[16px] h-16 flex items-center px-4 w-full">
                                @if ($terakhirDibaca && $terakhirDibaca->buku->ringkasan_audio)
                                    <audio controls controlsList="nodownload" class="custom-audio">
                                        <source src="{{ asset('storage/' . $terakhirDibaca->buku->ringkasan_audio) }}"
                                            type="audio/mpeg">
                                        Your browser does not support the audio player.
                                    </audio>
                                @else
                                    <p class="text-sm text-[#979797] font-bold">No audio available</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <img src="https://via.placeholder.com/150" alt="Last Book" class="rounded-[16px]">
            @endif
        </div>

        <div class="mb-6 mt-10">
            <h2 class="text-[18px] font-semibold text-[#052D6E] mb-4" style="font-family: 'Inter', sans-serif;">Recommended
                books</h2>

            <!-- Scrollable container for horizontal scrolling -->
            <div class="overflow-x-auto">
                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                    @foreach ($buku as $book)
                        <div
                            class="bg-white rounded-[16px] overflow-hidden border-2 border-transparent hover:border-[#D3E9FF] transition-all">
                            <a href="{{ route('user.buku.show', $book->id_buku) }}">
                                @if ($book->coverBuku && $book->coverBuku->first())
                                    <img src="{{ asset('storage/' . $book->coverBuku->first()->file_image) }}"
                                        alt="Book Cover" class="w-full h-128 object-cover rounded-[16px]">
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
                                            style="background-color: #FAFAD8; color: #B79F54;"></i>
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
        @php
            $colorPairs = [
                ['bg' => '#EBE4FF', 'text' => '#8F7CC1'],
                ['bg' => '#D2FEED', 'text' => '#4DAF84'],
                ['bg' => '#FDECE4', 'text' => '#DD7971'],
                ['bg' => '#B5E8ED', 'text' => '#4398AD'],
                ['bg' => '#FFF7F5', 'text' => '#D59A5E'],
                ['bg' => '#FAFAD8', 'text' => '#B79F54'],
            ];

        @endphp
        @foreach ($parentTags as $parentTags)
            <h2 class="text-[18px] font-semibold mb-4 mt-6 text-[#052D6E]" style="font-family: 'Inter', sans-serif;">
                {{ $parentTags->nama_tags }}</h2>
            <div class="flex flex-wrap gap-4">
                @foreach ($parentTags->child as $index => $item)
                    @php
                        $color = $colorPairs[$index % count($colorPairs)];
                    @endphp
                    <a href="#" class="px-8 py-3 rounded-[16px]"
                        style="background-color: {{ $color['bg'] }}; color: {{ $color['text'] }};">
                        <strong> {{ $item->nama_tags }} </strong>
                    </a>
                @endforeach
            </div>
        @endforeach
    </div>


@endsection
