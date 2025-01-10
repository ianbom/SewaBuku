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
                        <a href="#"
                            type="submit"
                            class="flex items-center gap-2 px-4 py-3 text-white bg-[#052D6E] rounded-[12px] disabled ">
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
    </div>


</div>
</div>
</div>
</div>


<div class="mt-8 mb-8">

    <div class="mt-10">
        <p class="text-[18px] text-[#052D6E] font-bold mb-4 ">Highlight</p>
        @forelse ($highlight as $index => $item)
        <div class="flex items-center justify-between p-4 rounded-[16px] mb-4 {{ $index % 2 === 0 ? 'bg-[#D3E9FF] text-[#1E90FF]' : 'bg-[#EBE4FF] text-[#8F7CC1]' }}">
            <h3 class="flex-1 text-sm font-semibold text-inherit">{{ $item->highlight }}</h3>
            <!-- Div Ikon -->
            <div onclick="copyToClipboard('{{ $item->highlight }}')"  class="text-center {{ $index % 2 === 0 ? 'bg-[#1E90FF]' : 'bg-[#8F7CC1]' }} p-2 rounded-[6px] flex items-center justify-center mr-3">
                <button><i class="fas fa-copy text-white text-[12px]"></i></button>
            </div>
            <div class="text-center {{ $index % 2 === 0 ? 'border-2 border-[#1E90FF]' : 'border-2 border-[#8F7CC1]' }} p-2 rounded-[6px] flex items-center justify-center">
                <form action="{{ route('user.highlight.delete', $item->id_highlight) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">
                        <i class="fas fa-trash {{ $index % 2 === 0 ? 'text-[#1E90FF]' : 'text-[#8F7CC1]' }} text-[12px]"></i>
                    </button>
                </form>
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





</div>
</div>


</div>

</div>


</div>

</div>

@endsection
