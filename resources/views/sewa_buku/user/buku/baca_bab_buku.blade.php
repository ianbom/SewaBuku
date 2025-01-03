@extends('sewa_buku.layouts.userBacaBuku')

@section('title')
    {{ $detailBuku->bab ?? 'Baca Bab Buku' }}
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <!-- Header Bab -->
            <div class="text-center border-b pb-6 mb-6">
                <h1 class="text-3xl font-bold text-gray-800"> {{ $detailBuku->buku->judul_buku ?? 'Judul Buku Tidak Tersedia' }}</h1>
                <p class="text-gray-500 mt-2"> {{ $detailBuku->bab ?? 'Bab Tidak Ditemukan' }}</p>
            </div>

            <!-- Isi Bab -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Isi Bab</h2>
                <p class="text-gray-600 leading-relaxed">{{ $detailBuku->isi ?? 'Isi tidak tersedia.' }}</p>
                @if ($diselesaikanCheck)
                <form action="{{ route('user.delete.finished', $detailBuku->id_detail_buku) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 rounded-md p-1 text-white"> Delete mark</button>
                </form>
                @else
                <form action="{{ route('user.mark.finished', $detailBuku->id_detail_buku) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-blue-500 rounded-md p-1 text-white"> Mark as finished</button>
                </form>
                @endif


            </div>

            <!-- Audio Bab -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Audio Bab</h2>
                @if (!empty($detailBuku->audio))
                    <audio controls class="w-full rounded-md border">
                        <source src="{{ asset('storage/' . $detailBuku->audio) }}" type="audio/mpeg">
                        Browser Anda tidak mendukung pemutar audio.
                    </audio>
                @else
                    <p class="text-gray-500">Tidak ada audio untuk bab ini.</p>
                @endif
            </div>

            <div class="mb-8">
                @if ($quiz)
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Quiz</h2>
                    <h3 class="text-lg font-medium text-black mb-4">{{ $quiz->nama_quiz }}</h3>
                    @if ($quizScore)
                        <p class="text-green-600 font-bold mb-4">Nilai Anda: {{ $quizScore }}</p>
                    @else
                        <p class="text-yellow-500 font-bold mb-4">{{ $quizStatus }}</p>
                    @endif
                    <a href="{{ route('user.quiz.kerjakan', $detailBuku->id_detail_buku) }}" class="bg-green-500 rounded-md p-2 text-white">
                        @if ($quizScore)
                            Kerjakan Ulang Quiz
                        @else
                            Kerjakan Quiz
                        @endif
                    </a>
                @else
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Tidak ada quiz</h2>
                @endif
            </div>


            <!-- Tombol Navigasi -->
            <div class="flex justify-between items-center mt-8 pt-6 border-t">
                <a href="{{ route('user.buku.show', $detailBuku->id_buku) }}" class="inline-flex items-center px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>
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
        <div id="custom-context-menu" class="hidden absolute bg-white shadow-lg border rounded-md z-50">
            <ul>
                <li id="copy-text" class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Copy</li>
                <li id="highlight-text" class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Highlight</li>
            </ul>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
    const isiBab = document.querySelector('p.text-gray-600');
    const contextMenu = document.getElementById('custom-context-menu');
    let selectedText = ''; // Untuk menyimpan teks yang diseleksi

    // Fungsi untuk menampilkan menu konteks
    function showContextMenu(e) {
        e.preventDefault();

        // Dapatkan teks yang diseleksi
        selectedText = window.getSelection().toString().trim();

        // Hanya tampilkan menu jika ada teks yang diseleksi
        if (selectedText) {
            contextMenu.style.top = `${e.pageY}px`;
            contextMenu.style.left = `${e.pageX}px`;
            contextMenu.classList.remove('hidden');
        }
    }

    // Fungsi untuk menyembunyikan menu konteks
    function hideContextMenu() {
        contextMenu.classList.add('hidden');
    }

    // Event Listener untuk klik kanan pada teks
    isiBab.addEventListener('contextmenu', showContextMenu);

    // Event Listener untuk klik di luar menu konteks
    document.addEventListener('click', (e) => {
        if (!contextMenu.contains(e.target)) {
            hideContextMenu();
        }
    });

    // Fungsi untuk menyalin teks ke clipboard
    document.getElementById('copy-text').addEventListener('click', function () {
        navigator.clipboard.writeText(selectedText).then(() => {
            alert('Teks berhasil disalin!');
        });
        hideContextMenu();
    });

    // Fungsi untuk menandai teks sebagai highlight
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
                // Buat span baru dengan background kuning untuk highlight
                const span = document.createElement('span');
                span.textContent = selectedText;
                span.style.backgroundColor = 'yellow';

                // Ganti teks yang diseleksi dengan span yang di-highlight
                const selection = window.getSelection();
                const range = selection.getRangeAt(0);
                range.deleteContents();
                range.insertNode(span);

                alert('Teks berhasil di-highlight!');
            } else {
                alert('Gagal menandai teks.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menandai teks.');
        });

        hideContextMenu();
    });
});
        </script>


@endsection
