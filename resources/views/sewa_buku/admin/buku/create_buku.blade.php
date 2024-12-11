@extends('sewa_buku.layouts.app')

@section('content')
<div class="container mx-auto p-5">
    <h1 class="text-2xl font-bold mb-5">Tambah Buku Baru</h1>
    <form action="{{ route('admin.buku.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Form untuk Data Buku -->
        <div class="mb-4">
            <label for="nama_buku" class="block text-sm font-medium text-gray-700">Judul Buku</label>
            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" id="nama_buku" name="nama_buku" required>
        </div>

        <div class="mb-4">
            <label for="penulis" class="block text-sm font-medium text-gray-700">Penulis</label>
            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" id="penulis" name="penulis" required>
        </div>

        <div class="mb-4">
            <label for="tentang_penulis" class="block text-sm font-medium text-gray-700">Tentang Penulis</label>
            <textarea class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" id="tentang_penulis" name="tentang_penulis" required></textarea>
        </div>

        <div class="mb-4">
            <label for="rating_amazon" class="block text-sm font-medium text-gray-700">Rating Amazon</label>
            <input type="number" step="0.1" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" id="rating_amazon" name="rating_amazon" required>
        </div>

        <div class="mb-4">
            <label for="link_pembelian" class="block text-sm font-medium text-gray-700">Link Pembelian</label>
            <input type="url" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" id="link_pembelian" name="link_pembelian" required>
        </div>

        <div class="mb-4">
            <label for="penerbit" class="block text-sm font-medium text-gray-700">Penerbit</label>
            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" id="penerbit" name="penerbit" required>
        </div>

        <div class="mb-4">
            <label for="isbn" class="block text-sm font-medium text-gray-700">ISBN</label>
            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" id="isbn" name="isbn" required>
        </div>

        <div class="mb-4">
            <label for="tahun_terbit" class="block text-sm font-medium text-gray-700">Tahun Terbit</label>
            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" id="tahun_terbit" name="tahun_terbit" required>
        </div>

        <div class="mb-4">
            <label for="teaser_audio" class="block text-sm font-medium text-gray-700">Teaser Audio (MP3)</label>
            <input type="file" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" id="teaser_audio" name="teaser_audio" accept="audio/mp3" required>
        </div>

        <div class="mb-4">
            <label for="sinopsis" class="block text-sm font-medium text-gray-700">Sinopsis</label>
            <textarea class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" id="sinopsis" name="sinopsis" required></textarea>
        </div>

        <div class="mb-4">
            <label for="ringkasan_audio" class="block text-sm font-medium text-gray-700">Ringkasan Audio (MP3)</label>
            <input type="file" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" id="ringkasan_audio" name="ringkasan_audio" accept="audio/mp3" required>
        </div>

        <div class="mb-4">
            <label for="is_free" class="block text-sm font-medium text-gray-700">Apakah Buku Gratis?</label>
            <div class="flex items-center space-x-2">
                <input
                    type="checkbox"
                    id="is_free"
                    name="is_free"
                    value="1"
                    class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                    {{ old('is_free', false) ? 'checked' : '' }}
                >
                <span class="text-gray-600">Ya</span>
            </div>
            @error('is_free')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>



        <!-- Form untuk Detail Buku (Multiple Details) -->
        <div id="detail-buku-container" class="mb-4">
            <h3 class="text-lg font-semibold mb-2">Detail Buku</h3>
            <div class="detail-buku-item mb-4">
                <div class="mb-3">
                    <label for="bab" class="block text-sm font-medium text-gray-700">Bab</label>
                    <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" name="detail_buku[0][bab]" required>
                </div>
                <div class="mb-3">
                    <label for="isi" class="block text-sm font-medium text-gray-700">Isi</label>
                    <textarea class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" name="detail_buku[0][isi]" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="audio" class="block text-sm font-medium text-gray-700">Audio (MP3) <small class="text-gray-500">(Optional)</small></label>
                    <input type="file" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" name="detail_buku[0][audio]" accept="audio/mp3">
                </div>
                <div class="mb-3">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="detail_buku[0][is_free_detail]" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Gratis untuk Bab ini?</span>
                    </label>
                </div>
            </div>
        </div>


        <!-- Tombol Tambah Detail Buku -->
        <button type="button" id="add-detail-buku" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mb-3">Tambah Detail Buku</button>

        <!-- Form untuk Cover Buku -->
        <div class="mb-4">
            <label for="cover_buku" class="block text-sm font-medium text-gray-700">Cover Buku (JPG/PNG)</label>
            <input type="file" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" name="cover_buku[]" accept="image/jpeg,image/png" multiple required>
        </div>

        <!-- Tombol Submit -->
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Simpan Buku</button>
    </form>
</div>

<script>
    let detailBukuIndex = 1;

    document.getElementById('add-detail-buku').addEventListener('click', function () {
        let container = document.getElementById('detail-buku-container');
        let newDetailBuku = `
            <div class="detail-buku-item mb-4">
                <div class="mb-3">
                    <label for="bab" class="block text-sm font-medium text-gray-700">Bab</label>
                    <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" name="detail_buku[${detailBukuIndex}][bab]" required>
                </div>
                <div class="mb-3">
                    <label for="isi" class="block text-sm font-medium text-gray-700">Isi</label>
                    <textarea class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" name="detail_buku[${detailBukuIndex}][isi]" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="audio" class="block text-sm font-medium text-gray-700">Audio (MP3) <small class="text-gray-500">(Optional)</small></label>
                    <input type="file" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" name="detail_buku[${detailBukuIndex}][audio]" accept="audio/mp3">
                </div>
                <div class="mb-3">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="detail_buku[0][is_free_detail]" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Gratis untuk Bab ini?</span>
                    </label>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', newDetailBuku);
        detailBukuIndex++;
    });
</script>
@endsection
