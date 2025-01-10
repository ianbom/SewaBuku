@extends('sewa_buku.layouts.userApp')

@section('title')
    {{ $buku->judul_buku }}
@endsection

@section('content')

    <style>
        .star {
            font-size: 3rem;
            transition: color 0.3s ease, transform 0.3s ease;
            padding: 5px;
            background-color: rgba(255, 255, 255, 0.7);
        }

        .star:hover {
            color: #052D6E;
            transform: scale(1.2);
        }

        .active {
            color: #052D6E !important;
        }

        .custom-audio {
            background-color: #D3E9FF;
            border-radius: 16px;
            color: #1E90FF !important;
        }

        .custom-audio::-webkit-media-controls-panel {
            background-color: #D3E9FF;
        }

        .custom-audio::-webkit-media-controls-play-button {
            background-color: white;
            border-radius: 50px;
            color: #1E90FF !important;
        }

        .custom-audio::-webkit-media-controls-timeline {
            color: #1E90FF !important;
        }

        .custom-audio::-webkit-media-controls-current-time-display,
        .custom-audio::-webkit-media-controls-time-remaining-display {
            color: #1E90FF !important;
        }

        .bg-[#F1F8FF] {
            background-color: #F1F8FF !important;
        }

        .border-[#A3D8FF] {
            border-color: #A3D8FF !important;
        }
    </style>

    <div class="container mx-auto mt-10 p-10">
        <div class="max-w-full">
            <div class="grid grid-cols-12 gap-12">
                <!-- Left Column - Image -->
                <div class="col-span-12 sm:col-span-3">
                    @if ($buku->coverBuku && $buku->coverBuku->count() > 0)
                        <img src="{{ asset('storage/' . $buku->coverBuku->first()->file_image) }}" alt="Book Cover"
                            class="w-full h-[300px] object-cover rounded-[16px]">
                    @endif
                </div>

                <!-- Right Column - Book Info -->
                <div class="col-span-12 sm:col-span-9">
                    <div class="flex flex-col">
                        <div class="mb-6">
                            <h2 class="text-[28px] font-bold text-[#052D6E] mb-3" style="font-family: 'Libre Baskerville', serif;">
                                {{ $buku->judul_buku }}
                            </h2>
                            <p class="text-[#052D6E] font-bold mb-2">AUTHOR - {{ $buku->penulis }} / PUBLISHER - {{ $buku->penerbit }}</p>
                            <p class="text-sm text-[#979797] font-bold">{{ $buku->tentang_penulis }}</p>
                        </div>
                        <hr class="w-full border-t border-[#052D6E]">

                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-6">
                            <div class="flex mt-6 items-center">
                                <div class="text-center bg-[#D3E9FF] p-2 rounded-[6px] mr-2 flex items-center justify-center">
                                    <i class="fas fa-clock text-[#1E90FF] text-[12px]"></i>
                                </div>
                                <span class="text-[12px] text-[#979797] font-bold">{{ floor($buku->totalWaktu / 60) }} Minutes</span>
                            </div>

                            <div class="flex mt-6 items-center">
                                <div class="text-center bg-[#FAFAD8] p-2 rounded-[6px] mr-2 flex items-center justify-center">
                                    <i class="fas fa-star text-[#B79F54] text-[12px]"></i>
                                </div>
                                <span class="text-[12px] text-sm text-[#979797] font-bold">{{ number_format($averageRating, 1) }}</span>
                            </div>

                            <div class="flex mt-6 items-center">
                                <div class="text-center bg-[#FFE8E2] p-2 rounded-[6px] mr-2 flex items-center justify-center">
                                    <i class="fas fa-book text-[#DD7971] text-[12px]"></i>
                                </div>
                                <span class="text-[12px] text-sm text-[#979797] font-bold">{{ $buku->jumlahChapter }} Types</span>
                            </div>

                            <div class="flex mt-6 items-center">
                                <div class="text-center bg-[#EBE4FF] p-2 rounded-[6px] mr-2 flex items-center justify-center">
                                    <i class="fas fa-question-circle text-[#8F7CC1] text-[12px]"></i>
                                </div>
                                <span class="text-[12px] text-[#979797] font-bold">{{ $jumlahQuiz }} Chapters</span>
                            </div>
                        </div>

                        <hr class="border-t border-[#052D6E]">
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-4 mb-6">
                        @if ($buku->is_free || $checkLanggananAktif)
                            <div class="flex justify-end mt-6">
                                <a href="{{ $buku->detailBuku?->first() ? route('user.buku.bacaBab', $buku->detailBuku?->first()?->id_detail_buku) : '#empty-bab' }}"
                                    type="submit"
                                    class="flex items-center gap-2 px-4 py-3 text-white bg-[#052D6E] rounded-[12px] hover:bg-[#AFC4E7FF] hover:text-[#052D6E]">
                                    <strong>Read Book</strong>
                                </a>
                            </div>

                            <div class="flex justify-end mt-6">
                                <button type="button" onclick="toggleModal('ratingModal')"
                                    class="flex items-center gap-2 px-4 py-3 text-white bg-[#B79F54] rounded-[12px] hover:bg-[#FAFAD8] hover:text-[#B79F54]">
                                    <i class="fas fa-pen"></i>
                                    <strong>Give Review</strong>
                                </button>
                            </div>
                        @else
                            <div class="flex justify-end mt-6">
                                <a href="#" type="submit"
                                    class="flex items-center gap-2 px-4 py-3 text-white bg-[#052D6E] rounded-[12px] disabled">
                                    <strong>Subscribe to Read</strong>
                                </a>
                            </div>
                        @endif

                        @if ($diselesaikanCheck)
                            <form action="{{ route('user.delete.bookFinished', $buku->id_buku) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="flex justify-end mt-6">
                                    <button type="submit"
                                        class="flex items-center gap-2 px-4 py-3 text-white bg-[#1E90FF] rounded-[12px] hover:bg-[#D3E9FF] hover:text-[#1E90FF]">
                                        <i class="fas fa-trash-alt"></i>
                                        <strong>Remove Finished Mark</strong>
                                    </button>
                                </div>
                            </form>
                        @else
                            <form action="{{ route('user.mark.bookFinished', $buku->id_buku) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="flex mt-6 items-center gap-2 px-4 py-3 text-white bg-[#1E90FF] rounded-[12px] hover:bg-[#D3E9FF] hover:text-[#1E90FF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <strong>Mark as Finished</strong>
                                </button>
                            </form>
                        @endif

                        <form action="{{ in_array($buku->id_buku, $favorites) ? route('user.favorite.delete', $buku->id_buku) : route('user.favorite.store', $buku->id_buku) }}" method="POST" class="mt-2">
                            @csrf

                            @if (in_array($buku->id_buku, $favorites))
                                @method('DELETE')
                                <button type="submit"
                                    class="flex mt-4 items-center gap-2 px-4 py-3 text-white bg-[#DD7971] rounded-[12px] hover:bg-[#FFE8E2] hover:text-[#DD7971]">
                                    <i class="fas fa-trash-alt"></i> <strong> Remove from Favorites </strong>
                                </button>
                            @else
                                <button type="submit"
                                    class="flex mt-4 items-center gap-2 px-4 py-3 text-white bg-[#DD7971] rounded-[12px] hover:bg-[#FFE8E2] hover:text-[#DD7971]">
                                    <i class="far fa-heart"></i> <strong> Add to Favorites </strong>
                                </button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-12">
            <div class="mb-10">
                <p class="text-[18px] text-[#052D6E] font-bold mb-2">Book Synopsis</p>
                <p class="text-[#979797] leading-relaxed">{{ $buku->sinopsis }}</p>
            </div>

            @if ($buku->teaser_audio)
                <div class="mt-8 mb-8">
                    <audio controls controlsList="nodownload" class="custom-audio w-full">
                        <source src="{{ asset('storage/' . $buku->teaser_audio) }}" type="audio/mp3">
                    </audio>
                </div>
            @endif

            <!-- Reviews Section -->
            @if ($rating)
                <div class="mt-8 rounded-xl">
                    <p class="text-[18px] text-[#052D6E] font-bold mb-4">Reviews</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($rating as $review)
                            <div class="border p-4 rounded-lg
                                @if (auth()->check() && $review->id == auth()->id()) bg-[#F1F8FF] border-[#A3D8FF] @else bg-white border-[#D3E9FF] @endif">
                                <div class="flex items-center mb-2">
                                    <span class="font-semibold text-[#1E90FF] text-sm mr-2">{{ $review->user->name }}</span>
                                    <span class="text-[#B79F54] ml-2">★</span>
                                    <span class="text-sm text-[#979797] ml-1">{{ $review->rating }}/5</span>
                                </div>
                                <p class="text-[#979797] text-sm">{{ $review->komentar }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Rating Section -->
            <div class="mt-10">
                @if ($checkLanggananAktif)
                    <div id="ratingModal"
                        class="hidden fixed top-0 left-0 z-50 w-full h-full flex items-center justify-center bg-black bg-opacity-50">
                        <div class="bg-white p-8 rounded-lg w-full max-w-md">
                            @if ($ratingCheck)
                                <h3 class="text-[16px] font-bold text-[#052D6E] mb-4">Warning</h3>
                                <p class="text-[#979797] mb-6 text-[14px]">You have already rated this book. Thank you for your participation!</p>
                                <div class="flex justify-end">
                                    <button onclick="toggleModal('ratingModal')"
                                        class="px-4 py-2 bg-[#1E90FF] text-bold text-white rounded-[12px] hover:bg-[#D3E9FF] hover:text-[#1E90FF]">
                                        <strong>OK</strong>
                                    </button>
                                </div>
                            @else
                                <h3 class="text-[16px] font-bold text-[#052D6E] mb-4">Give a Rating for This Book</h3>
                                <form action="{{ route('user.rating.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="buku_id" value="{{ $buku->id_buku }}">

                                    <div class="flex gap-3 mb-6">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <label for="star{{ $i }}">
                                                <i class="star fa fa-star text-[#B79F54]" data-value="{{ $i }}"></i>
                                            </label>
                                        @endfor
                                    </div>

                                    <div class="flex justify-between">
                                        <button type="button" onclick="toggleModal('ratingModal')"
                                            class="px-4 py-2 bg-[#D3E9FF] text-[#052D6E] rounded-[12px] hover:bg-[#AFC4E7FF] hover:text-[#1E90FF]">
                                            Cancel
                                        </button>
                                        <button type="submit"
                                            class="px-4 py-2 bg-[#1E90FF] text-bold text-white rounded-[12px] hover:bg-[#D3E9FF] hover:text-[#1E90FF]">
                                            Submit Rating
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function toggleModal(id) {
            const modal = document.getElementById(id);
            modal.classList.toggle('hidden');
        }

        const stars = document.querySelectorAll('.star');
        stars.forEach(star => {
            star.addEventListener('click', () => {
                const value = star.getAttribute('data-value');
                stars.forEach(s => {
                    s.classList.remove('active');
                    if (s.getAttribute('data-value') <= value) {
                        s.classList.add('active');
                    }
                });
            });
        });
    </script>
@endsection
