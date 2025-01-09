@extends('sewa_buku.layouts.userBacaBuku')

@section('title')
    {{ $detailBuku->bab ?? 'Read Book Chapter' }}
@endsection

@section('content')
<div class="container mx-auto p-4 sm:p-8 lg:p-10 bg-white max-w-full">
    <!-- Page Title -->
    <div class="flex flex-col sm:flex-row justify-between items-center mb-4 mt-10">
        <h1 class="text-2xl sm:text-3xl font-bold text-left text-[#052D6E]" style="font-family: 'Libre Baskerville', serif; color: #052D6E;">
            {{ $detailBuku->buku->judul_buku ?? 'Book Title Not Available' }}
        </h1>
    </div>

    <h2 class="text-lg sm:text-xl font-bold text-[#052D6E] mb-4" style="font-family: 'Libre Baskerville', serif;">
        {{ $detailBuku->bab ?? 'Chapter Not Found' }}
    </h2>

    <!-- Chapter Content -->
    <div class="mb-8">
        <p class="text-[#979797] leading-relaxed selectable" id="isiBab">{{ $detailBuku->isi ?? 'Content not available.' }}</p>
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
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
            <audio controls controlsList="nodownload" class="w-full bg-[#D3E9FF] rounded-[16px] px-4 py-2">
                <source src="{{ asset('storage/' . $detailBuku->audio) }}" type="audio/mpeg">
                Your browser does not support the audio player.
            </audio>
        @else
            <p class="text-[#E46B61] py-2">No audio available for this chapter</p>
        @endif
    </div>

    <div class="flex flex-col sm:flex-row items-center justify-between p-4 border border-[#1E90FF] border-2 rounded-[16px] mt-10 mb-8">
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

@endsection
