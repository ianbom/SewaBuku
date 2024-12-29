@extends('sewa_buku.layouts.userBacaBuku')

@section('title')
    {{ $detailBuku->bab ?? 'Baca Bab Buku' }}
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <!-- Header Bab -->
            <div class="text-center border-b pb-6 mb-6">
                <h1 class="text-3xl font-bold text-gray-800"> {{ $detailBuku->buku->judul_buku ?? 'Judul Buku Tidak Tersedia' }}</h1>
                <p class="text-gray-500 mt-2"> {{ $detailBuku->bab ?? 'Bab Tidak Ditemukan' }}</p>
            </div>

            <!-- Isi Bab -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Isi Bab</h2>
                <p class="text-gray-600 leading-relaxed">{{ $detailBuku->isi ?? 'Isi tidak tersedia.' }}</p>
                <button class="bg-blue-500 rounded-md p-1 text-white"> Mark as finished</button>
            </div>

            <!-- Audio Bab -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Audio Bab</h2>
                @if (!empty($detailBuku->audio))
                    <audio controls class="w-full rounded-md border">
                        <source src="{{ asset('storage/' . $detailBuku->audio) }}" type="audio/mpeg">
                        Browser Anda tidak mendukung pemutar audio.
                    </audio>
                @else
                    <p class="text-gray-500">Tidak ada audio untuk bab ini.</p>
                @endif
            </div>

            <div class="mb-8">
                @if ($quiz)
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Quiz</h2>
                    <h3 class="text-lg font-medium text-black mb-4">{{ $quiz->nama_quiz }}</h3>
                    @if ($quizScore)
                        <p class="text-green-600 font-bold mb-4">Nilai Anda: {{ $quizScore }}</p>
                    @else
                        <p class="text-yellow-500 font-bold mb-4">{{ $quizStatus }}</p>
                    @endif
                    <a href="{{ route('user.quiz.kerjakan', $detailBuku->id_detail_buku) }}" class="bg-green-500 rounded-md p-2 text-white">
                        @if ($quizScore)
                            Kerjakan Ulang Quiz
                        @else
                            Kerjakan Quiz
                        @endif
                    </a>
                @else
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Tidak ada quiz</h2>
                @endif
            </div>


            <!-- Tombol Navigasi -->
            <div class="flex justify-between items-center mt-8 pt-6 border-t">
                <a href="{{ route('user.buku.show', $detailBuku->id_buku) }}" class="inline-flex items-center px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
