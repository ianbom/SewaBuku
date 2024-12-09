@extends('sewa_buku.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-10">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-6">Edit Opsi</h1>

        <!-- Form untuk Edit Opsi -->
        <form action="{{ route('opsi.update', $opsi->id_opsi) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Input Opsi -->
            <div class="mb-4">
                <label for="opsi" class="block text-gray-700 font-semibold">Opsi</label>
                <textarea name="opsi" id="opsi" rows="3" class="w-full mt-2 p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('opsi', $opsi->opsi) }}</textarea>
                @error('opsi')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Input Gambar -->
            <div class="mb-4">
                <label for="image" class="block text-gray-700 font-semibold">Gambar (Opsional)</label>
                @if($opsi->image)
                <div class="mb-2">
                    <img src="{{ Storage::url($opsi->image) }}" alt="Gambar Opsi" class="max-w-sm rounded-lg">
                </div>
                @endif
                <input type="file" name="image" id="image" class="w-full mt-2 p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Input Status Kebenaran -->
            <div class="mb-4">
                <label for="is_correct" class="block text-gray-700 font-semibold">Status Kebenaran</label>
                <select name="is_correct" id="is_correct" class="w-full mt-2 p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="1" {{ $opsi->is_correct ? 'selected' : '' }}>Benar</option>
                    <option value="0" {{ !$opsi->is_correct ? 'selected' : '' }}>Salah</option>
                </select>
                @error('is_correct')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Submit -->
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-600 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    Update Opsi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
