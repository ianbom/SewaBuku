@extends('sewa_buku.layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <h2 class="text-2xl font-semibold mb-4">Edit Paket Langganan</h2>

    <form action="{{ route('paket-langganan.update', $paketLangganan->id_paket_langganan) }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="nama_paket" class="block text-gray-700 font-bold mb-2">Nama Paket</label>
            <input type="text" id="nama_paket" name="nama_paket" value="{{ old('nama_paket', $paketLangganan->nama_paket) }}"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                placeholder="Masukkan Nama Paket">
        </div>

        <div class="mb-4">
            <label for="harga" class="block text-gray-700 font-bold mb-2">Harga</label>
            <input type="number" step="0.01" id="harga" name="harga" value="{{ old('harga', $paketLangganan->harga) }}"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                placeholder="Masukkan Harga Paket">
        </div>

        <div class="mb-4">
            <label for="masa_waktu" class="block text-gray-700 font-bold mb-2">Masa Waktu (Hari)</label>
            <input type="number" id="masa_waktu" name="masa_waktu" value="{{ old('masa_waktu', $paketLangganan->masa_waktu) }}"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                placeholder="Masukkan Masa Waktu (Hari)">
        </div>

        <div class="mb-4">
            <label for="deskripsi" class="block text-gray-700 font-bold mb-2">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" rows="4"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                placeholder="Masukkan Deskripsi Paket">{{ old('deskripsi', $paketLangganan->deskripsi) }}</textarea>
        </div>

        <div class="mb-4">
            <label for="is_active" class="block text-gray-700 font-bold mb-2">Status Aktif</label>
            <select id="is_active" name="is_active"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="1" {{ old('is_active', $paketLangganan->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ old('is_active', $paketLangganan->is_active) == 0 ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>


        <div class="flex items-center justify-between">
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Simpan Perubahan
            </button>
            <a href="{{ route('paket-langganan.index') }}"
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
