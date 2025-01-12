<header class="bg-white fixed top-0 w-full z-50 ">
    <div class="container mx-auto">
        <div class="flex items-center justify-between py-4">
            <!-- Logo -->
            <div class="flex items-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-40 h-auto ml-2">
            </div>

            <!-- Navigation Menu -->
            {{-- <nav class="hidden md:flex space-x-8">
          <a href="{{ route('sewa_buku.user.landing') }}"
              class=" rounded-md
              {{ Route::currentRouteName() == 'sewa_buku.user.landing' ? 'text-[#1E90FF] font-bold' : 'text-[#979797]' }}
              hover:text-[#1E90FF]" style="font-family: 'Libre Baskerville', serif;">
               Home
          </a>
          <a href="{{ route('user.buku.index') }}"
              class=" rounded-md
              {{ Route::currentRouteName() == 'user.buku.index' ? 'text-[#1E90FF] font-bold' : 'text-[#979797]' }}
              hover:text-[#1E90FF]" style="font-family: 'Libre Baskerville', serif;">
              Explore
          </a>
          <a href="{{ route('user.myCollection') }}"
              class=" rounded-md
              {{ Route::currentRouteName() == 'user.myCollection' ? 'text-[#1E90FF] font-bold' : 'text-[#979797]' }}
              hover:text-[#1E90FF]" style="font-family: 'Libre Baskerville', serif;">
              My Collection
          </a>
        </nav> --}}

            <!-- Buttons -->
            <div class="hidden md:flex space-x-2">
                @auth
                    <a href="{{ route('user.buku.index') }}"
                        class="bg-[#D3E9FF] text-[#1E90FF] px-6 py-2  rounded-[16px] hover:bg-[#1E90FF] hover:text-white font-semibold">
                        Explore Books
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="bg-[#D3E9FF] text-[#1E90FF] px-6 py-2  rounded-[16px] hover:bg-[#1E90FF] hover:text-white font-semibold">
                        Login
                    </a>
                @endauth
                <a href="{{ route('sewa_buku.user.landing') . '#subscription' }}"
                    class="bg-gradient-to-r from-[#1E90FF] to-[#052D6E] text-white px-6 py-2 rounded-[16px] hover:bg-blue-600 font-semibold flex items-center space-x-2">Subscribe
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <button id="menu-toggle"
                class="bg-[#D3E9FF] p-2 rounded-[8px] md:hidden text-[#052D6E] hover:text-[#1E90FF] focus:outline-none mr-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Navigation -->
    <div id="mobile-menu" class="hidden md:hidden bg-white pb-4">
        {{-- <nav class="space-y-1 px-4">
          <!-- Navigation Menu -->
          <a href="{{ route('sewa_buku.user.landing') }}"
             class="block rounded-md {{ Route::currentRouteName() == 'sewa_buku.user.landing' ? 'text-[#1E90FF] font-bold' : 'text-[#979797]' }} hover:text-[#1E90FF] hover:bg-[#D3E9FF] py-1 px-4"
             style="font-family: 'Libre Baskerville', serif;">
             Home
          </a>
          <hr class="border-t-1 border-[#1E90FF]">

          <a href="{{ route('user.buku.index') }}"
             class="block rounded-md {{ Route::currentRouteName() == 'user.buku.index' ? 'text-[#1E90FF] font-bold' : 'text-[#979797]' }} hover:text-[#1E90FF] hover:bg-[#D3E9FF] py-1 px-4"
             style="font-family: 'Libre Baskerville', serif;">
             Explore
          </a>
          <hr class="border-t-1 border-[#1E90FF]">

          <a href="{{ route('user.myCollection') }}"
             class="block rounded-md {{ Route::currentRouteName() == 'user.myCollection' ? 'text-[#1E90FF] font-bold' : 'text-[#979797]' }} hover:text-[#1E90FF] hover:bg-[#D3E9FF] py-1 px-4"
             style="font-family: 'Libre Baskerville', serif;">
             My Collection
          </a>
          <hr class="border-t-1 border-[#1E90FF]">
      </nav> --}}

        <nav class="space-y-3 mt-4 px-4">
            <a href="#subscribe"
                class="block bg-gradient-to-r from-[#1E90FF] to-[#052D6E] text-white px-6 py-2 rounded-[16px] hover:bg-blue-600 font-semibold flex items-center justify-center space-x-2 text-center">
                Subscribe
            </a>

            <a href="{{ route('login') }}"
                class="block bg-[#D3E9FF] text-[#1E90FF] px-6 py-2 rounded-[16px] hover:bg-[#1E90FF] hover:text-white font-semibold text-center">
                Login
            </a>
        </nav>
    </div>

</header>

@yield('content')

<script>
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    menuToggle.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
</script>
