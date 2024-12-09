@extends('sewa_buku.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-10">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-6">Edit Soal</h1>

        <!-- Form untuk Edit Soal -->
        <form action="{{ route('soal.update', $soal->id_soal) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Input Soal -->
            <div class="mb-4">
                <label for="soal" class="block text-gray-700 font-semibold">Soal</label>
                <textarea name="soal" id="soal" rows="5" class="w-full mt-2 p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('soal', $soal->soal) }}</textarea>
                @error('soal')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Input Gambar -->
            <div class="mb-4">
                <label for="image" class="block text-gray-700 font-semibold">Gambar (Opsional)</label>
                @if($soal->image)
                <div class="mb-2">
                    <img src="{{ Storage::url($soal->image) }}" alt="Gambar Soal" class="max-w-sm rounded-lg">
                </div>
                @endif
                <input type="file" name="image" id="image" class="w-full mt-2 p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Submit -->
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-600 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    Update Soal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
