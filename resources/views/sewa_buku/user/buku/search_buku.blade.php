@extends('sewa_buku.layouts.userApp')

@section('content')
<div>
<div class="container mx-auto p-5 sm:p-10">


    <!-- Header Section -->
    <div class="mb-4 sm:mt-10 mt-20">
        <h1 class="text-2xl sm:text-[40px] font-bold text-left text-[#052D6E] mb-6 sm:mb-10" style="font-family: 'Libre Baskerville', serif;">Search</h1>
        <p class="text-[16px] sm:text-[18px] text-[#052D6E] font-bold mb-4 sm:mb-6">Last Reads</p>

        {{--
    <!-- Last Pickup Section -->
    @if ($terakhirDibaca && $terakhirDibaca->buku->coverBuku->first())
        <div class="bg-transparent sm:bg-[#D3E9FF] rounded-[16px] p-4 inline-block mb-10">
            <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4">
                <img src="{{ asset('storage/' . $terakhirDibaca->buku->coverBuku->first()->file_image) }}"
                    alt="Last Book" class="w-32 h-48 sm:w-48 sm:h-72 object-cover rounded-[16px] mb-4 sm:mb-0">
                <div class="sm:w-80">
                    <p class="text-[#052D6E] font-bold mb-2">{{ $terakhirDibaca->buku->judul_buku ?? 'No book found' }}</p>
                    <p class="text-sm text-[#979797] font-bold">{{ $terakhirDibaca->buku->penulis ?? '' }}</p>
                    <!-- Audio Player -->
                    <div class="mt-4 bg-white rounded-[16px] h-16 flex items-center px-4 w-full">
                        @if ($terakhirDibaca->buku->ringkasan_audio)
                            <audio controls controlsList="nodownload" class="custom-audio">
                                <source src="{{ asset('storage/' . $terakhirDibaca->buku->ringkasan_audio) }}" type="audio/mpeg">
                                Your browser does not support the audio player.
                            </audio>
                        @else
                            <p class="text-sm text-[#979797] font-bold">No audio available</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @else
        <img src="https://via.placeholder.com/150" alt="Last Book" class="rounded-[16px]">
    @endif --}}
        <!-- Search Bar -->
        <div class="search-wrapper mb-8 sm:mb-12 flex flex-col sm:flex-row items-start sm:items-center gap-4">
            <!-- Search Box -->
            <div class="search-box relative rounded-full transition-all duration-300 w-full sm:max-w-xl">
                <i class="fas fa-search search-icon absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
                <input
                    id="search-input"
                    type="text"
                    class="form-control search-input rounded-[12px] pl-12 pr-4 py-3 sm:py-4 w-full border-2 border-transparent transition-all duration-300 focus:border-[#1E90FF] focus:ring-0"
                    placeholder="Search your favorite books..."
                >
                <button
                    class="btn btn-primary search-button absolute right-4 top-1/2 transform -translate-y-1/2 rounded-[12px] py-2 px-4 sm:px-6 bg-[#1E90FF] text-white hover:bg-[#052D6E] transition duration-300"
                >
                    Search
                </button>
            </div>

            <!-- Filter Dropdown -->
            <div class="filter-dropdown relative w-full sm:w-1/3">
                <form action="{{ route('search_buku') }}" method="GET">
                    <select
                        id="filter-select"
                        name="tag_id"
                        class="form-control rounded-[12px] pl-4 pr-4 py-3 sm:py-4 w-full border-2 border-transparent transition-all duration-300 focus:border-[#1E90FF] text-[#1E90FF]"
                        onchange="this.form.submit()"
                    >
                        <option value="">All Categories</option>
                        @foreach ($tag as $item)
                            <option value="{{ $item->id_tags }}" {{ request('tag_id') == $item->id_tags ? 'selected' : '' }}>
                                {{ $item->nama_tags }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
    </div>

    <!-- Book Search -->
    <div class="mb-10">
        <p class="text-[16px] sm:text-[18px] text-[#052D6E] font-bold mb-4 sm:mb-6">Book Results</p>
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-6">
            @include('sewa_buku.user.buku.grid_search_buku', ['buku' => $buku])
        </div>
    </div>
</div>

<footer class="bg-[#1E90FF] text-white pt-12 pb-12 mt-20">
    <div class="max-w-6xl mx-auto px-6">
        <div class="flex flex-col sm:flex-row justify-between items-center text-center sm:text-left">
            <!-- Deskripsi Website -->
            <div class="max-w-xs sm:max-w-sm">
                <p class="font-semibold text-lg" style="font-family: 'Inter', sans-serif;">Shae Insight</p>
                <p class="text-sm mt-2" style="font-family: 'Inter', sans-serif;">
                    Empowering your personal growth with insights that drive lasting change and deepen understanding in just 1 minute.
                </p>
            </div>

            <!-- Copyright (Dipusatkan di antara dua elemen lainnya) -->
            <div class="flex-grow flex justify-center">
                <h4 class="font-semibold text-white mb-3" style="font-family: 'Inter', sans-serif;">
                    &copy; 2025 Shae Insight. All Rights Reserved.
                </h4>
            </div>

            <!-- Social Media Links -->
            <div>
                <h4 class="font-semibold text-white mb-3" style="font-family: 'Inter', sans-serif;">Follow Us</h4>
                <ul class="flex space-x-6 justify-center sm:justify-start">
                    <li>
                        <a href="https://facebook.com" target="_blank" class="hover:text-[#052D6E]">
                            <i class="fab fa-facebook-f text-2xl"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://twitter.com" target="_blank" class="hover:text-[#052D6E]">
                            <i class="fab fa-twitter text-2xl"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://linkedin.com" target="_blank" class="hover:text-[#052D6E]">
                            <i class="fab fa-linkedin-in text-2xl"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://instagram.com" target="_blank" class="hover:text-[#052D6E]">
                            <i class="fab fa-instagram text-2xl"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.querySelector('#search-input');
        const resultsContainer = document.querySelector('.grid');

        searchInput.addEventListener('input', function () {
            const searchTerm = searchInput.value;

            fetch({{ route('buku.search') }}?search=${searchTerm})
                .then(response => response.json())
                .then(data => {
                    resultsContainer.innerHTML = data.html;
                })
                .catch(error => console.error('Error:', error));
        });
    });
</script>
@endsection
