<!-- Informasi Buku -->
<div class="w-full px-6 sm:px-12 py-6 bg-white">
    @php
    $colorPairs = [
        ['bg' => '#FFE8E2', 'text' => '#DD7971'],
        ['bg' => '#EBE4FF', 'text' => '#8F7CC1'],
        ['bg' => '#D3E9FF', 'text' => '#1E90FF'],
        ['bg' => '#FAFAD8', 'text' => '#B79F54']
    ];


    // dummy ya datanya
    $parentTags = [
        (object) [
            'nama_tags' => 'Kategori A',
            'child' => [
                (object) ['nama_tags' => 'Tag 1'],
                (object) ['nama_tags' => 'Tag 2'],
                (object) ['nama_tags' => 'Tag 3']
            ]
        ],

    ];
    @endphp





    <div class="bg-[#F1F8FF] rounded-[16px] py-6 px-6 grid grid-cols-12 gap-6 sm:gap-8">
        <!-- Kolom Kiri - Gambar Buku -->
        <div class="col-span-12 sm:col-span-3">
            @if ($buku->coverBuku && $buku->coverBuku->count() > 0)
                <img src="{{ asset('storage/' . $buku->coverBuku->first()->file_image) }}"
                    alt="Cover Buku"
                    class="w-full aspect-square object-cover rounded-[16px] ">
            @endif
        </div>

        <!-- Kolom Kanan - Informasi Buku -->
        <div class="col-span-12 sm:col-span-9 flex flex-col">
            <h2 class="text-5xl font-bold text-[#052D6E] mb-8" style="font-family: 'Libre Baskerville', serif;">
                {{ $buku->judul_buku }}
            </h2>
            <p class="text-2xl text-[#979797] font-medium mb-4">
                AUTHOR - {{ $buku->penulis }} / PUBLISHER - {{ $buku->penerbit }}
            </p>

            <!-- Rating -->
            <div class="flex items-center gap-2 mb-8">
                <span class="text-lg font-semibold text-[#979797]">4.09</span>
                <div class="flex">
                    <span class="text-[#B79F54] text-2xl">★</span>
                    <span class="text-[#B79F54] text-2xl">★</span>
                    <span class="text-[#B79F54] text-2xl">★</span>
                    <span class="text-[#B79F54] text-2xl">★</span>
                    <span class="text-[#DCDCB7FF] text-2xl">★</span>
                </div>
                <span class="text-lg font-semibold text-[#979797]">ratings</span>

            </div>

            <!-- Tags -->
            @foreach ($parentTags as $parentTag)
                <div class="flex flex-wrap gap-4">
                    @foreach ($parentTag->child as $index => $item)
                        @php
                            $color = $colorPairs[$index % count(value: $colorPairs)];
                        @endphp
                        <a href="#" class="px-8 py-3 rounded-[16px]"
                            style="background-color: {{ $color['bg'] }}; color: {{ $color['text'] }};">
                            <strong> {{ $item->nama_tags }} </strong>
                        </a>
                    @endforeach
                </div>
            @endforeach

            <!-- Button Listen -->
            <div class="mt-10">
                <button class="flex items-center px-6 py-3 text-white rounded-full"
                    style="background-color: #1E90FF;">
                    <div class="w-8 h-8 flex items-center justify-center bg-white rounded-full mr-2">
                        <svg class="w-5 h-5 fill-current text-[#1E90FF]" viewBox="0 0 24 24">
                            <path d="M5 3v18l15-9z"></path>
                        </svg>
                    </div>
                    Listen
                </button>
            </div>

        </div>

    </div>
</div>

<!-- Container Utama -->
<div class="flex flex-col sm:flex-row h-screen px-6 sm:px-12 py-6 bg-white">
    <!-- Sidebar Chapter -->
    <aside id="logo-sidebar" class="w-full sm:w-64 bg-[#F1F8FF] rounded-[16px] p-4 sm:mr-6 mb-6 sm:mb-0 overflow-y-auto max-h-screen">
        <nav>
            <h3 class="text-gray-400 text-sm font-semibold uppercase mb-3">Poin Utama</h3>
            <ul>
                @foreach ($buku->detailBuku as $detail)
                    <li class="mb-2">
                        <a href="#bab-{{ $detail->id_detail_buku }}" class="block px-4 py-2 hover:bg-[#E0F0FF] rounded-md">
                            <span class="{{ $detail->dibaca?->first()?->is_read ? 'text-[#1E90FF]' : 'text-[#979797]' }}">
                                {{ $detail->bab }}
                            </span>
                        </a>
                        <hr class="border-[#1E90FF]">
                    </li>
                @endforeach
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto p-6 sm:p-8 bg-white">
        @foreach ($buku->detailBuku as $detail)
            <div id="bab-{{ $detail->id_detail_buku }}" class="mb-12">
                <h2 class="text-lg sm:text-xl font-bold text-[#052D6E] mb-4">{{ $detail->bab }}</h2>
                <p class="text-[#979797] leading-relaxed">{{ $detail->isi }}</p>
            </div>

            <!-- Chapter Audio -->
            <div class="mb-8">
                @if (!empty($detailBuku->audio))
                    <audio controls class="w-full bg-[#D3E9FF] rounded-lg px-4 py-2">
                        <source src="{{ asset('storage/' . $detailBuku->audio) }}" type="audio/mpeg">
                        Your browser does not support the audio player.
                    </audio>
                @else
                    <p class="text-[#E46B61] py-2">No audio available for this chapter</p>
                @endif
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between p-4 border border-[#1E90FF] rounded-lg mt-10 mb-8">
                @if ($quiz)
                    <h3 class="text-lg font-medium text-[#052D6E] w-full sm:w-auto">
                        Quiz: {{ $quiz->nama_quiz }}
                    </h3>
                    <div class="flex flex-col sm:flex-row items-center space-x-0 sm:space-x-8 w-full sm:w-auto">
                        @if ($quizScore)
                            <button class="bg-[#1E90FF] text-white py-2 px-4 text-sm rounded-lg">
                                Score: {{ $quizScore }}
                            </button>
                        @endif
                        <a href="{{ route('user.quiz.kerjakan', $detailBuku->id_detail_buku) }}"
                        class="bg-[#052D6E] text-white text-sm text-center py-2 px-4 rounded-lg hover:bg-[#AFC4E7FF] hover:text-[#052D6E] transition">
                            {{ $quizScore ? 'Retake Quiz' : 'Take Quiz' }}
                        </a>
                    </div>
                @else
                    <h2 class="text-lg font-bold text-[#052D6E]">No Quiz Available</h2>
                @endif
            </div>

            <style>
                .hidden {
                    display: none;
                }

                #custom-context-menu {
                    min-width: 150px;
                }
            </style>

            <div id="custom-context-menu"
                 class="hidden absolute bg-white shadow-lg border-2 rounded-md z-50"
                 style="padding: 10px; border-color: #052D6E; background-color: #CFE2FF; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <ul style="list-style: none; margin: 0; padding: 0; font-family: 'Inter', sans-serif; font-size: 14px; color: #0c3c78;">
                    <li id="copy-text"
                        class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
                        style="padding: 8px 16px; margin-bottom: 4px; border-radius: 8px; transition: background-color 0.3s ease; display: flex; align-items: center; gap: 8px;">
                        <span class="material-icons" style="font-size: 16px; font-weight:700; color: #052D6E;">content_copy</span>
                        <strong>Copy</strong>
                    </li>
                    <li id="highlight-text"
                        class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
                        style="padding: 8px 16px; border-radius: 8px; transition: background-color 0.3s ease; display: flex; align-items: center; gap: 8px;">
                        <span class="material-icons" style="font-size: 16px; font-weight:700; color: #052D6E;">highlight</span>
                        <strong>Highlight</strong>
                    </li>
                </ul>
            </div>

            <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const isiBab = document.getElementById('isiBab');
                    const contextMenu = document.getElementById('custom-context-menu');
                    let selectedText = '';

                    function showContextMenu(e) {
                        e.preventDefault();
                        selectedText = window.getSelection().toString().trim();

                        if (selectedText) {
                            contextMenu.style.top = `${e.pageY}px`;
                            contextMenu.style.left = `${e.pageX}px`;
                            contextMenu.classList.remove('hidden');
                        }
                    }

                    function hideContextMenu() {
                        contextMenu.classList.add('hidden');
                    }

                    isiBab.addEventListener('contextmenu', showContextMenu);
                    document.addEventListener('click', (e) => {
                        if (!contextMenu.contains(e.target)) {
                            hideContextMenu();
                        }
                    });

                    document.getElementById('copy-text').addEventListener('click', function () {
                        navigator.clipboard.writeText(selectedText).then(() => {
                            alert('Text successfully copied!');
                        });
                        hideContextMenu();
                    });

                    // Function to highlight the selected text
                    document.getElementById('highlight-text').addEventListener('click', function () {
                        const idBuku = '{{ $detailBuku->id_buku }}';
                        const idDetailBuku = '{{ $detailBuku->id_detail_buku }}';

                        fetch('{{ route('user.highlight.text') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                highlight: selectedText,
                                id_buku: idBuku,
                                id_detail_buku: idDetailBuku
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.highlight) {
                                alert('Text successfully highlighted!');
                            } else {
                                alert('Failed to highlight text.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred while highlighting the text.');
                        });

                        hideContextMenu();
                    });
                });
            </script>
            
        @endforeach
    </main>
</div>






{{-- <div class="flex h-screen bg-gray-100">
    <button
        data-drawer-target="logo-sidebar"
        data-drawer-toggle="logo-sidebar"
        aria-controls="logo-sidebar"
        type="button"
        class="flex items-start bg-white fixed inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
        >
        <span class="sr-only">Open sidebar</span>
        <svg
            class="w-6 h-6"
            aria-hidden="true"
            fill="currentColor"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
            clip-rule="evenodd"
            fill-rule="evenodd"
            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"
            ></path>
        </svg>
    </button>
    <!-- Sidebar -->
    <aside
        id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0  bg-white"
        aria-label="Sidebar"
    >
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

            {{-- <div class="flex justify-end mt-6">
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
    <div class="flex-1 sm:ml-64 bg-white">
        @yield('content')
    </div>
</div> --}}
