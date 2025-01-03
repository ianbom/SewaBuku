@extends('sewa_buku.layouts.userApp')

@section('title')
    Daftar Order Saya
@endsection

@section('content')
<div class="container mx-auto mt-10 p-10">
    <!-- Judul Halaman -->
    <div class="flex justify-between items-center mb-12">
        <h1 class="text-3xl font-bold text-left text-[052D6E]" style="font-family: 'Libre Baskerville', serif; color: #052D6E;">Pesanan</h1>
    </div>

    <!-- Search Bar -->
    <div class="search-wrapper mb-12">
        <div class="search-box relative shadow-lg rounded-full transition-all duration-300 max-w-xl w-full">
            <i class="fas fa-search search-icon absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
            <input id="search-input" type="text" class="form-control search-input rounded-[12px] pl-12 pr-4 py-4 w-full border-2 border-transparent transition-all duration-300 focus:border-[#1E90FF] focus:ring-0" placeholder="Cari order yang Anda inginkan...">
            <button class="btn btn-primary search-button absolute right-4 top-1/2 transform -translate-y-1/2 rounded-[12px] py-2 px-6 bg-[#1E90FF] text-white hover:bg-[#052D6E] transition duration-300">
                Cari
            </button>
        </div>
    </div>

    @if($order->isEmpty())
        <!-- Pesan jika tidak ada order -->
        <p class="text-center text-gray-500 text-lg mt-6">Belum ada order yang dilakukan.</p>
    @else
        <!-- Tabel Order -->
        <div id="order-table-container" class="overflow-x-auto shadow-lg rounded-2xl mt-6 border border-[#1E90FF] border-2" style="font-family: 'Inter', sans-serif;">
            @include('sewa_buku.user.order.table_order', ['order' => $order])
        </div>
    @endif

</div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.querySelector('#search-input');
        const tableContainer = document.querySelector('#order-table-container');
        let currentSearchTerm = '';
    
        function fetchOrders(url) {
            // Append search term to pagination URLs if exists
            if (currentSearchTerm && !url.includes('search=')) {
                const separator = url.includes('?') ? '&' : '?';
                url = `${url}${separator}search=${encodeURIComponent(currentSearchTerm)}`;
            }
        
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                tableContainer.innerHTML = data.html;
                // Update URL without reloading page
                const newUrl = new URL(url, window.location.origin);
                window.history.pushState({ path: newUrl.href }, '', newUrl.href);
            })
            .catch(error => console.error('Error:', error));
        }
    
        // Handle search input with debounce
        let searchTimer;
        searchInput.addEventListener('input', function () {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                currentSearchTerm = searchInput.value;
                fetchOrders(`{{ route('user.order.search') }}?search=${encodeURIComponent(currentSearchTerm)}`);
            }, 300);
        });
    
        // Handle pagination clicks
        tableContainer.addEventListener('click', function (event) {
            const link = event.target.closest('.pagination a');
            if (link) {
                event.preventDefault();
                fetchOrders(link.href);
            }
        });
    
        // Handle browser back/forward buttons
        window.addEventListener('popstate', function () {
            fetchOrders(window.location.href);
        });
    });
    
    </script>

@endsection
