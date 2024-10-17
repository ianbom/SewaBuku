@extends('sewa_buku.layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <h1 class="text-3xl font-bold text-center mb-8">Daftar Pesanan</h1>

    <!-- Tabel daftar pesanan -->
    <div class="bg-white shadow-md rounded my-6">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">ID Order</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Nama User</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Judul Buku</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Total Bayar</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Status</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Tanggal Order</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach($order as $item)
                    <tr>
                        <td class="text-left py-3 px-4">{{ $item->id_order }}</td>
                        <td class="text-left py-3 px-4">{{ $item->user->name }}</td>
                        <td class="text-left py-3 px-4">{{ $item->buku->judul_buku }}</td>
                        <td class="text-left py-3 px-4">Rp{{ number_format($item->total_bayar, 0, ',', '.') }}</td>
                        <td class="text-left py-3 px-4">
                            @if($item->status_order == 'Dibayar')
                                <span class="bg-green-500 text-white py-1 px-2 rounded text-xs">Dibayar</span>
                            @else
                                <span class="bg-red-500 text-white py-1 px-2 rounded text-xs">{{ $item->status_order }}</span>
                            @endif
                        </td>
                        <td class="text-left py-3 px-4">{{ date('d M Y', strtotime($item->created_at)) }}</td>
                        <td class="text-left py-3 px-4">
                            <a href="">Aksi nanti</a>
                            {{-- <a href="{{ route('admin.order.show', $item->id_order) }}" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Detail</a>
                            <form action="{{ route('admin.order.delete', $item->id_order) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600">Hapus</button>
                            </form> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
