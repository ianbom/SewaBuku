<header class="bg-gray-800 text-white">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <!-- Logo -->
        <div class="text-2xl font-bold">
            <a href="#" class="text-white">BookRent Admin</a>
        </div>

        <!-- Navigation Menu (Desktop) -->
        <nav class="hidden md:flex space-x-6">
            <a href="{{ route('admin.buku.index') }}" class="hover:text-gray-400">Buku</a>
            <a href="{{ route('admin.order.index') }}" class="hover:text-gray-400">Order</a>
            <a href="{{ route('admin.user.index') }}" class="hover:text-gray-400">User</a>
            <a href="{{ route('admin.profile') }}" class="hover:text-gray-400">Profile</a>
            <a href="{{ route('admin.tags.index') }}" class="hover:text-gray-400">Tags</a>
        </nav>

        <!-- Hamburger Menu (Mobile) -->
        <div class="md:hidden">
            <button id="menu-toggle" class="text-white focus:outline-none">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden bg-gray-800 md:hidden">
        <nav class="flex flex-col space-y-4 p-4">
            <a href="{{ route('admin.buku.index') }}" class="hover:text-gray-400">Buku</a>
            <a href="{{ route('admin.order.index') }}" class="hover:text-gray-400">Order</a>
            <a href="{{ route('admin.user.index') }}" class="hover:text-gray-400">User</a>
            <a href="{{ route('admin.profile') }}" class="hover:text-gray-400">Profile</a>
            <a href="{{ route('admin.tags.index') }}" class="hover:text-gray-400">Tags</a>
        </nav>
    </div>
</header>
<script>
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    menuToggle.addEventListener('click', function() {
        mobileMenu.classList.toggle('hidden');
    });
</script>
