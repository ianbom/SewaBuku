@extends('sewa_buku.layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl font-bold mb-6">Create Quiz</h2>
        <form action="{{ route('quiz.store', $detailBuku->id_detail_buku) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id_detail_buku" value="{{ $detailBuku->id_detail_buku }}">

            <!-- Nama Quiz -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="nama_quiz">Nama Quiz</label>
                <input type="text" name="nama_quiz" id="nama_quiz" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Masukkan nama quiz" required>
            </div>

            <!-- Deskripsi -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="deskripsi">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Masukkan deskripsi quiz"></textarea>
            </div>

            <!-- File PDF -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="file">File PDF/Image (Opsional)</label>
                <input type="file" name="file" id="file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Buat Quiz
                </button>
                {{-- <a href="{{ route('detail_buku.show', $detailBuku->id_detail_buku) }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Batal
                </a> --}}
            </div>
        </form>
    </div>
</div>
@endsection
