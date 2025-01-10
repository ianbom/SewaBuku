@extends('sewa_buku.layouts.userApp')

@section('content')
<head>
    <style>
        .custom-audio {
            background-color: white;
            color: #1E90FF !important; /* Warna teks bawaan */
        }
        .custom-audio::-webkit-media-controls-panel {
            background-color: white; /* Background panel transparan */
        }
        .custom-audio::-webkit-media-controls-play-button {
            background-color: white; /* Transparansi tombol play */
            color: #1E90FF !important; /* Warna tombol play */
        }
        .custom-audio::-webkit-media-controls-timeline {
            color: #1E90FF !important;
        }
        .custom-audio::-webkit-media-controls-current-time-display,
        .custom-audio::-webkit-media-controls-time-remaining-display {
            color: #1E90FF !important;
        }
        .custom-audio::-webkit-media-controls-play-button,
        .custom-audio::-webkit-media-controls-pause-button,
        .custom-audio::-webkit-media-controls-mute-button,
        .custom-audio::-webkit-media-controls-timeline,
        .custom-audio::-webkit-media-controls-volume-slider-container,
        .custom-audio::-webkit-media-controls-current-time-display,
        .custom-audio::-webkit-media-controls-time-remaining-display,
        .custom-audio::-webkit-media-controls-button,
        .custom-audio::-webkit-media-controls-panel {
            color: #1E90FF !important;
        }

        /* Tambahan untuk ikon titik tiga */
        .custom-audio::-webkit-media-controls {
            color: #1E90FF !important;
        }
    </style>
</head>
<div class="container mx-auto p-10">

    <!-- Header Section -->
    <div class="mb-4">
        <h1 class="text-[40px] font-bold text-left text-[#052D6E] mb-10" style="font-family: 'Libre Baskerville', serif;">Highlight</h1>

        <div class="search-wrapper mb-12 flex items-center w-full"> <!-- Changed width to full -->
            <div class="search-box relative rounded-full transition-all duration-300 max-w-xl w-full mr-4">
                <i class="fas fa-search search-icon absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
                <input id="search-input" type="text" class="form-control search-input rounded-[12px] pl-12 pr-4 py-4 w-full border-2 border-transparent transition-all duration-300 focus:border-[#1E90FF] focus:ring-0" placeholder="Cari buku kesukaan anda...">
                <button class="btn btn-primary search-button absolute right-4 top-1/2 transform -translate-y-1/2 rounded-[12px] py-2 px-6 bg-[#1E90FF] text-white hover:bg-[#052D6E] transition duration-300">
                    Cari
                </button>
            </div>

            <!-- Filter Dropdown -->
            <div class="filter-dropdown relative w-1/5 ">
                <select id="filter-select" class="form-control rounded-[12px] pl-4 pr-4 py-4 w-full border-2 border-transparent transition-all duration-300 focus:border-[#1E90FF]  text-[#1E90FF]">
                    <option value="all">Semua Kategori</option>
                    <option value="fiction">Fiksi</option>
                    <option value="non-fiction">Non-Fiksi</option>
                    <option value="science">Sains</option>
                    <option value="history">Sejarah</option>
                    <!-- GANTI INI -->
                </select>
            </div>
        </div>
    </div>

    <div class="mb-6 mt-10">
        <h2 class="text-[18px] font-semibold text-[#052D6E] mb-4" style="font-family: 'Inter', sans-serif;">Your Highlight</h2>

        <!-- Scrollable container for horizontal scrolling -->
        <div class="overflow-x-auto">
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
               @include('sewa_buku.user.buku.highlight.list_highlight', ['buku' => $buku])
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.querySelector('#search-input');
    const resultsContainer = document.querySelector('.grid');

    searchInput.addEventListener('input', function () {
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
