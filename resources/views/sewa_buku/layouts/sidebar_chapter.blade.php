<link href="https://fonts.googleapis.com/css2?family=Inter:wght@600;700&display=swap" rel="stylesheet">

<div class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <aside class="w-64 bg-white flex flex-col border-r border-[#D3E9FF]">



        <!-- Menu -->
        <nav class="flex-1 px-4 py-6 space-y-6">
            <div>
                <h3 class="text-gray-400 text-sm font-semibold uppercase mb-3 mt-14">Chapters </h3>
                <ul>
                    @foreach ($buku->detailBuku as $detail)
                    @if ($detail->is_free_detail == true)
                            <li class="mb-2">
                                <a href="{{ route('user.buku.bacaBab', $detail->id_detail_buku) }}"
                                   class="flex items-center justify-between px-4 py-2 hover:bg-[#F1F8FF]">
                                    <span class="{{ $detail->dibaca && $detail->dibaca->first() && $detail->dibaca->first()->is_read ? 'text-[#1E90FF]' : 'text-[#979797]' }}">
                                        {{ $detail->bab }}
                                    </span>
                                </a>
                                <hr class="border-t-1 border-[#1E90FF]">
                            </li>
                        @else
                            @if ($checkLangganan)
                            <li class="mb-2">
                                <a href="{{ route('user.buku.bacaBab', $detail->id_detail_buku) }}"
                                   class="flex items-center justify-between px-4 py-2 hover:bg-[#F1F8FF]">
                                    <span class="{{ $detail->dibaca && $detail->dibaca->first() && $detail->dibaca->first()->is_read ? 'text-[#1E90FF]' : 'text-[#979797]' }}">
                                        {{ $detail->bab }}
                                    </span>
                                </a>
                                <hr class="border-t-1 border-[#1E90FF]">
                            </li>
                            @else
                            <li class="mb-2">
                                <a href="#"
                                   class="flex items-center justify-between px-4 py-2 hover:bg-[#F1F8FF]">
                                    <span class=""> Berlangganan untuk membaca</span>

                                </a>
                                <hr class="border-t-1 border-[#1E90FF]">
                            </li>
                            @endif
                    @endif

                @endforeach

                {{-- @foreach ($buku->detailBuku as $detail)
                <li class="mb-2">
                    <a href="{{ route('user.buku.bacaBab', $detail->id_detail_buku) }}"
                       class="flex items-center px-4 py-2 rounded hover:bg-gray-100">
                        <span class="text-[#979797]">{{ $detail->bab }}</span>

                        @if ($detail->dibaca && $detail->dibaca->first() && $detail->dibaca->first()->is_read)
                        <p>Terakhir dibaca</p>
                    @endif
                    </a>
                    <hr class=" border-t-1 border-[#1E90FF]">

                </li>
            @endforeach --}}

            <div class="flex justify-end mt-6">
                <a href="{{ route('user.buku.show', $detail->id_buku) }}"
                   class="flex items-center gap-1 px-4 py-2 bg-[#1E90FF] font-bold text-xs text-white rounded-[12px] hover:bg-[#D3E9FF] hover:text-[#1E90FF]">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 16" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12L4 8l4-4" />
                    </svg>
                    Kembali
                </a>
            </div>


        </nav>
    </aside>

    <!-- Main Content -->
{{-- <div class="flex-1" style="background-image: url('{{ asset('images/bg.png') }}'); background-size: cover; background-position: center; background-color: white;"> --}}

    @yield('content')
</div>

</div>
