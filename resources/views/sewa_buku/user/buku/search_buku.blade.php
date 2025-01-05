@extends('sewa_buku.layouts.userApp')

@section('content')
<div class="container mx-auto p-10">

    <!-- Header Section -->
    <div class="mb-4">
        <h1 class="text-[40px] font-bold text-left text-[#052D6E] mb-10" style="font-family: 'Libre Baskerville', serif;">Pencarian</h1>

        <!-- Search Bar -->
        <div class="search-wrapper mb-12 flex items-center w-full"> <!-- Changed width to full -->
            <div class="search-box relative rounded-full transition-all duration-300 max-w-xl w-full mr-4">
                <i class="fas fa-search search-icon absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
                <input id="search-input" type="text" class="form-control search-input rounded-[12px] pl-12 pr-4 py-4 w-full border-2 border-transparent transition-all duration-300 focus:border-[#1E90FF] focus:ring-0" placeholder="Cari buku kesukaan anda...">
                <button class="btn btn-primary search-button absolute right-4 top-1/2 transform -translate-y-1/2 rounded-[12px] py-2 px-6 bg-[#1E90FF] text-white hover:bg-[#052D6E] transition duration-300">
                    Cari
                </button>
            </div>

            <!-- Filter Dropdown -->
            <div class="filter-dropdown relative w-1/5">
                <!-- Form untuk Filter -->
                <form action="{{ route('search_buku') }}" method="GET">
                    <select
                        id="filter-select"
                        name="tag_id"
                        class="form-control rounded-[12px] pl-4 pr-4 py-4 w-full border-2 border-transparent transition-all duration-300 focus:border-[#1E90FF] text-[#1E90FF]"
                        onchange="this.form.submit()"
                    >
                        <option value="">Semua Kategori</option>
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
        <p class="text-[18px] text-[#052D6E] font-bold mb-6 ">Hasil Buku</p>
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
            @include('sewa_buku.user.buku.grid_search_buku', ['buku' => $buku])
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.querySelector('#search-input');
        const resultsContainer = document.querySelector('.grid');

        searchInput.addEventListener('input', function () {
            const searchTerm = searchInput.value;

            fetch(`{{ route('buku.search') }}?search=${searchTerm}`)
                .then(response => response.json())
                .then(data => {
                    resultsContainer.innerHTML = data.html;
                })
                .catch(error => console.error('Error:', error));
        });
    });


</script>


@endsection
