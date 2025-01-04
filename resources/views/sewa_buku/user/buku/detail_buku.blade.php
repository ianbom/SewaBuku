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
            color: #052D6E; /* Hover color */
            transform: scale(1.2); /* Slightly enlarge on hover for a fun effect */
        }

        .active {
            color: #052D6E !important; /* Active rating color */
        }
        .custom-audio {
            background-color: #D3E9FF;
            border-radius: 16px;
            color: #1E90FF  !important; /* Warna teks bawaan */
        }
        .custom-audio::-webkit-media-controls-panel {
            background-color: #D3E9FF; /* Background panel transparan */
        }
        .custom-audio::-webkit-media-controls-play-button {
            background-color: white;
            border-radius: 50px;
            color: #1E90FF  !important; /* Warna tombol play */
        }
        .custom-audio::-webkit-media-controls-timeline {
            color: #1E90FF  !important;
        }
        .custom-audio::-webkit-media-controls-current-time-display,
        .custom-audio::-webkit-media-controls-time-remaining-display {
            color: #1E90FF  !important;
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
            color: #1E90FF  !important;
        }

        /* Tambahan untuk ikon titik tiga */
        .custom-audio::-webkit-media-controls {
            color: #1E90FF  !important;
        }
        .bg-[#F1F8FF] {
            background-color: #F1F8FF !important;
        }

        .border-[#A3D8FF] {
            border-color: #A3D8FF !important;
        }
    </style>
    <div class="container mx-auto mt-10 p-10">
        <!-- Main Content -->
        <div class=" max-w">
            <div class="grid grid-cols-12 gap-12">
                <!-- Left Column - Image -->
                <div class="col-span-3">
                    @if($buku->coverBuku && $buku->coverBuku->count() > 0)
                    <img src="{{ asset('storage/' . $buku->coverBuku->first()->file_image) }}"
                    alt="Cover Buku"
                    class="w-full h-[300px] object-cover rounded-[16px] ">
                    @endif
                </div>

                <!-- Right Column - Book Info -->
                <div class="col-span-9">
                    <div class="flex flex-col">
                        <div class="mb-6">
                            <h2 class="text-[28px] font-bold text-[#052D6E] mb-3 " style="font-family: 'Libre Baskerville', serif;">{{ $buku->judul_buku }}</h2>
                            <p class="text-[#052D6E] font-bold mb-2 ">AUTHOR - {{ $buku->penulis }} / PUBLISHER - {{ $buku->penerbit }}</p>
                            <p class="text-sm text-[#979797] font-bold"> {{ $buku->tentang_penulis }}</p>
                        </div>
                        <hr class="w-full border-t border-[#052D6E] ">

                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-6">
                            <div class="flex mt-6 items-center">
                                <div class="text-center  bg-[#D3E9FF] p-2 rounded-[6px] mr-2 flex items-center justify-center">
                                    <i class="fas fa-clock text-[#1E90FF] text-[12px]"></i>
                                </div>
                                <span class="text-[12px] text-[#979797] font-bold">{{ floor($buku->totalWaktu / 60) }} Menit</span>
                            </div>


                            <div class="flex mt-6 items-center">
                                <div class="text-center  bg-[#FAFAD8] p-2 rounded-[6px] mr-2 flex items-center justify-center">
                                    <i class="fas fa-star text-[#B79F54] text-[12px]"></i>
                                </div>
                                <span class="text-[12px] text-sm text-[#979797] font-bold">{{ number_format($averageRating, 1) }} </span>
                            </div>

                            <div class="flex mt-6 items-center">
                                <div class="text-center bg-[#FFE8E2] p-2 rounded-[6px] mr-2 flex items-center justify-center">
                                    <i class="fas fa-book text-[#DD7971] text-[12px]"></i>
                                </div>
                                <span class="text-[12px] text-sm text-[#979797] font-bold">{{ $buku->jumlahChapter }} Tipe</span>
                            </div>

                            <div class="flex  mt-6 items-center">
                                <div class="text-center  bg-[#EBE4FF] p-2 rounded-[6px] mr-2 flex items-center justify-center">
                                    <i class="fas fa-question-circle text-[#8F7CC1] text-[12px]"></i>
                                </div>
                                <span class="text-[12px] text-[#979797] font-bold">{{ $jumlahQuiz }} Bab</span>
                            </div>

                        </div>                        <hr class="border-t border-[#052D6E] ">


                    </div>

                    <!-- Actions -->
                    <div class="flex gap-4 mb-6">

                        @if ($buku->is_free || $checkLanggananAktif)

                        <div class="flex justify-end mt-6">
                            <a href="{{ route('user.buku.bacaBab', $buku->detailBuku->first()->id_detail_buku) }}"
                                type="submit"
                                class="flex items-center gap-2 px-4 py-3 text-white bg-[#052D6E] rounded-[12px] hover:bg-[#AFC4E7FF] hover:text-[#052D6E]">
                                <strong>Baca Buku</strong>
                            </a>
                        </div>
                        @else
                        <div class="flex justify-end mt-6">
                            <a href="{{ route('user.buku.bacaBab', $buku->detailBuku->first()->id_detail_buku) }}"
                                type="submit"
                                class="flex items-center gap-2 px-4 py-3 text-white bg-[#052D6E] rounded-[12px] hover:bg-[#AFC4E7FF] hover:text-[#052D6E]">
                                <strong>Langganan untuk membaca</strong>
                            </a>
                        </div>
                        @endif

                        @if ($diselesaikanCheck)
                        <form action="{{ route('user.delete.bookFinished', $buku->id_buku) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="flex justify-end mt-6">
                                <button
                                type="submit"
                                class="flex items-center gap-2 px-4 py-3 text-white bg-[#1E90FF] rounded-[12px] hover:bg-[#D3E9FF] hover:text-[#1E90FF]">
                                <i class="fas fa-trash-alt"></i>
                                <strong>Hapus Tanda Selesai</strong>
                            </button>
                        </div>

                    </form>
                    @else
                    <form action="{{ route('user.mark.bookFinished', $buku->id_buku) }}" method="POST">
                        @csrf
                        <button
                        type="submit"
                        class="flex mt-6 items-center gap-2 px-4 py-3 text-white bg-[#1E90FF] rounded-[12px] hover:bg-[#D3E9FF] hover:text-[#1E90FF]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <strong>Tandai Selesai</strong>
                    </button>
                </form>
                @endif

                <form
                action="{{ in_array($buku->id_buku, $favorites) ? route('user.favorite.delete', $buku->id_buku) : route('user.favorite.store', $buku->id_buku) }}"
                method="POST"
                class="mt-2">
                @csrf

                @if(in_array($buku->id_buku, $favorites))
                @method('DELETE')
                <button type="submit" class="flex mt-4 items-center gap-2 px-4 py-3 text-white bg-[#DD7971] rounded-[12px] hover:bg-[#FFE8E2] hover:text-[#DD7971]">
                    <i class="fas fa-trash-alt"></i> <strong> Hapus Favorite </strong>
                </button>
                @else
                <button type="submit" class="flex mt-4 items-center gap-2 px-4 py-3 text-white bg-[#DD7971] rounded-[12px] hover:bg-[#FFE8E2] hover:text-[#DD7971]">
                    <i class="far fa-heart"></i> <strong> Tambah ke Favorite </strong>
                </button>
                @endif
            </form>

            <div class="flex justify-end mt-6">
                <button
                type="button"
                onclick="toggleModal('ratingModal')"
                class="flex items-center gap-2 px-4 py-3 text-white bg-[#B79F54] rounded-[12px] hover:bg-[#FAFAD8] hover:text-[#B79F54]">
                <i class="fas fa-pen"></i>
                <strong>Beri Ulasan</strong>
            </button>
        </div>


    </div>
</div>
</div>
</div>

<div class="mt-12">
    <!-- Synopsis -->
    <div class="mb-10 ">
        <p class="text-[18px] text-[#052D6E] font-bold mb-2 ">Sinopsis Buku</p>
        <p class=" text-[#979797] leading-relaxed"> {{ $buku->sinopsis }}</p>
    </div>


    <!-- Audio Preview -->
    @if($buku->teaser_audio)
    <div class="mt-8 mb-8">

        <audio controls controlsList="nodownload" class="custom-audio w-full">
            <source src="{{ asset('storage/' . $buku->teaser_audio) }}" type="audio/mp3">
            </audio>
        </div>
        @endif

        {{-- Highlight --}}
        <div class="mt-10">
            <p class="text-[18px] text-[#052D6E] font-bold mb-4 ">Highlight</p>
            @forelse ($highlight as $index => $item)
            <div class="flex items-center justify-between p-4 rounded-[16px] mb-4 {{ $index % 2 === 0 ? 'bg-[#D3E9FF] text-[#1E90FF]' : 'bg-[#EBE4FF] text-[#8F7CC1]' }}">
                <h3 class="flex-1 text-sm font-semibold text-inherit">{{ $item->highlight }}</h3>
                <!-- Div Ikon -->
                <div onclick="copyToClipboard('{{ $item->highlight }}')"  class="text-center {{ $index % 2 === 0 ? 'bg-[#1E90FF]' : 'bg-[#8F7CC1]' }} p-2 rounded-[6px] flex items-center justify-center">
                    <i class="fas fa-copy text-white text-[12px]"></i>
                </div>
            </div>
            @empty
            <p class="text-[#E46B61]">Anda tidak memiliki highlight</p>
            @endforelse
        </div>

        <script>
            function copyToClipboard(text) {
                navigator.clipboard.writeText(text).then(() => {
                    alert('Highlight berhasil disalin!');
                }).catch(err => {
                    console.error('Error copying text: ', err);
                });
            }
        </script>

        <!-- Reviews Section -->
        @if($rating)
        <div class="mt-8 rounded-xl">
            <p class="text-[18px] text-[#052D6E] font-bold mb-4">Ulasan</p>
            <!-- Grid container with 2 columns -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($rating as $review)
                <div
                class="border p-4 rounded-lg
            @if(auth()->check() && $review->id == auth()->id()) bg-[#F1F8FF] border-[#A3D8FF] @else bg-white border-[#D3E9FF] @endif">
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

    <!-- add ratting section  -->
    <div class="mt-10">
        @if ($checkLanggananAktif)


        <div id="ratingModal" class="hidden fixed top-0 left-0 z-50 w-full h-full flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-8 rounded-lg w-full max-w-md">
                @if ($ratingCheck)
                <h3 class="text-[16px] font-bold text-[#052D6E] mb-4" style="font-family: 'Inter', sans-serif;">Peringatan</h3>
                <p class="text-[#979797] mb-6 text-[14px]" style="font-family: 'Inter', sans-serif;">Anda sudah memberikan rating untuk buku ini. Terima kasih atas partisipasi Anda!</p>
                <div class="flex justify-end">
                    <button onclick= "toggleModal('ratingModal')"  class="px-4 py-2 bg-[#1E90FF] text-bold text-white rounded-[12px] hover:bg-[#D3E9FF] hover:text-[#1E90FF]">
                        <strong>OK</strong>
                    </button>

                </div>
            </div>
        </div>

        @else
        <h3 class="text-[16px] font-bold text-[#052D6E] mb-4" style="font-family: 'Inter', sans-serif;">Berikan Rating untuk Buku Ini:</h3>
        <form action="{{ route('user.rating.store', $buku->id_buku) }}" method="POST">
            @csrf
            <!-- Rating Stars -->
            <div class="flex justify-center mb-4">
                <div class="flex items-center space-x-2">
                    <input type="hidden" id="rating" name="rating" value="5">
                    <div class="flex text-[#1E90FF] space-x-1">
                        <span class="cursor-pointer star" onclick="setRating(1)">★</span>
                        <span class="cursor-pointer star" onclick="setRating(2)">★</span>
                        <span class="cursor-pointer star" onclick="setRating(3)">★</span>
                        <span class="cursor-pointer star" onclick="setRating(4)">★</span>
                        <span class="cursor-pointer star" onclick="setRating(5)">★</span>
                    </div>
                </div>
            </div>

            <!-- Komentar Section -->
            <div class="mb-4">
                <textarea id="komentar" name="komentar" rows="3" placeholder="Tuliskan komentar Anda..." class="block text-[14px] w-full p-4 border rounded-[16px] text-[#979797] border-[#1E90FF] focus:outline-none focus:ring-1 focus:ring-[#1E90FF]"></textarea>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="button" onclick="toggleModal('ratingModal')" class=" mr-4 px-4 text-bold py-2 bg-[#FFCFC2] text-[#E46B61] rounded-[12px] hover:bg-[#E46B61] hover:text-white">
                    <strong>Batal</strong>
                </button>
                <button type="submit" class="px-4 py-2 bg-[#1E90FF] text-bold text-white rounded-[12px] hover:bg-[#D3E9FF] hover:text-[#1E90FF]">
                    <strong>Kirim</strong>
                </button>
                @endif

            </div>
        </form>
    </div>
</div>


@else
<div class="bg-yellow-50 p-4 rounded-lg text-yellow-800">
    Anda belum berlangganan. Silakan berlangganan untuk memberikan rating.
</div>
@endif
</div>

</div>


</div>

</div>
<script>
    function toggleModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.toggle('hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    function setRating(value) {
        document.getElementById('rating').value = value;
        const stars = document.querySelectorAll('.star');
        stars.forEach((star, index) => {
            if (index < value) {
                star.classList.add('active');
            } else {
                star.classList.remove('active');
            }
        });
    }


</script>
@endsection
