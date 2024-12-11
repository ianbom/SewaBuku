@extends('sewa_buku.layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Daftar Buku</h1>
    <a class="text-1xl bg-blue-500 rounded-sm p-1 " href="{{ route('admin.buku.create') }}" >Buat buku</a>

    <table class="min-w-full bg-white border border-gray-300">
        <thead>
            <tr class="bg-gray-200 text-gray-600 uppercase text-sm">
                <th class="py-3 px-4 text-left">Judul Buku</th>
                <th class="py-3 px-4 text-left">Penulis</th>
                <th class="py-3 px-4 text-left">Penerbit</th>
                <th class="py-3 px-4 text-left">Jumlah Halaman</th>
                <th class="py-3 px-4 text-left">ISBN</th>
                <th class="py-3 px-4 text-left">Tahun Terbit</th>
                <th class="py-3 px-4 text-left">Teaser Audio</th>
                <th class="py-3 px-4 text-left">Sinopsis</th>
                <th class="py-3 px-4 text-left">Ringkasan Audio</th>
                <th class="py-3 px-4 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($buku as $item)
            <tr class="border-b hover:bg-gray-100">
                <td class="py-3 px-4">{{ $item->judul_buku }}</td>
                <td class="py-3 px-4">{{ $item->penulis }}</td>
                <td class="py-3 px-4">{{ $item->penerbit }}</td>
                <td class="py-3 px-4">{{ $item->isbn }}</td>
                <td class="py-3 px-4">{{ $item->tahun_terbit }}</td>
                <td class="py-3 px-4">
                    <audio controls>
                        <source src="{{ asset('storage/' . $item->teaser_audio) }}" type="audio/mp3">
                        Your browser does not support the audio tag.
                    </audio>
                </td>
                <td class="py-3 px-4">{{ Str::limit($item->sinopsis, 100) }}</td>
                <td class="py-3 px-4">
                    <audio controls>
                        <source src="{{ asset('storage/' . $item->ringkasan_audio) }}" type="audio/mp3">
                        Your browser does not support the audio tag.
                    </audio>
                </td>
                <td class="py-3 px-4">
                   <a href="{{ route('admin.buku.edit', $item->id_buku) }}">Edit </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
