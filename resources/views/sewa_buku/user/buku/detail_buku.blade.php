@extends('sewa_buku.layouts.userApp')

@section('title')
{{ $buku->judul_buku }}
@endsection

@section('content')

<style>
    .star {
        font-size: 2rem;
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

    .bg-[#F1F8FF] {
        background-color: #F1F8FF !important;
    }

    .border-[#A3D8FF] {
        border-color: #A3D8FF !important;
    }
</style>

<div class="container mx-auto mt-10 p-5 sm:p-10">
    <div class="max-w-full">
        <div class="grid xl:grid-col-3 sm:grid-cols-3 sm:grid-cols-12 gap-6">
            <!-- Kolom Kiri - Gambar Buku -->
            <div class="md:col-span-1">
                @if ($buku->coverBuku && $buku->coverBuku->count() > 0)
                <img src="{{ asset('storage/' . $buku->coverBuku->first()->file_image) }}" alt="Cover Buku"
                    class="w-240 xl:w-120 lg:w-60 h-auto object-contain rounded-[16px]">
                @else
                <img src="{{ asset('images/placeholder.png') }}" alt="Placeholder" class="w-full md:w-24 object-contain rounded-[16px]">
                @endif
            </div>

            <!-- Kolom Kanan - Informasi Buku -->
            <div class="md:col-span-2">
                <div class="flex flex-col">
                    <div class="mb-6">
                        <h2 class="text-[24px] sm:text-[28px] font-bold text-[#052D6E] mb-3"
                            style="font-family: 'Libre Baskerville', serif;">{{ $buku->judul_buku }}</h2>
                        <p class="text-[#052D6E] font-bold mb-2">AUTHOR - {{ $buku->penulis }} / PUBLISHER -
                            {{ $buku->penerbit }}
                        </p>
                        <p class="text-sm text-[#979797] font-bold">{{ $buku->tentang_penulis }}</p>
                    </div>
                    <hr class="w-full border-t border-[#052D6E]">

                    <!-- Statistik -->
                    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        <div class="flex mt-6 items-center">
                            <div class="text-center bg-[#D3E9FF] p-2 rounded-[6px] mr-2 flex items-center justify-center">
                                <i class="fas fa-clock text-[#1E90FF] text-[12px]"></i>
                            </div>
                            <span class="text-[12px] text-[#979797] font-bold">{{ floor($buku->totalWaktu / 60) }} Menit</span>
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
                            <span class="text-[12px] text-sm text-[#979797] font-bold">{{ $buku->jumlahChapter }} Tipe</span>
                        </div>

                        <div class="flex mt-6 items-center">
                            <div class="text-center bg-[#EBE4FF] p-2 rounded-[6px] mr-2 flex items-center justify-center">
                                <i class="fas fa-question-circle text-[#8F7CC1] text-[12px]"></i>
                            </div>
                            <span class="text-[12px] text-[#979797] font-bold">{{ $jumlahQuiz }} Bab</span>
                        </div>
                    </div>
                    <hr class="border-t border-[#052D6E]">
                </div>

                <!-- Tombol Aksi -->
                <div class="flex gap-4 my-6">
                    @if ($buku->is_free || $checkLanggananAktif)
                    <a href="{{ $buku->detailBuku?->first() ? route('user.buku.bacaBab', $buku->detailBuku->first()->id_detail_buku) : '#' }}"
                        class="px-6 py-3 bg-[#052D6E] text-white rounded-lg hover:bg-[#AFC4E7FF] hover:text-[#052D6E]">
                        Baca Buku
                    </a>
                    <button type="button" onclick="toggleModal('ratingModal')"
                        class="px-6 py-3 bg-[#B79F54] text-white rounded-lg hover:bg-[#FAFAD8] hover:text-[#B79F54]">
                        Beri Ulasan
                    </button>
                    @else
                    <a href="#" class="px-6 py-3 bg-gray-300 text-gray-600 rounded-lg cursor-not-allowed">
                        Langganan untuk membaca
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Sinopsis Buku -->
    <div class="mt-12">
        <h3 class="text-[#052D6E] font-bold text-lg mb-4">Sinopsis Buku</h3>
        <p class="text-[#979797]">{{ $buku->sinopsis }}</p>
    </div>

    <!-- Audio Teaser -->
    @if ($buku->teaser_audio)
    <div class="mt-8">
        <audio controls class="custom-audio w-full">
            <source src="{{ asset('storage/' . $buku->teaser_audio) }}" type="audio/mp3">
        </audio>
    </div>
    @endif

    <!-- Ulasan -->
    @if ($rating && $rating->count() > 0)
    <div class="mt-8">
        <h3 class="text-[#052D6E] font-bold text-lg mb-4">Ulasan</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach ($rating as $review)
            <div class="border p-4 rounded-lg
                            {{ auth()->check() && $review->user_id === auth()->id() ? 'bg-[#F1F8FF] border-[#A3D8FF]' : 'bg-white border-[#D3E9FF]' }}">
                <div class="flex items-center mb-2">
                    <strong class="text-[#1E90FF] mr-2">{{ $review->user->name }}</strong>
                    <span class="text-[#B79F54]">★</span>
                    <span class="text-[#979797] ml-2">{{ $review->rating }}/5</span>
                </div>
                <p class="text-[#979797]">{{ $review->komentar }}</p>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
