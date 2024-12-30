<link href="https://fonts.googleapis.com/css2?family=Inter:wght@600;700&display=swap" rel="stylesheet">

<div class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md flex flex-col">
        <!-- Logo -->
        <div class="py-4">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-32 h-auto ml-2"> <!-- Logo aligned to the left -->
        </div>


        <!-- Menu -->
        <nav class="flex-1 px-4 py-6 space-y-6">
            <div>
                <h3 class="text-gray-400 text-sm font-semibold uppercase mb-3">Menu</h3>
                <ul>
                    <li class="mb-2">
                        <a href="{{ route('user.buku.index') }}"
                           class="flex items-center px-4 py-2 rounded hover:bg-gray-100
                           {{ Route::currentRouteName() == 'user.buku.index' ? 'bg-[#D3E9FF] text-[#052D6E] font-semibold' : '' }}">
                            <i class="fas fa-home text-blue-500 mr-3"></i>
                            <span class="text-gray-700">Explore</span>
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('user.buku.search') }}"
                        class="flex items-center px-4 py-2 rounded hover:bg-gray-100
                        {{ Route::currentRouteName() == 'user.buku.search' ? 'bg-[#D3E9FF] text-[#052D6E] font-semibold' : '' }}">
                            <i class="fas fa-search text-blue-500 mr-3"></i>
                            <span class="text-gray-700">Search</span>
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#"
                           class="flex items-center px-4 py-2 rounded hover:bg-gray-100">
                            <i class="fas fa-highlighter text-blue-500 mr-3"></i>
                            <span class="text-gray-700">Highlight</span>
                        </a>
                    </li>
                </ul>
                <hr class="my-8 border-t-1 border-[#1E90FF]">


            </div>


            <div>
                <ul>
                    <li class="mb-2">
                        <a href="{{ route('user.paketLangganan.index') }}"
                           class="flex items-center px-4 py-2 rounded hover:bg-gray-100
                           {{ Route::currentRouteName() == 'user.paketLangganan.index' ? 'bg-[#D3E9FF] text-[#052D6E] font-semibold' : '' }}">
                            <i class="fas fa-box text-blue-500 mr-3"></i>
                            <span class="text-gray-700">Subscription Package</span>
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('user.langganan.index') }}"
                           class="flex items-center px-4 py-2 rounded hover:bg-gray-100
                           {{ Route::currentRouteName() == 'user.langganan.index' ? 'bg-[#D3E9FF] text-[#052D6E] font-semibold' : '' }}">
                            <i class="fas fa-users text-blue-500 mr-3"></i>
                            <span class="text-gray-700">Subscriber</span>
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('user.order.index') }}"
                           class="flex items-center px-4 py-2 rounded hover:bg-gray-100
                           {{ Route::currentRouteName() == 'user.order.index' ? 'bg-[#D3E9FF] text-[#052D6E] font-semibold' : '' }}">
                            <i class="fas fa-shopping-cart text-blue-500 mr-3"></i>
                            <span class="text-gray-700">Orders</span>
                        </a>
                    </li>
                </ul>
            </div>

            <hr style="margin-top:30px; margin-bottom:30px; height: 1px; background-color: #1E90FF;">

            <div>
                <a href="{{ route('user.myCollection') }}">
                    <img src="{{ asset('images/library.png') }}" class="w-24 h-24 mb-2">
                </a>


                <a href="{{ route('user.favorite.index') }}"
                   class="flex flex-col
                   {{ Route::currentRouteName() == 'user.favorite.index' ? 'text-[#052D6E] font-semibold' : 'text-gray-700' }}">
                    <span class="text-sm">My Favorite</span>
                </a>
            </div>

        </nav>
    </aside>

    <!-- Main Content -->
<div class="flex-1" style="background-image: url('{{ asset('images/bg.png') }}'); background-size: cover; background-position: center; background-color: white;">

    @yield('content')
</div>

</div>
