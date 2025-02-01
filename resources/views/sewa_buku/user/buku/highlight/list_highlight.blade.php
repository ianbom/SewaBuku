@forelse($buku as $book)
<div class="bg-white rounded-[16px] overflow-hidden border-2 border-transparent hover:border-[#D3E9FF] transition-all">
    <a href="{{ route('user.highlight.detail', $book->id_buku) }}">
        @if($book->coverBuku && $book->coverBuku->first())
            <img src="{{ asset('storage/' . $book->coverBuku->first()->file_image) }}" alt="Cover Buku" class="w-full h-128 object-cover rounded-[16px]">
        @else
            <img src="https://via.placeholder.com/150" alt="Cover Placeholder" class="w-full h-64 object-cover">
        @endif
    </a>

    <div class="p-4">
        <h3 class="text-[#052D6E] text-[14px] font-semibold mb-2" style="font-family: 'Inter', sans-serif;">{{ $book->judul_buku }}</h3>
        <p class="text-[#979797] font-medium text-[14px]" style="font-family: 'Inter', sans-serif;">{{ $book->penulis }}</p>

        <div class="flex justify-between items-center text-[#979797] text-sm mt-4">
            <div class="flex items-center">
                   <span class="material-icons mr-2 p-2 rounded-[8px] text-[12px]" style="font-size: 16px; font-weight:700; background-color: #D3E9FF; color: #1E90FF;">highlight</span>
                   <span class="font-inter font-medium text-[12px]" style="color: #979797; font-family: 'Inter', sans-serif;">{{ $book->total_highlight }}</span>
                   <span class="font-inter font-medium text-[12px]" style="color: #979797; font-family: 'Inter', sans-serif; margin-left: 4px;">Hightlight</span>
                                                  </div>

        </div>
    </div>
</div>
@empty
Kosong
@endforelse
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
