@extends('sewa_buku.layouts.app')

@section('title')
    {{ $buku->judul_buku }}
@endsection

@section('content')
<div class="container mx-auto py-10 px-4">
    <div class="flex flex-col md:flex-row">

        <!-- Sidebar untuk Daftar Bab -->
        <div class="w-full md:w-1/4 bg-gray-100 p-4 rounded-md shadow-md">
            <h2 class="text-xl font-semibold mb-4">Daftar Bab</h2>
            <ul class="space-y-2">
                @foreach($buku->detailBuku as $detail)
                    <li>
                        <a href="#bab-{{ $detail->id_detail_buku }}" 
                           class="block text-blue-500 hover:text-blue-700 font-medium">
                            {{ $detail->bab }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Konten Buku -->
        <div class="w-full md:w-3/4 md:ml-8 mt-6 md:mt-0">
            <h1 class="text-3xl font-bold mb-6">{{ $buku->judul_buku }}</h1>

            @foreach($buku->detailBuku as $detail)
                <!-- Bab Gratis atau Berlangganan -->
                @if ($detail->is_free_detail || $checkLangganan)
                    <div id="bab-{{ $detail->id_detail_buku }}" 
                         class="mb-8 p-6 bg-white shadow-md rounded-md">
                        <h3 class="text-2xl font-semibold mb-2">{{ $detail->bab }}</h3>

                        @if ($detail->id_detail_buku == $babTerakhirDibaca)
                            <span class="text-sm text-green-500">(Terakhir Dibaca)</span>
                        @endif

                        <!-- Tombol Baca -->
                        <a href="{{ route('user.buku.bacaBab', $detail->id_detail_buku) }}"
                           class="inline-block bg-gray-700 text-white rounded px-4 py-2 hover:bg-gray-600 mt-3">
                            Baca Bab {{ $detail->bab }}
                        </a>

                        <!-- Tombol Quiz -->
                        @if ($detail->quiz->first())
                            @if (!$quizStatus[$detail->id_detail_buku])
                                <a href="{{ route('user.quiz.kerjakan', $detail->id_detail_buku) }}"
                                   class="inline-block bg-blue-500 text-white rounded px-4 py-2 hover:bg-blue-600 mt-3">
                                    Kerjakan Soal
                                </a>
                            @else
                                <a href="{{ route('user.quiz.kerjakan', $detail->id_detail_buku) }}"
                                   class="inline-block bg-blue-500 text-white rounded px-4 py-2 hover:bg-blue-600 mt-3">
                                    Kerjakan Lagi
                                </a>
                                <p class="text-gray-700 mt-2">
                                    Nilai Anda: <strong>{{ $quizScores[$detail->id_detail_buku] }}</strong>
                                </p>
                            @endif
                        @else
                            <p class="text-red-500 mt-2">Tidak ada quiz untuk bab ini.</p>
                        @endif

                        <!-- Isi Bab -->
                        <p class="text-gray-700 leading-relaxed mt-4">
                            {{ $detail->isi }}
                        </p>

                        <!-- Audio Bab -->
                        @if($detail->audio)
                            <div class="mt-4">
                                <h4 class="text-lg font-semibold">Dengarkan Audio Bab</h4>
                                <audio controls class="w-full mt-2">
                                    <source src="{{ Storage::url($detail->audio) }}" type="audio/mpeg">
                                    Browser Anda tidak mendukung pemutar audio.
                                </audio>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="mb-8 p-6 bg-gray-200 text-center rounded-md">
                        <span class="text-red-500 font-medium">
                            Langganan diperlukan untuk membaca bab ini.
                        </span>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
@endsection
