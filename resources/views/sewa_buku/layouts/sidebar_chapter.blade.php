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
                    <span class="text-[#B79F54] text-2xl exclude-color">★</span>
                    <span class="text-[#B79F54] text-2xl exclude-color ">★</span>
                    <span class="text-[#B79F54] text-2xl exclude-color">★</span>
                    <span class="text-[#B79F54] text-2xl exclude-color">★</span>
                    <span class="text-[#DCDCB7FF] text-2xl exclude-color">★</span>
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
                        <a href="#" class="px-8 py-3 rounded-[16px] bg-[{{ $color['bg'] }}]">
                            <strong class="text-[{{ $color['text'] }}] exclude-color"> {{ $item->nama_tags }} </strong>
                        </a>
                    @endforeach
                </div>
            @endforeach

            <!-- Button Listen -->
            <div class="mt-10">
                <button class="flex items-center px-6 py-3 text-white rounded-full bg-[#1E90FF]">
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
        <div class="bg-[#F1F8FF] rounded-[16px] py-6 px-6">
            <nav class="w-full  py-2 px-2" aria-label="breadcrumb">
                <ol class="flex flex-wrap items-center text-sm sm:text-base text-gray-500">
                    <li>
                        <a href="{{ route('user.buku.show', $buku->id_buku) }}"
                            class="text-[#1E90FF] font-semibold hover:underline exclude-color">Kembali</a>
                        <span class=" text-[#052D6E]">/</span>
                    </li>
                    <li class="text-[#052D6E]">
                        {{ $buku->judul_buku }}
                    </li>
                </ol>
                <!-- Settings Panel -->
                <div class="mt-4 mb-6">
                    <button id="toggle-settings"
                        class="flex items-center gap-2 px-4 py-2 rounded-md bg-[#1E90FF] text-white font-semibold focus:outline-none">
                        <span class="material-icons" id="settings-icon">expand_more</span>
                        Text Settings
                    </button>

                    <div id="settings-panel" class="mt-4 hidden transition-all duration-300 ease-in-out items-center">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="flex items-center gap-2">
                                {{-- <span class="text-[#052D6E] font-semibold">Font Size:</span> --}}
                                <button class="font-size-toggle px-3 py-1 rounded-full bg-[#1E90FF] text-white text-sm"
                                    data-size="small">
                                    Aa
                                </button>
                                <button
                                    class="font-size-toggle px-3 py-1 rounded-full bg-[#1E90FF] text-white text-base"
                                    data-size="medium">
                                    Aa
                                </button>
                                <button class="font-size-toggle px-3 py-1 rounded-full bg-[#1E90FF] text-white text-lg"
                                    data-size="large">
                                    Aa
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="flex items-center gap-2">
                                {{-- <span class="text-[#052D6E] font-semibold">Background Color:</span> --}}
                                <button class="bg-color-toggle w-8 h-8 rounded-full bg-white border-2 border-[#052D6E]"
                                    data-bg="white" data-color-text="#03314B" data-hover-color="#E0F0FF"></button>
                                <button
                                    class="bg-color-toggle w-8 h-8 rounded-full bg-[#fff3d7] border-2 border-[#052D6E]"
                                    data-bg="#fff3d7" data-color-text="#03314B" data-hover-color="#E0F0FF"></button>
                                <button
                                    class="bg-color-toggle w-8 h-8 rounded-full bg-[#03314B] border-2 border-green hover:border-green"
                                    data-bg="#03314B" data-color-text="#FFFFFF" data-hover-color="#1E90FF"></button>
                            </div>
                        </div>
                    </div>
                </div>


            </nav>
            <hr class="mb-10 border-[#1E90FF]">

            <nav>
                <h3 class="text-gray-400 text-sm font-semibold uppercase mb-3">Poin Utama</h3>
                <ul>
                    @foreach ($buku->detailBuku as $detail)
                        <li class="mb-2 text-[#03314B] ">
                            <a href="#bab-{{ $detail->id_detail_buku }}"
                                class="block px-4 py-2 hover:bg-[#E0F0FF] rounded-md exclude-color">
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
    <main class="flex-1 overflow-y-auto p-6 sm:p-8 bg-white" id="scrollspy">
        @foreach ($buku->detailBuku as $detail)
            <div id="bab-{{ $detail->id_detail_buku }}" class="mb-12">
                <h2 class="text-lg sm:text-xl font-bold text-[#052D6E] mb-4">{{ $detail->bab }}</h2>
                <p class="text-[#979797] leading-relaxed" style="text-align: justify;">{{ $detail->isi }}</p>
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
                    const navLinks_anchor = document.querySelectorAll("nav ul li a");
                    const main_content = document.getElementById("scrollspy")

                    function markAsRead(activeIndex) {
                        navLinks_anchor.forEach((link, index) => {
                            if (index === activeIndex) {
                                link.classList.add('bg-[#1E90FF]');
                                // link.classList.remove("text-[#979797]");
                                // link.classList.add("text-[#1E90FF]");
                            } else {
                                link.classList.remove('bg-[#1E90FF]');
                                // link.classList.remove("text-[#1E90FF]");
                                // link.classList.add("text-[#979797]");
                            }
                        });
                    }
                    // console.log(sections)
                    function updateActiveSection() {
                        let currentSection = "";

                        sections.forEach(section => {
                            const sectionTop = section.offsetTop - main_content.offsetTop;
                            const sectionHeight = section.clientHeight;
                            // console.log(main_content.scrollTop, sectionTop, sectionHeight)
                            if (main_content.scrollTop >= section.offsetTop - sectionHeight / 3) {
                                // console.log(main_content.scrollTop, sectionTop, sectionHeight)
                                currentSection = section.getAttribute("id");
                            }
                        });
                        navLinks_anchor.forEach(link => {
                            link.classList.remove('bg-[#1E90FF]');
                            // link.setProperty('background-color', bgColor, 'important');
                            // link.classList.remove("text-[#1E90FF]");
                            // link.classList.remove("exclude-color");
                            // link.classList.add("text-[#979797]");
                            // link.classList.add("exclude-color");

                            if (link.getAttribute("href").slice(1) === currentSection) {
                                // link.classList.remove('bg-[#1E90FF]');
                                link.classList.add('bg-[#1E90FF]');
                                // link.classList.remove("text-[#979797]");
                                // link.classList.remove("exclude-color");
                                // link.classList.add("text-[#1E90FF]");
                                // link.classList.add("exclude-color");
                            }
                        });
                    }

                    function scrollToHashFromURL() {
                        const hash = window.location.hash; // Get hash from URL
                        if (hash) {
                            const targetSection = document.querySelector(hash);
                            if (targetSection) {
                                setTimeout(() => {
                                    targetSection.scrollIntoView({
                                        behavior: "smooth",
                                        block: "start"
                                    });
                                    markAsRead([...sections].indexOf(
                                        targetSection)); // Update nav highlight
                                }, 100); // Delay to ensure DOM is fully loaded
                            }
                        }
                    }

                    // Scroll event listener
                    main_content.addEventListener("scroll", updateActiveSection);

                    // Event listener for clicks on nav items
                    navLinks.forEach((link, index) => {
                        link.parentElement.addEventListener("click", function() {
                            markAsRead(index);
                        });
                    });
                    scrollToHashFromURL();

                    const body = document.body;
                    const allMains = document.querySelectorAll('main');
                    const allAside = document.querySelectorAll('aside');
                    const allDivs = document.querySelectorAll('div');
                    const mainContent = document.querySelector('main#scrollspy');
                    const fontSizeButtons = document.querySelectorAll('.font-size-toggle');
                    const bgColorButtons = document.querySelectorAll('.bg-color-toggle');
                    const toggleButton = document.getElementById('toggle-settings');
                    const settingsPanel = document.getElementById('settings-panel');
                    const settingsIcon = document.getElementById('settings-icon');

                    // Toggle Settings Panel
                    toggleButton.addEventListener('click', () => {
                        settingsPanel.classList.toggle('hidden');

                        if (settingsPanel.classList.contains('hidden')) {
                            settingsIcon.innerText = 'expand_more';
                        } else {
                            settingsIcon.innerText = 'expand_less';
                        }
                    });

                    // Font Size Toggle
                    fontSizeButtons.forEach(button => {
                        button.addEventListener('click', () => {
                            const size = button.getAttribute('data-size');
                            mainContent.classList.remove('text-sm', 'text-base', 'text-lg');

                            if (size === 'small') {
                                mainContent.classList.add('text-sm');
                            } else if (size === 'medium') {
                                mainContent.classList.add('text-base');
                            } else if (size === 'large') {
                                mainContent.classList.add('text-lg');
                            }
                        });
                    });

                    // Background Color Toggle
                    bgColorButtons.forEach(button => {
                        button.addEventListener('click', () => {
                            const bgColor = button.getAttribute('data-bg');
                            const textColor = button.getAttribute('data-color-text');
                            const hoverColor = button.getAttribute('data-hover-color');
                            body.style.setProperty('background-color', bgColor, 'important');
                            body.style.setProperty('--custom-text-color', textColor);
                            body.classList.add('use-custom-text-color');
                            document.querySelectorAll('.exclude-color').forEach((el) => {
                                el.setAttribute('data-exclude-color', 'true');
                            });
                            // Apply background color to all divs with !important
                            allDivs.forEach(div => {
                                div.style.setProperty('background-color', bgColor, 'important');
                            });
                            allMains.forEach(div => {
                                div.style.setProperty('background-color', bgColor, 'important');
                            });
                            allAside.forEach(div => {
                                div.style.setProperty('background-color', bgColor, 'important');
                            });
                            navLinks_anchor.forEach(div => {
                                div.classList.remove('hover:bg-[#E0F0FF]');
                                div.classList.add(`hover:bg-[${hoverColor}]`);
                            });
                        });
                    });
                });
            </script>
        @endforeach
    </main>
</div>
