<!-- Informasi Buku -->
<div class="w-full px-6 sm:px-12 py-6 bg-white">
    @php
        $colorPairs = [
            ['bg' => '#FFE8E2', 'text' => '#DD7971'],
            ['bg' => '#EBE4FF', 'text' => '#8F7CC1'],
            ['bg' => '#D3E9FF', 'text' => '#1E90FF'],
            ['bg' => '#FAFAD8', 'text' => '#B79F54'],
        ];

        // dummy ya datanya
        $parentTags = [
            (object) [
                'nama_tags' => 'Kategori A',
                'child' => [
                    (object) ['nama_tags' => 'Tag 1'],
                    (object) ['nama_tags' => 'Tag 2'],
                    (object) ['nama_tags' => 'Tag 3'],
                ],
            ],
        ];
    @endphp

    <div class="bg-[#F1F8FF] rounded-[16px] py-6 px-6 grid grid-cols-12 gap-6 sm:gap-8">
        <!-- Kolom Kiri - Gambar Buku -->
        <div class="col-span-12 sm:col-span-3">
            @if ($buku->coverBuku && $buku->coverBuku->count() > 0)
                <img src="{{ asset('storage/' . $buku->coverBuku->first()->file_image) }}" alt="Cover Buku"
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
                <button class="flex items-center px-6 py-3 text-white rounded-full" style="background-color: #1E90FF;">
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
    <aside id="logo-sidebar"
        class="w-full sm:w-64 bg-[#F1F8FF] rounded-[16px] p-4 sm:mr-6 mb-6 sm:mb-0 overflow-y-auto max-h-screen">
        <nav>
            <h3 class="text-gray-400 text-sm font-semibold uppercase mb-3">Poin Utama</h3>
            <ul>
                @foreach ($buku->detailBuku as $detail)
                    <li class="mb-2">
                        <a href="#bab-{{ $detail->id_detail_buku }}"
                            class="block px-4 py-2 hover:bg-[#E0F0FF] rounded-md">
                            <span>
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

            {{-- <div
                class="flex flex-col sm:flex-row items-center justify-between p-4 border border-[#1E90FF] rounded-lg mt-10 mb-8">
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
            </div> --}}

            <style>
                .hidden {
                    display: none;
                }

                #custom-context-menu {
                    min-width: 150px;
                }
            </style>

            <div id="custom-context-menu" class="hidden absolute bg-white shadow-lg border-2 rounded-md z-50"
                style="padding: 10px; border-color: #052D6E; background-color: #CFE2FF; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <ul
                    style="list-style: none; margin: 0; padding: 0; font-family: 'Inter', sans-serif; font-size: 14px; color: #0c3c78;">
                    <li id="copy-text" class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
                        style="padding: 8px 16px; margin-bottom: 4px; border-radius: 8px; transition: background-color 0.3s ease; display: flex; align-items: center; gap: 8px;">
                        <span class="material-icons"
                            style="font-size: 16px; font-weight:700; color: #052D6E;">content_copy</span>
                        <strong>Copy</strong>
                    </li>
                    <li id="highlight-text" class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
                        style="padding: 8px 16px; border-radius: 8px; transition: background-color 0.3s ease; display: flex; align-items: center; gap: 8px;">
                        <span class="material-icons"
                            style="font-size: 16px; font-weight:700; color: #052D6E;">highlight</span>
                        <strong>Highlight</strong>
                    </li>
                </ul>
            </div>

            <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // const isiBab = document.getElementById('isiBab');
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

                    // isiBab.addEventListener('contextmenu', showContextMenu);
                    document.addEventListener('click', (e) => {
                        if (!contextMenu.contains(e.target)) {
                            hideContextMenu();
                        }
                    });

                    document.getElementById('copy-text').addEventListener('click', function() {
                        navigator.clipboard.writeText(selectedText).then(() => {
                            alert('Text successfully copied!');
                        });
                        hideContextMenu();
                    });

                    // Function to highlight the selected text
                    document.getElementById('highlight-text').addEventListener('click', function() {
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

                    const sections = document.querySelectorAll("main > div[id^='bab-']");
                    const navLinks = document.querySelectorAll("nav ul li a span");

                    function markAsRead(activeIndex) {
                        navLinks.forEach((link, index) => {
                            if (index === activeIndex) {
                                link.classList.remove("text-[#979797]");
                                link.classList.add("text-[#1E90FF]");
                            } else {
                                link.classList.remove("text-[#1E90FF]");
                                link.classList.add("text-[#979797]");
                            }
                        });
                    }

                    function updateActiveSection() {
                        let scrollPosition = window.scrollY;
                        let offset = window.innerHeight / 3; // Adjust threshold for better accuracy

                        sections.forEach((section, index) => {
                            const sectionTop = section.offsetTop - offset;
                            const sectionBottom = sectionTop + section.offsetHeight;

                            if (scrollPosition >= sectionTop && scrollPosition < sectionBottom) {
                                markAsRead(index)
                            }
                        });
                    }

                    // Event listener for scrolling
                    window.addEventListener("scroll", updateActiveSection);

                    // Event listener for clicks on nav items
                    navLinks.forEach((link, index) => {
                        link.parentElement.addEventListener("click", function() {
                            markAsRead(index);
                        });
                    });
                });
            </script>
        @endforeach
    </main>
</div>
