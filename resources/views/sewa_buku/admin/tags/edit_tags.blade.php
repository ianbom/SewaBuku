@extends('sewa_buku.layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            <h1 class="text-3xl font-bold mb-4">Edit Tags</h1>

            <!-- Tampilkan pesan sukses jika ada -->
            @if (session('success'))
                <div class="mt-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Form Edit Tags -->
            <form action="{{ route('admin.tags.update', $tags->id_tags) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Nama Tags -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nama Tags</label>
                    <input type="text" name="nama_tags" value="{{ old('nama_tags', $tags->nama_tags) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('nama_tags')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol Simpan Perubahan -->
                <div class="mt-6">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
