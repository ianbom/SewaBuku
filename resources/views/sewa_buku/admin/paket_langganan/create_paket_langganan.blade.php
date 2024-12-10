@extends('sewa_buku.layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <h2 class="text-2xl font-semibold mb-4">Buat Paket Langganan Baru</h2>
    <form id="paketLanggananForm" action="{{ route('paket-langganan.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        <div class="mb-4">
            <label for="nama_paket" class="block text-gray-700 text-sm font-bold mb-2">Nama Paket</label>
            <input type="text" name="nama_paket" id="nama_paket" required
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                placeholder="Nama Paket">
        </div>

        <div class="mb-4">
            <label for="harga" class="block text-gray-700 text-sm font-bold mb-2">Harga</label>
            <input type="number" step="0.01" name="harga" id="harga" required
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                placeholder="Harga Paket">
        </div>

        <div class="mb-4">
            <label for="masa_waktu" class="block text-gray-700 text-sm font-bold mb-2">Masa Waktu (Hari)</label>
            <input type="number" name="masa_waktu" id="masa_waktu" required
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                placeholder="Masa Waktu Paket">
        </div>

        <div class="mb-4">
            <label for="deskripsi" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" required rows="5"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                placeholder="Deskripsi Paket"></textarea>
        </div>

        <div class="mb-4">
            <label for="is_active" class="block text-gray-700 font-bold mb-2">Status Aktif</label>
            <select id="is_active" name="is_active"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="1" selected>Aktif</option>
                <option value="0">Nonaktif</option>
            </select>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Simpan Paket
            </button>
        </div>
    </form>
</div>
@endsection
