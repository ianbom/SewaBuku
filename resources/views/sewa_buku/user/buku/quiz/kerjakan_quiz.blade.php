@extends('sewa_buku.layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow-md rounded-lg p-8">
        <h1 class="text-2xl font-bold mb-6">Kerjakan Quiz</h1>

        <!-- Informasi Quiz -->
        <div class="mb-6">
            <h2 class="text-lg font-semibold">Nama Quiz:</h2>
            <p class="text-gray-700">{{ $quiz->nama_quiz }}</p>
        </div>

        <div class="mb-6">
            <h2 class="text-lg font-semibold">Deskripsi Quiz:</h2>
            <p class="text-gray-700">{{ $quiz->deskripsi }}</p>
        </div>

        <!-- Daftar Soal -->
        <form action="{{ route('user.quiz.submit', $quiz->id_quiz) }}" method="POST">
            @csrf
            <div class="mb-6">
                <h2 class="text-xl font-bold mb-4">Daftar Soal</h2>
                @foreach ($soal as $key => $item)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Soal {{ $key + 1 }}:</h3>
                        <p class="text-gray-700">{{ $item->soal }}</p>
                        @if ($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="Gambar Soal" class="w-64 h-auto rounded-lg my-4">
                        @endif

                        <!-- Daftar Opsi -->
                        <div class="space-y-2">
                            @foreach ($item->opsi as $opsi)
                                <div class="flex items-center space-x-2">
                                    <input type="radio" name="jawaban[{{ $item->id_soal }}]" value="{{ $opsi->id_opsi }}" id="opsi-{{ $opsi->id_opsi }}" class="form-radio text-blue-500">
                                    <label for="opsi-{{ $opsi->id_opsi }}" class="text-gray-700">
                                        {{ $opsi->opsi }}
                                        @if ($opsi->image)
                                            <img src="{{ asset('storage/' . $opsi->image) }}" alt="Gambar Opsi" class="w-24 h-auto rounded-lg">
                                        @endif
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Tombol Submit -->
            <div class="text-center">
                <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                    Submit Quiz
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
