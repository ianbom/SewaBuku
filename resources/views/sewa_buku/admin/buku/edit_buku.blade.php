@extends('sewa_buku.layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6">Edit Buku</h1>

    <form action="{{ route('admin.buku.update', $buku->id_buku) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Nama Buku -->
        <div>
            <label for="nama_buku" class="block text-sm font-medium text-gray-700">Nama Buku</label>
            <input type="text" name="nama_buku" id="nama_buku" value="{{ old('nama_buku', $buku->judul_buku) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            @error('nama_buku')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- Penulis -->
        <div>
            <label for="penulis" class="block text-sm font-medium text-gray-700">Penulis</label>
            <input type="text" name="penulis" id="penulis" value="{{ old('penulis', $buku->penulis) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            @error('penulis')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- Penerbit -->
        <div>
            <label for="penerbit" class="block text-sm font-medium text-gray-700">Penerbit</label>
            <input type="text" name="penerbit" id="penerbit" value="{{ old('penerbit', $buku->penerbit) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            @error('penerbit')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- Jumlah Halaman -->
        <div>
            <label for="jumlah_halaman" class="block text-sm font-medium text-gray-700">Jumlah Halaman</label>
            <input type="text" name="jumlah_halaman" id="jumlah_halaman" value="{{ old('jumlah_halaman', $buku->jumlah_halaman) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            @error('jumlah_halaman')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- ISBN -->
        <div>
            <label for="isbn" class="block text-sm font-medium text-gray-700">ISBN</label>
            <input type="text" name="isbn" id="isbn" value="{{ old('isbn', $buku->isbn) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            @error('isbn')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tahun Terbit -->
        <div>
            <label for="tahun_terbit" class="block text-sm font-medium text-gray-700">Tahun Terbit</label>
            <input type="text" name="tahun_terbit" id="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            @error('tahun_terbit')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- Harga -->
        <div>
            <label for="harga" class="block text-sm font-medium text-gray-700">Harga</label>
            <input type="number" name="harga" id="harga" value="{{ old('harga', $buku->harga) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            @error('harga')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- Teaser Audio -->
        <div>
            <label for="teaser_audio" class="block text-sm font-medium text-gray-700">Teaser Audio (MP3)</label>
            <input type="file" name="teaser_audio" id="teaser_audio" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50">
            <p class="text-xs text-gray-500 mt-2">Current Teaser Audio: {{ $buku->teaser_audio }}</p>
            @error('teaser_audio')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- Ringkasan Audio -->
        <div>
            <label for="ringkasan_audio" class="block text-sm font-medium text-gray-700">Ringkasan Audio (MP3)</label>
            <input type="file" name="ringkasan_audio" id="ringkasan_audio" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50">
            <p class="text-xs text-gray-500 mt-2">Current Ringkasan Audio: {{ $buku->ringkasan_audio }}</p>
            @error('ringkasan_audio')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- Sinopsis -->
        <div>
            <label for="sinopsis" class="block text-sm font-medium text-gray-700">Sinopsis</label>
            <textarea name="sinopsis" id="sinopsis" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('sinopsis', $buku->sinopsis) }}</textarea>
            @error('sinopsis')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="cover_buku" class="block text-sm font-medium text-gray-700">Cover Buku</label>
            <input type="file" id="cover_buku" name="cover_buku[]" accept=".jpg,.jpeg,.png" multiple class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
        </div>



        <div class="flex justify-end">
            <a href="{{ route('admin.buku.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-2">
                Cancel
            </a>
            <a href="{{ route('admin.detailBuku.edit', $buku->id_buku) }}" class="inline-flex items-center px-4 py-2 bg-green-200 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-2">
                Edit Detail Buku
            </a>
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Update
            </button>
        </div>
    </form>

    <div class="flex flex-wrap gap-4 mb-4">
        @foreach ($buku->coverBuku as $cover)
            <div class="relative">
                <img src="{{ Storage::url($cover->file_image) }}" alt="Cover Buku" class="w-32 h-48 object-cover border border-gray-300 rounded-md">
               <form action="{{ route('admin.buku.deleteCover', $cover->id_cover_buku) }}" method="POST" class="absolute top-0 right-0">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white rounded-full text-xs p-1">Delete</button>
                </form>
            </div>
        @endforeach
    </div>
</div>
@endsection





        <!-- Cover Buku -->
        {{-- <div>
            <label for="cover_buku" class="block text-sm font-medium text-gray-700">Cover Buku (JPG, PNG)</label>
            <input type="file" name="cover_buku[]" id="cover_buku" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50" multiple>
            <p class="text-xs text-gray-500 mt-2">Current Cover(s):</p>
            <ul class="list-disc pl-5">
                @foreach($buku->coverBuku as $cover)
                    <li><a href="{{ Storage::url($cover->file_image) }}" target="_blank">{{ $cover->file_image }}</a></li>
                @endforeach
            </ul>
            @error('cover_buku')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div> --}}
