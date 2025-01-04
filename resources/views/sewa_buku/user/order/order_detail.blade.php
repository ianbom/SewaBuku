@extends('sewa_buku.layouts.userApp')

@section('title')
    Detail Order
@endsection

@section('content')
<div class="container mx-auto mt-10 p-10">
    <!-- Judul Halaman -->
    <div class="flex justify-between items-center mb-12">
        <h1 class="text-3xl font-bold text-left text-[052D6E]" style="font-family: 'Libre Baskerville', serif; color: #052D6E;">Detail Pesanan</h1>
    </div>

    <!-- Card Detail Order -->
    <div class="bg-white rounded-3xl p-6 border-2 border-[#1E90FF] style="font-family: 'Libre Baskerville', serif;">
        <!-- Tombol Kembali Icon -->
        <div class="flex items-center mb-5 mt-2">
            <!-- Tombol Kembali Icon -->
            <a href="{{ url()->previous() }}" class="text-[#052D6E] hover:text-[#1E90FF] mr-4">
                <i class="fa fa-angle-left text-xl"></i> <!-- Back Arrow Icon -->
            </a>

            <!-- Judul -->
            <h1 class="text-xl font-bold text-left text-[#052D6E]" style="font-family: 'Inter', sans-serif;">Detail Pesanan</h1>
        </div>

        <!-- Section Order Details -->
        <div class="bg-[#D3E9FF] p-6 rounded-2xl mb-6" style="font-family: 'Inter', sans-serif;">
            <div class="grid grid-cols-1 gap-3">
                 <!-- Id order -->
                <div class="flex justify-between items-start">
                    <h2 class="text-xl font-bold text-[#052D6E]">No. {{ $order->id_order }}</h2>
                </div>

                <!-- Garis Pembatas -->
                <hr class="my-1 border-t-2 border-[#052D6E]">

                <!-- Nama Paket -->
                <div class="flex justify-between items-center">
                    <p class="text-[#052D6E] font-bold">Nama Paket</p>
                    <p class="text-[#979797] font-semibold">{{ $order->nama_paket }}</p>
                </div>

                <!-- Pembeli -->
                <div class="flex justify-between items-center">
                    <p class="text-[#052D6E] font-bold">Nama Pembeli</p>
                    <p class="text-[#979797] font-semibold">{{ $order->user->name }}</p>
                </div>

                <!-- Tanggal Order -->
                <div class="flex justify-between items-center">
                    <p class="text-[#052D6E] font-bold">Tanggal Order</p>
                    <p class="text-[#979797] font-semibold">{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, H:i') }}</p>
                </div>

                {{-- Total Bayar --}}
                <!-- Total Bayar -->
                <div class="flex justify-between items-center">
                    <p class="text-[#052D6E] font-bold">Total Bayar</p>
                    <p class="text-[#979797] font-semibold">Rp{{ number_format($order->total_bayar, 0, ',', '.') }}</p>
                </div>

                <!-- Garis Pembatas -->
                <hr class="my-1 border-t-2 border-[#052D6E]">

               <!-- Status Order -->
                <div class="flex justify-between items-center">
                    <p class="text-[#052D6E] font-bold mb-2">Status Pesanan</p>
                    @if($order->status_order === 'Proses')
                        <span class="py-1 px-2 rounded font-bold text-[#1E90FF]" style="text-transform: uppercase;">{{ $order->status_order }}</span>
                    @elseif($order->status_order === 'Selesai')
                        <span class="py-1 px-2 rounded font-bold text-[#DC3545]" style="text-transform: uppercase;">{{ $order->status_order }}</span>
                    @else
                        <span class="py-1 px-2 rounded font-bold text-[#4DAF84]" style="text-transform: uppercase;">{{ $order->status_order }}</span>
                    @endif
                </div>
            </div>
        </div>


        <!-- Aksi -->
        <div class="flex flex-wrap gap-3 justify-end mt-6">
            <!-- Tombol Kembali -->
            {{-- <a href="{{ url()->previous() }}" class="bg-gray-500 text-white py-2 px-4 rounded-xl shadow-md hover:bg-transparent hover:border-gray-500 hover:text-gray-500 border-2 transition-all duration-300">
                Kembali
            </a> --}}

            <!-- Cetak Invoice -->
            <a href="#" class="px-4 text-bold py-2 bg-[#FCEBCBFF] text-[#FDA403] rounded-[12px] hover:bg-[#FDA403] hover:text-white">
                <strong>Cetak Invoice</strong>
            </a>

            <!-- Tombol Batalkan Order -->
            @if ($order->status_order == 'Proses')
            <form action="{{ route('user.order.batal', $order->id_order) }}" method="POST">
                @csrf
                @method('PUT')
                <button type="submit" class="px-4 text-bold py-2 bg-[#FFCFC2] text-[#E46B61] rounded-[12px] hover:bg-[#E46B61] hover:text-white">
                    <strong>Batalkan Pesanan</strong>
                </button>
            </form>
            @endif

            <!-- Tombol Bayar -->
            @if ($order->status_order == 'Proses')
            <form action="{{ route('user.payment.store', $order->id_order) }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 bg-[#1E90FF] text-bold text-white rounded-[12px] hover:bg-[#D3E9FF] hover:text-[#1E90FF]">
                  <strong>  Bayar Sekarang </strong>
                </button>
            </form>
            @endif
        </div>


        <!-- Section Rating -->
        @if ($order->status_order === 'Selesai')
        <div class="mt-10 border-t pt-6">
            <h3 class="text-xl font-bold mb-4">Berikan Rating untuk Order Ini:</h3>
            @if ($rating)
                <!-- Tampilkan Rating Jika Sudah Ada -->
                <div class="mb-4">
                    <p class="text-gray-700 font-semibold">Rating:</p>
                    <p class="text-yellow-500">{{ $rating->rating }} / 5</p>
                </div>
                @if ($rating->komentar)
                <div>
                    <p class="text-gray-700 font-semibold">Komentar:</p>
                    <p class="text-gray-900">{{ $rating->komentar }}</p>
                </div>
                @endif
            @else
                <!-- Form untuk Memberikan Rating -->
                <form action="{{ route('user.rating.store', $order->id_order) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Rating (1-5):</label>
                        <select name="rating" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Komentar:</label>
                        <textarea name="komentar" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200"></textarea>
                    </div>
                    <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded shadow-md hover:bg-green-600">
                        Submit Rating
                    </button>
                </form>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection
