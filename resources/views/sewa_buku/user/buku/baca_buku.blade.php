@extends('sewa_buku.layouts.app')

@section('content')
<div class="container mx-auto py-10 px-4">
    <div class="flex flex-col md:flex-row">

        <!-- Sidebar untuk daftar bab -->
        <div class="w-full md:w-1/4 bg-gray-100 p-4 rounded-md shadow-md">
            <h2 class="text-xl font-semibold mb-4">Daftar Bab</h2>
            <ul>
                @foreach($buku->detailBuku as $detail)
                <li class="mb-2">
                    <a href="#bab-{{ $detail->id_detail_buku }}" class="block text-blue-500 hover:text-blue-700">
                        {{ $detail->bab }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>

        <!-- Konten buku (isi bab) -->
        <div class="w-full md:w-3/4 md:ml-8 mt-6 md:mt-0">
            <h1 class="text-3xl font-bold mb-6">{{ $buku->judul_buku }}</h1>

            @foreach($buku->detailBuku as $detail)
            <div id="bab-{{ $detail->id_detail_buku }}" class="mb-12 p-4 bg-white shadow-md rounded-md">
                <h3 class="text-2xl font-semibold mb-4">{{ $detail->bab }}</h3>

                @if (!$quizStatus[$detail->id_detail_buku])
                    <a href="{{ route('user.quiz.kerjakan', $detail->id_detail_buku) }}"
                       class="bg-blue-500 text-white rounded px-4 py-2 hover:bg-blue-600">
                        Kerjakan Soal
                    </a>
                @else
                    <span class="text-green-500 font-bold">Sudah Mengerjakan</span>
                    <p class="text-gray-700">Nilai Anda: {{ $quizScores[$detail->id_detail_buku] }}</p>
                @endif

                <p class="text-gray-700 leading-relaxed mb-4">
                    {{ $detail->isi }}
                </p>

                <!-- Audio jika tersedia -->
                @if($detail->audio)
                    <div class="mt-4">
                        <h4 class="text-lg font-semibold">Dengarkan Audio Bab</h4>
                        <audio controls class="w-full mt-2">
                            <source src="{{ Storage::url($detail->audio) }}" type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio>
                    </div>
                @endif
            </div>
            @endforeach


        </div>

    </div>
</div>
@endsection
