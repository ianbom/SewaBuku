@extends('sewa_buku.layouts.userApp')

@section('title')
    Daftar Order Saya
@endsection

@section('content')
<div class="container mx-auto p-10" >
    <h1 class="text-3xl font-bold text-center mb-8">Daftar Order Saya</h1>

    @if($order->isEmpty())
        <!-- Pesan jika tidak ada order -->
        <p class="text-center text-gray-500 text-lg">Belum ada order yang dilakukan.</p>
    @else
        <!-- Tabel Order -->
        <div class="overflow-x-auto shadow-md rounded-lg">
            <table class="min-w-full bg-white rounded-lg overflow-hidden">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 uppercase text-sm font-semibold">
                        <th class="py-3 px-4 text-left">ID Order</th>
                        <th class="py-3 px-4 text-left">Nama Paket</th>
                        <th class="py-3 px-4 text-left">Total Bayar</th>
                        <th class="py-3 px-4 text-left">Status</th>
                        <th class="py-3 px-4 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order as $o)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <!-- ID Order -->
                            <td class="py-3 px-4 border-b">{{ $o->id_order }}</td>

                            <!-- Nama Paket -->
                            <td class="py-3 px-4 border-b">{{ $o->paketLangganan->nama_paket ?? '-' }}</td>

                            <!-- Total Bayar -->
                            <td class="py-3 px-4 border-b">Rp{{ number_format($o->total_bayar, 0, ',', '.') }}</td>

                            <!-- Status Order -->
                            <td class="py-3 px-4 border-b">
                                @if($o->status_order === 'Proses')
                                    <span class="inline-block bg-yellow-100 text-yellow-700 py-1 px-2 rounded text-sm font-semibold">{{ $o->status_order }}</span>
                                @elseif($o->status_order === 'Selesai')
                                    <span class="inline-block bg-green-100 text-green-700 py-1 px-2 rounded text-sm font-semibold">{{ $o->status_order }}</span>
                                @else
                                    <span class="inline-block bg-red-100 text-red-700 py-1 px-2 rounded text-sm font-semibold">{{ $o->status_order }}</span>
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td class="py-3 px-4 border-b">
                                <a href="{{ route('user.order.show', $o->id_order) }}"
                                   class="inline-block bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
