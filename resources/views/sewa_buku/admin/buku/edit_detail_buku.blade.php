@extends('sewa_buku.layouts.app')

@section('content')
<div class="container mx-auto mt-5">
    <h2 class="text-2xl font-bold">Edit Detail Buku</h2>

    <!-- Tampilkan pesan sukses atau error -->
    @if(session('success'))
        <div class="bg-green-500 text-white p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-500 text-white p-2 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form untuk mengedit dan menambahkan detail buku -->
    <form action="{{ route('admin.updateBuku.edit', $detailBuku->first()->id_buku) }}" method="POST" enctype="multipart/form-data" id="detailBukuForm">
        @csrf
        @method('PUT')

        <!-- Loop untuk setiap detail buku yang ada -->
        @foreach ($detailBuku as $key => $detail)
            <div class="border p-4 mb-4 rounded detail-buku">
                <h3 class="text-lg font-semibold">Detail {{ $key + 1 }}</h3>

                <div class="mb-2">
                    <label for="detail_buku[{{ $key }}][bab]" class="block">Bab:</label>
                    <input type="text" name="detail_buku[{{ $key }}][bab]" id="detail_buku[{{ $key }}][bab]" value="{{ old("detail_buku.$key.bab", $detail->bab) }}" class="w-full border rounded p-2" required>
                </div>

                <div class="mb-2">
                    <label for="detail_buku[{{ $key }}][isi]" class="block">Isi:</label>
                    <textarea name="detail_buku[{{ $key }}][isi]" id="detail_buku[{{ $key }}][isi]" class="w-full border rounded p-2" required>{{ old("detail_buku.$key.isi", $detail->isi) }}</textarea>
                </div>

                <div class="mb-2">
                    <label for="detail_buku[{{ $key }}][audio]" class="block">Audio:</label>
                    <input type="file" name="detail_buku[{{ $key }}][audio]" id="detail_buku[{{ $key }}][audio]" class="border rounded p-2">
                    @if ($detail->audio)
                        <div class="mt-2">
                            <input type="checkbox" name="detail_buku[{{ $key }}][keep_existing_audio]" id="detail_buku[{{ $key }}][keep_existing_audio]" value="1" checked>
                            <label for="detail_buku[{{ $key }}][keep_existing_audio]">Pertahankan audio yang ada</label>
                            <input type="hidden" name="detail_buku[{{ $key }}][existing_audio]" value="{{ $detail->audio }}">
                            <p class="text-xs text-gray-500">Current Audio: {{ $detail->audio }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach

        <!-- Bagian untuk menambahkan detail buku baru -->
        <div id="newDetailsContainer"></div>

        <button type="button" id="addDetailButton" class="bg-green-500 text-white rounded px-4 py-2 mb-4">Tambah Detail Baru</button>

        <button type="submit" class="bg-blue-500 text-white rounded px-4 py-2">Update Detail Buku</button>
    </form>
</div>
<script>
    document.getElementById('addDetailButton').addEventListener('click', function() {
        const container = document.getElementById('newDetailsContainer');
        const index = document.querySelectorAll('.detail-buku').length; // Dapatkan jumlah total detail yang ada

        const detailDiv = document.createElement('div');
        detailDiv.className = 'border p-4 mb-4 rounded detail-buku';
        detailDiv.innerHTML = `
            <h3 class="text-lg font-semibold">Tambah Detail Baru ${index + 1}</h3>
            <div class="mb-2">
                <label for="detail_buku[${index}][bab]" class="block">Bab:</label>
                <input type="text" name="detail_buku[${index}][bab]" id="detail_buku[${index}][bab]" class="w-full border rounded p-2" required>
            </div>
            <div class="mb-2">
                <label for="detail_buku[${index}][isi]" class="block">Isi:</label>
                <textarea name="detail_buku[${index}][isi]" id="detail_buku[${index}][isi]" class="w-full border rounded p-2" required></textarea>
            </div>
            <div class="mb-2">
                <label for="detail_buku[${index}][audio]" class="block">Audio:</label>
                <input type="file" name="detail_buku[${index}][audio]" id="detail_buku[${index}][audio]" class="border rounded p-2">
            </div>
        `;
        container.appendChild(detailDiv);
    });
</script>
