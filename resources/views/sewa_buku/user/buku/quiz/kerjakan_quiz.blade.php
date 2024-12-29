@extends('sewa_buku.layouts.userBacaBuku')

@section('title')
    'Kerjakan Quiz'
@endsection

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Quiz Title -->
    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-blue-900">Quiz: {{ $quiz->nama_quiz }}</h1>
        <p class="text-gray-600 italic mt-2">{{ $quiz->deskripsi }}</p>
    </div>

    <!-- Quiz Content -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <form action="{{ route('user.quiz.submit', $quiz->id_quiz) }}" method="POST">
            @csrf

            <!-- Question Section -->
            @foreach ($soal as $key => $item)
                <div class="p-8 border-b border-gray-200">
                    <!-- Question -->
                    <p class="text-xl font-semibold text-gray-800 mb-6">
                        {{ $key + 1 }}. {{ $item->pertanyaan }}
                    </p>

                    <!-- Options -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach ($item->opsi as $opsi)
                            <label class="flex items-center p-4 border rounded-lg hover:bg-gray-50 cursor-pointer transition-colors group">
                                <input
                                    type="radio"
                                    name="jawaban[{{ $item->id_soal }}]"
                                    value="{{ $opsi->id_opsi }}"
                                    class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                                    required
                                >
                                <span class="ml-4 text-gray-700 group-hover:text-gray-900">{{ $opsi->opsi }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <!-- Submit Section -->
            <div class="p-8 bg-blue-50 flex justify-between items-center">
                <button type="submit" class="px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                    SUBMIT
                </button>

                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <span class="text-2xl font-bold text-gray-800">1</span>
                        <span class="text-gray-500">True</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-2xl font-bold text-gray-800">0</span>
                        <span class="text-gray-500">False</span>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

