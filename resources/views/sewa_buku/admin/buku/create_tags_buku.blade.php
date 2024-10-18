@extends('sewa_buku.layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            <h1 class="text-3xl font-bold mb-4">Edit Tags untuk Buku "{{ $buku->judul_buku }}"</h1>
            <!-- Success Message -->
            @if (session('success'))
                <div class="mt-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif
            <!-- Form Edit Tags Buku -->
            <form action="{{ route('admin.tagsBuku.update', $buku->id_buku) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Daftar Tags dengan Checkbox -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Pilih Tags</label>
                    <div class="mt-2">
                        @foreach($tags as $tag)
                            <div>
                                <input
                                    type="checkbox"
                                    name="id_tags[]"
                                    value="{{ $tag->id_tags }}"
                                    {{ in_array($tag->id_tags, $selectedTags) ? 'checked' : '' }}
                                >
                                <label>{{ $tag->nama_tags }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Tombol Update -->
                <div class="mt-6">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Simpan Perubahan</button>
                </div>
            </form>


        </div>
    </div>
</div>
@endsection
