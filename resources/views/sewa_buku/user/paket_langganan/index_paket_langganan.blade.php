@extends('sewa_buku.layouts.userApp')

@section('content')

    <head>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: 'Inter', sans-serif;
            }
        </style>
    </head>
    @php
        // Array of available images
        $images = [asset('images/paket1.png'), asset('images/paket2.png'), asset('images/paket3.png')];
    @endphp

    <div class="container mx-auto mt-10 p-10">

        <!-- Page Title -->
        <div class="flex justify-between items-center mb-12">
            <h1 class="text-3xl font-bold text-left text-[052D6E]"
                style="font-family: 'Libre Baskerville', serif; color: #052D6E;">Subscription Packages</h1>
        </div>

        <!-- Package Cards -->
        @if ($paketLangganan->isEmpty())
            <p class="text-[#E46B61] py-2">No subscription packages available</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($paketLangganan as $paket)
                    @php
                        // Select a random image
                        $randomImage = $images[array_rand($images)];
                    @endphp
                    <div class="bg-[#1E90FF] rounded-[16px] p-6 text-white">
                        <!-- Random Image -->
                        <div class="mb-4">
                            <img src="{{ $randomImage }}" alt="Package Image" class="rounded-lg w-full h-50 object-cover">
                        </div>

                        <h3 class="text-[16px] font-bold mb-2">{{ $paket->nama_paket }}</h3>
                        <p class="mb-6 text-[14px] text-white">{{ $paket->deskripsi }}</p>

                        <!-- Time and Price -->
                        <div class="flex justify-between items-center mb-6 p-3 border rounded-[8px] flex-wrap">
                            <div class="flex items-center space-x-2 w-full sm:w-auto">
                                <span class="text-[14px]">Duration: {{ $paket->masa_waktu }} Days</span>
                            </div>
                            <div class="text-[16px] font-bold w-full sm:w-auto">
                                <span>Rp. {{ number_format($paket->harga, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        @if ($paket->is_active)
                            <button type="button"
                                class="w-full bg-[#D3E9FF] text-[#1E90FF] py-4 rounded-[12px] font-bold hover:bg-white transition"
                                onclick="showModal('{{ route('user.order.store', $paket->id_paket_langganan) }}', '{{ $paket->nama_paket }}')">
                                Subscribe Now
                            </button>
                        @else
                            <p class="text-[#E46B61] text-center py-2">Package not available</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Modal -->
        <div id="orderModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
            <div class="bg-white rounded-[16px] p-6 w-[90%] sm:w-[80%] md:max-w-md">
                <h3 class="text-[16px] font-bold text-[#052D6E] mb-4" style="font-family: 'Inter', sans-serif;">Subscription
                    Confirmation</h3>
                <p class="text-[#979797] mb-6 text-[14px]" style="font-family: 'Inter', sans-serif;">
                    Are you sure you want to purchase <span id="modalPackageName" class="font-bold"></span>?
                </p>
                <div class="flex flex-col sm:flex-row justify-end sm:space-x-4 space-y-4 sm:space-y-0">
                    <button type="button"
                        class="px-4 py-2 text-bold bg-[#FFCFC2] text-[#E46B61] rounded-[12px] hover:bg-[#E46B61] hover:text-white"
                        onclick="closeModal()">
                        <strong>Cancel</strong>
                    </button>
                    <a id="btn_confirm_order" href=""
                        class="px-4 py-2 bg-[#1E90FF] text-bold text-white rounded-[12px] hover:bg-[#D3E9FF] hover:text-[#1E90FF]">
                        <strong>Confirm</strong>
                    </a>
                </div>
            </div>
        </div>


        <script>
            function showModal(actionUrl, packageName) {
                document.getElementById('btn_confirm_order').href = actionUrl;
                document.getElementById('modalPackageName').textContent = packageName;
                document.getElementById('orderModal').classList.remove('hidden');
            }

            function closeModal() {
                document.getElementById('orderModal').classList.add('hidden');
            }
        </script>
    @endsection
