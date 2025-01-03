<link href="https://fonts.googleapis.com/css2?family=Inter:wght@600;700&display=swap" rel="stylesheet">

<div class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md flex flex-col">
        <!-- Logo -->
        <div class="py-4">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-32 h-auto ml-2">
        </div>


        <!-- Menu -->
        <nav class="flex-1 px-4 py-6 space-y-6">
            <div>
                <h3 class="text-gray-400 text-sm font-semibold uppercase mb-3">Chapters </h3>
                <ul>
                    @foreach ($buku->detailBuku as $detail)
                        <li class="mb-2">
                            <a href="{{ route('user.buku.bacaBab', $detail->id_detail_buku) }}"
                               class="flex items-center px-4 py-2 rounded hover:bg-gray-100">
                                <span class="text-gray-700">{{ $detail->bab }}</span>

                                @if ($detail->dibaca && $detail->dibaca->first() && $detail->dibaca->first()->is_read)
                                <p>Terakhir dibaca</p>
                            @endif
                            </a>
                            <hr class=" border-t-1 border-[#1E90FF]">

                        </li>
                    @endforeach
                    <a href="{{ route('user.buku.show', $detail->id_buku) }}" class="bg-blue-200 rounded-md p-2 mt-4"> Back</a>
                </ul>
            </div>

        </nav>
    </aside>

    <!-- Main Content -->
{{-- <div class="flex-1" style="background-image: url('{{ asset('images/bg.png') }}'); background-size: cover; background-position: center; background-color: white;"> --}}

    @yield('content')
</div>

</div>
