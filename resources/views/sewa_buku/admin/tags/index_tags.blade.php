@extends('sewa_buku.layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            <h1 class="text-3xl font-bold mb-4">Kelola Tags</h1>

            <!-- Tampilkan pesan sukses jika ada -->
            @if (session('success'))
                <div class="mt-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Daftar Tags -->
            <h2 class="text-2xl font-semibold mb-4">Daftar Tags</h2>
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Parent Tags</th>
                        <th class="px-4 py-2">Nama Tags</th>
                        <th class="px-4 py-2">Tanggal Dibuat</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tags as $tag)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $tag->id_tags }}</td>
                            <td class="px-4 py-2">
                                {{ $tag->parent->nama_tags ?? '-' }}
                            </td>
                            <td class="px-4 py-2">{{ $tag->nama_tags }}</td>
                            <td class="px-4 py-2">{{ $tag->created_at->format('d-m-Y') }}</td>
                            <td class="px-4 py-2">
                                <a href="{{ route('admin.tags.edit', $tag->id_tags) }}" class="text-blue-500 hover:underline">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-2 text-center">Tidak ada tags</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>


            <!-- Form Tambah Tags -->
            <h2 class="text-2xl font-semibold mt-8 mb-4">Tambah Tags Baru</h2>
            <form action="{{ route('admin.tags.store') }}" method="POST">
                @csrf

                <!-- ID Child -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">ID Child (Optional)</label>
                    <select name="id_child" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">-- Pilih Child Tag (Opsional) --</option>
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->id_tags }}" {{ old('id_child') == $tag->id_tags ? 'selected' : '' }}>
                                {{ $tag->nama_tags }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_child')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Tags -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nama Tags</label>
                    <input type="text" name="nama_tags" value="{{ old('nama_tags') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('nama_tags')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>



                <!-- Tombol Simpan -->
                <div class="mt-6">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Simpan Tags</button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
