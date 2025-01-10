<link href="https://fonts.googleapis.com/css2?family=Inter:wght@600;700&display=swap" rel="stylesheet">

<div class="flex h-screen bg-gray-100">
    <button
        data-drawer-target="logo-sidebar"
        data-drawer-toggle="logo-sidebar"
        aria-controls="logo-sidebar"
        type="button"
        class="flex items-start bg-white fixed inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
        >
        <span class="sr-only">Open sidebar</span>
        <svg
            class="w-6 h-6"
            aria-hidden="true"
            fill="currentColor"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
            clip-rule="evenodd"
            fill-rule="evenodd"
            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"
            ></path>
        </svg>
    </button>
    <!-- Sidebar -->
    <aside
        id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen sm:min-h-[110vh] transition-transform -translate-x-full sm:translate-x-0  bg-white overflow-y-auto"
        aria-label="Sidebar"
    >
        <!-- Logo -->
        <div class="py-4">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-32 h-auto ml-2">
            <!-- Logo aligned to the left -->
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
                        <a href="{{ route('search_buku') }}"
                        class="flex items-center px-4 py-2 rounded hover:bg-gray-100
                        {{ Route::currentRouteName() == 'search_buku' ? 'bg-[#D3E9FF] text-[#052D6E] font-semibold' : '' }}">
                            <i class="fas fa-search text-blue-500 mr-3"></i>
                            <span class="text-gray-700">Search</span>
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('user.highlight') }}"
                        class="flex items-center px-4 py-2 rounded hover:bg-gray-100
                        {{ Route::currentRouteName() == 'user.highlight' ? 'bg-[#D3E9FF] text-[#052D6E] font-semibold' : '' }}">
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
                        <a href="{{ route('user.order.index') }}"
                            class="flex items-center px-4 py-2 rounded hover:bg-gray-100
                           {{ Route::currentRouteName() == 'user.order.index' ? 'bg-[#D3E9FF] text-[#052D6E] font-semibold' : '' }}">
                            <i class="fas fa-shopping-cart text-blue-500 mr-3"></i>
                            <span class="text-gray-700">Orders</span>
                        </a>
                    </li>
                </ul>
            </div>
            <hr class="my-8 border-t-1 border-[#1E90FF]">

            <div>
                <ul>
                    <li class="mb-2">
                        <a href="{{ route('user.langganan.index') }}"
                            class="flex items-center px-4 py-2 rounded hover:bg-gray-100
                   {{ Route::currentRouteName() == 'user.langganan.index' ? 'bg-[#D3E9FF] text-[#052D6E] font-semibold' : '' }}">
                            <i class="fas fa-users text-blue-500 mr-3"></i>
                            <span class="text-gray-700">Profile Anda</span>
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#logout" id="button-logout"
                            class="flex items-center px-4 py-2 rounded hover:bg-gray-100
                  'bg-[#D3E9FF] text-[#1E90FF] font-semibold' : '' }}">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            <span class="text-gray-700">Logout</span>
                        </a>
                    </li>
                </ul>

            </div>
            <hr class="my-8 border-t-1 border-[#1E90FF]">

            <div>
                <a href="{{ route('user.myCollection') }}">
                    <img src="{{ asset('images/library.png') }}" class="w-24 h-24 mb-2">
                </a>


                <a href="{{ route('user.myCollection') }}"
                    class="flex flex-col
                   {{ Route::currentRouteName() == 'user.myCollection' ? 'text-[#052D6E] font-semibold' : 'text-gray-700' }}">
                    <span class="text-sm">My Favorite</span>
                </a>
            </div>

        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 sm:ml-64"
        style="background-image: url('{{ asset('images/bg.png') }}'); background-size: cover; background-position: center; background-color: white;">

        @yield('content')
    </div>
</div>
