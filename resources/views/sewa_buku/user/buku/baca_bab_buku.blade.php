@extends('sewa_buku.layouts.userBacaBuku')

@section('title')
    {{ $detailBuku->bab ?? 'Read Book Chapter' }}
@endsection

@section('content')

    <head>
        <style>
            .custom-audio {
                background-color: #D3E9FF;
                border-radius: 16px;
                color: #1E90FF !important;
            }

            .custom-audio::-webkit-media-controls-panel {
                background-color: #D3E9FF;
            }

            .custom-audio::-webkit-media-controls-play-button {
                background-color: white;
                border-radius: 50px;
                color: #1E90FF !important;
            }

            .custom-audio::-webkit-media-controls-timeline {
                color: #1E90FF !important;
            }

            .custom-audio::-webkit-media-controls-current-time-display,
            .custom-audio::-webkit-media-controls-time-remaining-display {
                color: #1E90FF !important;
            }

            .floating-btn {
                position: fixed;
                bottom: 20px;
                right: 20px;
                background-color: #052D6E;
                color: white;
                border: none;
                padding: 12px 16px;
                border-radius: 50px;
                font-size: 18px;
                cursor: pointer;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
                transition: background 0.3s ease;
            }

            .floating-btn:hover {
                background-color: #052D6E;
            }

            /* Modal Styles */
            .settings-modal {
                display: none;
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: white;
                padding: 20px;
                border-radius: 12px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
                z-index: 1000;
                width: 90%;
                max-width: 350px;
            }

            .modal-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 999;
            }

            .settings-modal h3 {
                font-size: 18px;
                font-weight: bold;
                color: #052D6E;
                margin-bottom: 10px;
            }

            .modal-close {
                background: red;
                color: white;
                border: none;
                padding: 5px 10px;
                border-radius: 5px;
                cursor: pointer;
                float: right;
            }
        </style>
        <style>
            /* Floating Settings Styles */
            .floating-settings {
                position: fixed;
                bottom: 20px;
                right: 20px;
                background: white;
                border-radius: 12px;
                padding: 10px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
                display: flex;
                flex-direction: column;
                gap: 8px;
                align-items: center;
                z-index: 1000;
            }

            .text-size-btn {
                border: 2px solid #d3d3d3;
                border-radius: 8px;
                width: 40px;
                height: 32px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 14px;
                transition: border 0.3s ease;
            }

            .text-size-btn:hover,
            .text-size-btn.active {
                border-color: #1E90FF;
            }

            .bg-color-btn {
                border: 2px solid #d3d3d3;
                border-radius: 50%;
                width: 32px;
                height: 32px;
                transition: border 0.3s ease;
            }

            .bg-color-btn:hover,
            .bg-color-btn.active {
                border-color: #1E90FF;
            }

            .reset-btn {
                font-size: 12px;
                text-decoration: underline;
                cursor: pointer;
                color: black;
                transition: color 0.3s ease;
            }

            .reset-btn:hover {
                color: #1E90FF;
            }
        </style>

    </head>

    <div class="container mx-auto p-4 sm:p-8 lg:p-10 bg-white max-w-full">
        <!-- Page Title -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-4 mt-10">
            <h1 class="text-2xl sm:text-3xl font-bold text-left text-[#052D6E]"
                style="font-family: 'Libre Baskerville', serif; color: #052D6E;">
                {{ $detailBuku->buku->judul_buku ?? 'Book Title Not Available' }}
            </h1>
        </div>

        <h2 class="text-lg sm:text-xl font-bold text-[#052D6E] mb-4" style="font-family: 'Libre Baskerville', serif;">
            {{ $detailBuku->bab ?? 'Chapter Not Found' }}
        </h2>

        <!-- Chapter Content -->
        <div class="mb-8" id="read_books_container">
            <p class="text-[#979797] leading-relaxed selectable" id="isiBab">
                {{ $detailBuku->isi ?? 'Content not available.' }}</p>
            @if ($diselesaikanCheck)
                <form action="{{ route('user.delete.finished', $detailBuku->id_detail_buku) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex justify-end mt-10">
                        <button type="submit"
                            class="flex items-center gap-2 px-4 py-2 text-white bg-[#E46B61] rounded-[12px] hover:bg-[#FFCFC2] hover:text-[#E46B61]">
                            <strong>Remove Completed Mark</strong>
                        </button>
                    </div>
                </form>
            @else
                <form action="{{ route('user.mark.finished', $detailBuku->id_detail_buku) }}" method="POST">
                    @csrf
                    <div class="flex justify-end mt-10">
                        <button type="submit"
                            class="flex items-center gap-2 px-4 py-2 text-white bg-[#052D6E] rounded-[12px] hover:bg-[#1E90FF]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            <strong>Mark as Completed</strong>
                        </button>
                    </div>
                </form>
            @endif
        </div>

        <!-- Chapter Audio -->
        <div class="mb-8">
            @if (!empty($detailBuku->audio))
                <audio controls controlsList="nodownload" class="custom-audio w-full bg-[#D3E9FF] rounded-[16px] px-4 py-2">
                    <source src="{{ asset('storage/' . $detailBuku->audio) }}" type="audio/mpeg">
                    Your browser does not support the audio player.
                </audio>
            @else
                <p class="text-[#E46B61] py-2">No audio available for this chapter</p>
            @endif
        </div>

        <div
            class="flex flex-col sm:flex-row items-center justify-between p-4 border border-[#1E90FF] border-2 rounded-[16px] mt-10 mb-8">
            @if ($quiz)
                <h3 class="text-lg font-medium text-[#052D6E] w-full sm:w-auto">
                    Quiz: {{ $quiz->nama_quiz }}
                </h3>
                <div class="flex flex-col sm:flex-row items-center space-x-0 sm:space-x-8 w-full sm:w-auto">
                    @if ($quizScore)
                        <button class="w-full sm:w-auto bg-[#1E90FF] text-white py-2 text-sm rounded-[12px] font-bold">
                            Score: {{ $quizScore }}
                        </button>
                    @endif
                    <a href="{{ route('user.quiz.kerjakan', $detailBuku->id_detail_buku) }}"
                        class="w-full ml-0 sm:w-auto bg-[#052D6E] text-sm text-center text-white py-2 px-4 rounded-[12px] font-bold hover:bg-[#AFC4E7FF] hover:text-[#052D6E] transition"
                        style="margin: 0!important;">
                        @if ($quizScore)
                            Retake Quiz
                        @else
                            Take Quiz
                        @endif
                    </a>
                </div>
            @else
                <h2 class="text-lg font-bold text-[#052D6E]">
                    No Quiz Available
                </h2>
            @endif
        </div>
    </div>

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
                <span class="material-icons" style="font-size: 16px; font-weight:700; color: #052D6E;">content_copy</span>
                <strong>Copy</strong>
            </li>
            <li id="highlight-text" class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
                style="padding: 8px 16px; border-radius: 8px; transition: background-color 0.3s ease; display: flex; align-items: center; gap: 8px;">
                <span class="material-icons" style="font-size: 16px; font-weight:700; color: #052D6E;">highlight</span>
                <strong>Highlight</strong>
            </li>
        </ul>
    </div>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
        });
    </script>

    <!-- Floating Button for Text Settings -->
    <button id="open-settings" class="floating-btn"><i class="fas fa-font"></i></button>

    <!-- Modal & Overlay -->
    {{-- <div class="modal-overlay" id="modal-overlay"></div>
    <div class="settings-modal" id="settings-modal"> --}}
        {{-- <button class="modal-close" id="close-settings">X</button>
        <h3>Text Settings</h3> --}}
        <!-- Floating Text Settings -->
        <div data-test-id="text-settings" id="settings-modal"
            class="floating-settings transition-all overflow-hidden flex flex-col items-center gap-4 h-32 settings-modal">
            <!-- Font Size Options -->
            <div class="flex flex-row gap-4 m:gap-8 items-center justify-center">
                <button id="text-size-small"
                    class="text-size-btn border-2 rounded-lg w-10 h-8 flex items-center justify-center transition border-lightest-grey hover:border-blue">
                    <span class="text-r2"> Aa </span>
                </button>
                <button id="text-size-medium"
                    class="text-size-btn border-2 rounded-lg w-10 h-8 flex items-center justify-center transition border-blue hover:border-blue active">
                    <span class="text-r1"> Aa </span>
                </button>
                <button id="text-size-large"
                    class="text-size-btn border-2 rounded-lg w-10 h-8 flex items-center justify-center transition border-lightest-grey hover:border-blue">
                    <span class="text-r0"> Aa </span>
                </button>
            </div>

            <!-- Background Color Options -->
            <div class="flex flex-row gap-4 m:gap-8 items-center justify-center">
                <button id="bg-light"
                    class="bg-color-btn border-2 rounded-full w-8 h-8 bg-white transition border-lightest-grey hover:border-blue active"></button>
                <button id="bg-yellow"
                    class="bg-color-btn border-2 rounded-full w-8 h-8 bg-background-yellow transition border-blue hover:border-blue"></button>
                <button id="bg-dark"
                    class="bg-color-btn border-2 rounded-full w-8 h-8 bg-deep-black transition border-lightest-grey hover:border-blue"></button>
            </div>

            <!-- Reset Button -->
            <button id="reset-styles" class="text-center underline text-sm transition hover:text-blue">
                Reset to default
            </button>
        </div>
    {{-- </div> --}}

    <!-- JavaScript -->
    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            const isiBab = document.getElementById("isiBab");
            const container = document.getElementById("read_books_container");
            const settingsModal = document.getElementById("settings-modal");
            const modalOverlay = document.getElementById("modal-overlay");
            const openBtn = document.getElementById("open-settings");
            const closeBtn = document.getElementById("close-settings");
            const resetBtn = document.getElementById("reset-settings");

            const fontSizeSelector = document.getElementById("font-size");
            const fontFamilySelector = document.getElementById("font-family");
            const bgColorPicker = document.getElementById("bg-color");
            const textColorPicker = document.getElementById("text-color");
            const lineSpacingSelector = document.getElementById("line-spacing");
            console.log(bgColorPicker)
            // Open & Close Modal
            openBtn.addEventListener("click", () => {
                settingsModal.style.display = "block";
                modalOverlay.style.display = "block";
            });

            closeBtn.addEventListener("click", () => {
                settingsModal.style.display = "none";
                modalOverlay.style.display = "none";
            });

            // Apply settings
            function applySetting(key, value, element, styleProp) {
                element.style[styleProp] = value;
                localStorage.setItem(key, value);
            }

            fontSizeSelector.addEventListener("change", () => applySetting("fontSize", fontSizeSelector.value,
                isiBab, "fontSize"));
            fontFamilySelector.addEventListener("change", () => applySetting("fontFamily", fontFamilySelector.value,
                isiBab, "fontFamily"));
            bgColorPicker.addEventListener("input", () => applySetting("bgColor", bgColorPicker.value, container,
                "backgroundColor"));
            textColorPicker.addEventListener("input", () => applySetting("textColor", textColorPicker.value, isiBab,
                "color"));
            lineSpacingSelector.addEventListener("change", () => applySetting("lineSpacing", lineSpacingSelector
                .value, isiBab, "lineHeight"));

            resetBtn.addEventListener("click", () => {
                localStorage.clear();
                location.reload();
            });
        });
    </script> --}}

    <!-- JavaScript to Handle Settings -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const openBtn = document.getElementById("open-settings");
            const closeBtn = document.getElementById("close-settings");
            const resetBtn = document.getElementById("reset-settings");
            const settingsModal = document.getElementById("settings-modal");
            const modalOverlay = document.getElementById("modal-overlay");
             // Open & Close Modal
             openBtn.addEventListener("click", () => {
                settingsModal.style.display = "block";
                modalOverlay.style.display = "block";
            });

            closeBtn.addEventListener("click", () => {
                settingsModal.style.display = "none";
                modalOverlay.style.display = "none";
            });
            const isiBab = document.getElementById("isiBab");

            // Font Size Buttons
            document.getElementById("text-size-small").addEventListener("click", function() {
                isiBab.style.fontSize = "14px";
                updateActiveClass("text-size-small");
            });

            document.getElementById("text-size-medium").addEventListener("click", function() {
                isiBab.style.fontSize = "16px";
                updateActiveClass("text-size-medium");
            });

            document.getElementById("text-size-large").addEventListener("click", function() {
                isiBab.style.fontSize = "20px";
                updateActiveClass("text-size-large");
            });

            // Background Color Buttons
            document.getElementById("bg-light").addEventListener("click", function() {
                document.body.style.backgroundColor = "#ffffff";
                updateActiveClass("bg-light");
            });

            document.getElementById("bg-yellow").addEventListener("click", function() {
                document.body.style.backgroundColor = "#f7ebc6";
                updateActiveClass("bg-yellow");
            });

            document.getElementById("bg-dark").addEventListener("click", function() {
                document.body.style.backgroundColor = "#1a1a1a";
                isiBab.style.color = "#ffffff";
                updateActiveClass("bg-dark");
            });

            // Reset Button
            document.getElementById("reset-styles").addEventListener("click", function() {
                isiBab.style.fontSize = "16px";
                document.body.style.backgroundColor = "#ffffff";
                isiBab.style.color = "#000000";
                updateActiveClass("text-size-medium");
                updateActiveClass("bg-light");
            });

            // Function to update active button states
            function updateActiveClass(activeId) {
                document.querySelectorAll(".text-size-btn, .bg-color-btn").forEach(btn => {
                    btn.classList.remove("border-blue");
                    btn.classList.add("border-lightest-grey");
                });
                document.getElementById(activeId).classList.remove("border-lightest-grey");
                document.getElementById(activeId).classList.add("border-blue");
            }
        });
    </script>

@endsection
