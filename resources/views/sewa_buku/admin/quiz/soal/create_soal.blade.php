@extends('sewa_buku.layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-semibold mb-4">Tambah Soal untuk Quiz: {{ $quiz->nama_quiz }}</h1>

        <form action="{{ route('soal.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- ID Quiz (Hidden) -->
            <input type="hidden" name="id_quiz" value="{{ $quiz->id_quiz }}">

            <!-- Soal -->
            <div class="mb-4">
                <label for="soal" class="block text-sm font-medium text-gray-700">Soal</label>
                <textarea name="soal" id="soal" rows="4"
                          class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                          placeholder="Masukkan soal..." required>{{ old('soal') }}</textarea>
                @error('soal')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Gambar Soal (Opsional) -->
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700">Gambar (Opsional)</label>
                <input type="file" name="image" id="image"
                       class="block w-full mt-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                              file:rounded-full file:border-0 file:text-sm file:font-semibold
                              file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                @error('image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Submit -->
            <div class="flex items-center justify-end mt-6">
                <a href="{{ route('quiz.show', $quiz->id_quiz) }}"
                   class="mr-4 text-gray-600 hover:text-gray-900">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                    Simpan Soal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
