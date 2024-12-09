@extends('sewa_buku.layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-semibold mb-4">Buat Opsi untuk Soal</h1>

        <!-- Informasi Soal -->
        <div class="mb-6">
            <h2 class="text-lg font-semibold">Soal:</h2>
            <p>{{ $soal->soal }}</p>
            @if ($soal->image)
                <p><strong>Gambar Soal:</strong></p>
                <img src="{{ asset('storage/' . $soal->image) }}" alt="Gambar Soal" class="w-32 h-auto mb-4">
            @endif
        </div>

        <!-- Formulir Pembuatan Opsi -->
        <form action="{{ route('opsi.store', $soal->id_soal) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <!-- ID Soal -->
            <input type="hidden" name="id_soal" value="{{ $soal->id_soal }}">

            <!-- Input Opsi -->
            <div>
                <label for="opsi" class="block text-sm font-medium text-gray-700">Opsi</label>
                <input type="text" name="opsi" id="opsi" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>

            <!-- Upload Gambar (Opsional) -->
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Gambar Opsi (Opsional)</label>
                <input type="file" name="image" id="image"
                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>

            <!-- Pilihan Benar atau Salah -->
            <div>
                <label for="is_correct" class="block text-sm font-medium text-gray-700">Apakah Opsi Benar?</label>
                <select name="is_correct" id="is_correct" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="1">Benar</option>
                    <option value="0">Salah</option>
                </select>
            </div>

            <!-- Tombol Submit -->
            <div class="pt-4">
                <button type="submit"
                        class="w-full px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                    Simpan Opsi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
