@extends('sewa_buku.layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <h2 class="text-2xl font-semibold mb-4">Daftar Paket Langganan</h2>
    <div class="mb-4">
        <a href="{{ route('paket-langganan.create') }}"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Tambah Paket Langganan
        </a>
    </div>

    <div class="bg-white shadow-md rounded overflow-x-auto">
        <table class="min-w-full leading-normal">
            <thead>
                <tr class="bg-gray-100 text-left text-gray-600 text-sm uppercase font-bold">
                    <th class="px-5 py-3 border-b-2 border-gray-200">Nama Paket</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200">Harga</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200">Masa Waktu (Hari)</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200">Deskripsi</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200">Status</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($paketLangganan as $paket)
                <tr class="border-b border-gray-200 bg-white">
                    <td class="px-5 py-5 text-sm">{{ $paket->nama_paket }}</td>
                    <td class="px-5 py-5 text-sm">Rp {{ number_format($paket->harga, 0, ',', '.') }}</td>
                    <td class="px-5 py-5 text-sm">{{ $paket->masa_waktu }} hari</td>
                    <td class="px-5 py-5 text-sm">{{ Str::limit($paket->deskripsi, 50) }}</td>
                    <td class="px-5 py-5 text-sm">{{ $paket->is_active ? 'Aktif' : 'Non-Aktif' }}</td>
                    <td class="px-5 py-5 text-sm text-center">
                        <a href="{{ route('paket-langganan.edit', $paket->id_paket_langganan) }}"
                            class="text-blue-500 hover:text-blue-700">Edit</a>
                        <form action="{{ route('paket-langganan.destroy', $paket->id_paket_langganan) }}" method="POST"
                            class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="text-red-500 hover:text-red-700 ml-2"
                                onclick="return confirm('Yakin ingin menghapus paket ini?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-gray-500">Belum ada paket langganan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
