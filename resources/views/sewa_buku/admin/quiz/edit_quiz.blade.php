@extends('sewa_buku.layouts.app')

@section('content')
<div class="container mx-auto py-10 px-4">
    <div class="bg-white p-6 rounded-md shadow-md">
        <h2 class="text-2xl font-semibold mb-4">Edit Quiz</h2>

        <form action="{{ route('quiz.update', $quiz->id_quiz) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Nama Quiz -->
            <div class="mb-4">
                <label for="nama_quiz" class="block text-gray-700 font-semibold mb-2">Nama Quiz</label>
                <input type="text" name="nama_quiz" id="nama_quiz"
                       value="{{ old('nama_quiz', $quiz->nama_quiz) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nama_quiz') border-red-500 @enderror">
                @error('nama_quiz')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div class="mb-4">
                <label for="deskripsi" class="block text-gray-700 font-semibold mb-2">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi', $quiz->deskripsi) }}</textarea>
                @error('deskripsi')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- File Upload -->
            <div class="mb-4">
                <label for="file" class="block text-gray-700 font-semibold mb-2">File Quiz (opsional)</label>
                @if ($quiz->file)
                    <p class="mb-2">
                        File saat ini:
                        <a href="{{ Storage::url($quiz->file) }}" class="text-blue-500 hover:underline" target="_blank">
                            Lihat file
                        </a>
                    </p>
                @endif
                <input type="file" name="file" id="file"
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('file') border-red-500 @enderror">
                @error('file')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Tombol Submit -->
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                    Update Quiz
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
