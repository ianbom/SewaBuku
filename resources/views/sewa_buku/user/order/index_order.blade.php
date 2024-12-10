@extends('sewa_buku.layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <h1 class="text-3xl font-bold text-center mb-8">Daftar Order Saya</h1>

    @if($order->isEmpty())
        <p class="text-center text-gray-500">Belum ada order yang dilakukan.</p>
    @else
        <!-- Tabel untuk menampilkan semua order -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="py-3 px-6 text-left font-medium text-gray-600 uppercase tracking-wider">ID Order</th>
                        <th class="py-3 px-6 text-left font-medium text-gray-600 uppercase tracking-wider">Nama Paket</th>
                        <th class="py-3 px-6 text-left font-medium text-gray-600 uppercase tracking-wider">Total Bayar</th>
                        <th class="py-3 px-6 text-left font-medium text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="py-3 px-6 text-left font-medium text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order as $o)
                        <tr class="border-b">
                            <td class="py-3 px-6">{{ $o->id_order }}</td>
                            <td class="py-3 px-6">
                                <!-- Menampilkan judul buku yang diorder -->

                                 <span> {{ $o->paketLangganan->nama_paket ?? '-'}} </span>


                            </td>
                            <td class="py-3 px-6">Rp{{ number_format($o->total_bayar, 0, ',', '.') }}</td>
                            <td class="py-3 px-6">
                                @if($o->status_order === 'Proses')
                                    <span class="text-yellow-500 font-semibold">{{ $o->status_order }}</span>
                                @elseif($o->status_order === 'Selesai')
                                    <span class="text-green-500 font-semibold">{{ $o->status_order }}</span>
                                @else
                                    <span class="text-red-500 font-semibold">{{ $o->status_order }}</span>
                                @endif
                            </td>
                            <td class="py-3 px-6">
                                <a href="{{ route('user.order.show', $o->id_order) }}" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
