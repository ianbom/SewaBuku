@extends('sewa_buku.layouts.userBacaBuku')

@section('title')
    {{ $detailBuku->bab ?? 'Baca Bab Buku' }}
@endsection

@section('content')
<div class="container mx-auto p-10 bg-white">

    <!-- Judul Halaman -->
 <div class="flex justify-between items-center mb-4 mt-10">
    <h1 class="text-3xl font-bold text-left text-[052D6E]" style="font-family: 'Libre Baskerville', serif; color: #052D6E;"> {{ $detailBuku->buku->judul_buku ?? 'Judul Buku Tidak Tersedia' }}</h1>
</div>

<h2 class="text-[18px] font-bold text-[#052D6E] mb-4 " style="font-family: 'Libre Baskerville', serif;">{{ $detailBuku->bab ?? 'Bab Tidak Ditemukan' }}</h2>

            <!-- Isi Bab -->
            <div class="mb-8">
                <p class="text-[#979797] leading-relaxed">{{ $detailBuku->isi ?? 'Isi tidak tersedia.' }}</p>
                @if ($diselesaikanCheck)
                <form action="{{ route('user.delete.finished', $detailBuku->id_detail_buku) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex justify-end mt-10">
                        <button
                            type="submit"
                            class="flex items-center gap-2 px-4 py-2 text-white bg-[#E46B61] rounded-[12px] hover:bg-[#FFCFC2] hover:text-[#E46B61]">
                            <strong>Delete Mark</strong>
                        </button>
                    </div>
                </form>
                @else
                <form action="{{ route('user.mark.finished', $detailBuku->id_detail_buku) }}" method="POST">
                    @csrf
                    <div class="flex justify-end mt-10">
                        <button
                            type="submit"
                            class="flex items-center gap-2 px-4 py-2 text-white bg-[#052D6E] rounded-[12px] hover:bg-[#1E90FF]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            <strong>Mark as finished</strong>
                        </button>
                    </div>
                                    </form>
                @endif


            </div>

            <!-- Audio Bab -->
            <div class="mb-8">
                @if (!empty($detailBuku->audio))
                    <audio
                        controls
                        controlsList="nodownload"
                        class="w-full bg-[#D3E9FF] rounded-[16px]  px-4 py-2 ">
                        <source src="{{ asset('storage/' . $detailBuku->audio) }}" type="audio/mpeg">
                        Browser Anda tidak mendukung pemutar audio.
                    </audio>
                @else
                <p class="text-[#E46B61] py-2">Tidak ada audio untuk bab ini</p>
                @endif
            </div>



            <div class="flex items-center justify-between p-4 border border-[#1E90FF] border-2 rounded-[16px] mt-10 mb-8">
                @if ($quiz)
                    <h3 class="text-lg font-medium text-[#052D6E]">
                        Quiz: {{ $quiz->nama_quiz }}

                    </h3>
                    <div class="flex items-center space-x-8">
                        @if ($quizScore)
                        <button
                        class="w-full bg-[#1E90FF] text-white py-2 text-sm rounded-[12px] font-bold">
                        Nilai : {{ $quizScore }}
                    </button>
                        @else
                            {{-- <p class="text-yellow-500 text-sm font-bold">{{ $quizStatus }}</p> --}}
                        @endif
                        <a href="{{ route('user.quiz.kerjakan', $detailBuku->id_detail_buku) }}"
                            class="w-full bg-[#052D6E] text-sm text-center text-white py-2 px-4 rounded-[12px] font-bold hover:bg-[#AFC4E7FF] hover:text-[#052D6E] transition">
                            @if ($quizScore)
                                Kerjakan Ulang
                            @else
                                Kerjakan Quiz
                            @endif
                        </a>
                    </div>
                @else
                    <h2 class="text-lg font-bold text-[#052D6E]">
                        Tidak ada quiz
                    </h2>
                @endif
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
       <div id="custom-context-menu"
       class="hidden absolute bg-white shadow-lg border-2 rounded-md z-50"
       style="padding: 10px; border-color: #052D6E; background-color: #CFE2FF; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
      <ul style="list-style: none; margin: 0; padding: 0; font-family: 'Inter', sans-serif; font-size: 14px; color: #0c3c78;">
          <li id="copy-text"
              class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
              style="padding: 8px 16px; margin-bottom: 4px; border-radius: 8px; transition: background-color 0.3s ease; display: flex; align-items: center; gap: 8px;">
              <span class="material-icons" style="font-size: 16px; font-weight:700; color: #052D6E;">content_copy</span>
              <strong>Coppy</strong>
          </li>
          <li id="highlight-text"
              class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
              style="padding: 8px 16px; border-radius: 8px; transition: background-color 0.3s ease; display: flex; align-items: center; gap: 8px;">
              <span class="material-icons" style="font-size: 16px; font-weight:700; color: #052D6E;">highlight</span>
              <strong>Highlight</strong>
          </li>
      </ul>
  </div>

  <!-- Tambahkan link ke Material Icons jika belum ada -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">



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
