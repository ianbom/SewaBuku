@extends('sewa_buku.layouts.userApp')

@section('content')

    <head>
        <style>
            .custom-audio {
                background-color: white;
                color: #1E90FF !important;
            }

            .custom-audio::-webkit-media-controls-panel,
            .custom-audio::-webkit-media-controls-play-button,
            .custom-audio::-webkit-media-controls-timeline,
            .custom-audio::-webkit-media-controls-current-time-display,
            .custom-audio::-webkit-media-controls-time-remaining-display,
            .custom-audio::-webkit-media-controls-button,
            .custom-audio::-webkit-media-controls {
                color: #1E90FF !important;
            }
        </style>
    </head>

    <div>
    <div class="container mx-auto px-4 sm:px-6 lg:px-10 py-6 sm:py-10 mt-10"> <!-- Added mt-10 for top margin -->

        <!-- Header Section -->
        <div class="mb-6">
            <h1 class="text-2xl sm:text-[40px] font-bold text-[#052D6E] mb-6 sm:mb-10"
                style="font-family: 'Libre Baskerville', serif;">Highlight</h1>

            <!-- Search Bar -->
            <div class="search-wrapper mb-8 flex flex-col sm:flex-row items-start sm:items-center gap-4">
                <!-- Search Box -->
                <div class="search-box relative rounded-full transition-all duration-300 w-full sm:max-w-xl">
                    <i
                        class="fas fa-search search-icon absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
                    <input id="search-input" type="text"
                        class="form-control search-input rounded-[12px] pl-12 pr-4 py-3 sm:py-4 w-full border-2 border-transparent transition-all duration-300 focus:border-[#1E90FF] focus:ring-0"
                        placeholder="Cari buku kesukaan anda...">
                    <button
                        class="btn btn-primary search-button absolute right-4 top-1/2 transform -translate-y-1/2 rounded-[12px] py-2 px-4 sm:px-6 bg-[#1E90FF] text-white hover:bg-[#052D6E] transition duration-300">
                        Cari
                    </button>
                </div>

                <!-- Filter Dropdown -->
                <div class="filter-dropdown relative w-full sm:w-1/3">
                    <!-- Form untuk Filter -->
                    <form action="{{ route('user.highlight') }}" method="GET">
                        <select id="filter-select" name="tag_id"
                            class="form-control rounded-[12px] pl-4 pr-4 py-3 sm:py-4 w-full border-2 border-transparent transition-all duration-300 focus:border-[#1E90FF] text-[#1E90FF]"
                            onchange="this.form.submit()">
                            <option value="">Semua Kategori</option>
                            @foreach ($tag as $item)
                                <option value="{{ $item->id_tags }}"
                                    {{ request('tag_id') == $item->id_tags ? 'selected' : '' }}>
                                    {{ $item->nama_tags }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
        </div>

        <!-- Highlight Section -->
        <div class="mb-6 mt-10">
            <h2 class="text-lg sm:text-[18px] font-semibold text-[#052D6E] mb-4" style="font-family: 'Inter', sans-serif;">
                Your Highlight</h2>

            <!-- Scrollable container for horizontal scrolling -->
            <div class="overflow-x-auto">
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 sm:gap-6">
                    @include('sewa_buku.user.buku.highlight.list_highlight', ['buku' => $buku])
                </div>
            </div>
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
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('#search-input');
            const resultsContainer = document.querySelector('.grid');

            searchInput.addEventListener('input', function() {
                const searchTerm = searchInput.value;

                fetch(`{{ route('highlight.search') }}?search=${searchTerm}`)
                    .then(response => response.json())
                    .then(data => {
                        resultsContainer.innerHTML = data.html;
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    </script>
@endsection
    </div>
