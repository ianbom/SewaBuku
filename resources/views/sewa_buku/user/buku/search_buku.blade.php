@extends('sewa_buku.layouts.userApp')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold text-blue-900 mb-8 mt-16">Explore</h1>

    <div class="mb-10">

        <div class="relative max-w-xl">
            <input type="text"
                   id="search-input"
                   placeholder="Find a book you like..."
                   class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                   <button class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-blue-500 text-white px-6 py-1.5 rounded-lg">
                    Cari
                </button>
        </div>
    </div>

    <!-- Book Search -->
    <div class="mb-10">
        <h2 class="text-lg font-semibold mb-4">Search</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-12">
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
