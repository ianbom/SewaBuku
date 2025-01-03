<div id="sidebar">
    <div class="sidebar-wrapper">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" srcset="">
                    </a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>

                <li class="sidebar-item {{ Route::is('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Beranda</span>
                    </a>
                </li>

                <li class="sidebar-item {{ Route::is('admin.buku.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.buku.index') }}" class='sidebar-link'>
                        <i class="bi bi-book"></i>
                        <span>Buku</span>
                    </a>
                </li>

                <li class="sidebar-item {{ Route::is('admin.order.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.order.index') }}" class='sidebar-link'>
                        <i class="bi bi-bag"></i>
                        <span>Order</span>
                    </a>
                </li>

                <li class="sidebar-item {{ Route::is('admin.user.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.user.index') }}" class='sidebar-link'>
                        <i class="bi bi-people"></i>
                        <span>User</span>
                    </a>
                </li>

                <li class="sidebar-item {{ Route::is('admin.profile') ? 'active' : '' }}">
                    <a href="{{ route('admin.profile') }}" class='sidebar-link'>
                        <i class="bi bi-person"></i>
                        <span>Profile</span>
                    </a>
                </li>

                <li class="sidebar-item {{ Route::is('admin.tags.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.tags.index') }}" class='sidebar-link'>
                        <i class="bi bi-tags"></i>
                        <span>Tags</span>
                    </a>
                </li>

                <li class="sidebar-item {{ Route::is('paket-langganan.index') ? 'active' : '' }}">
                    <a href="{{ route('paket-langganan.index') }}" class='sidebar-link'>
                        <i class="bi bi-box-seam"></i>
                        <span>Paket Langganan</span>
                    </a>
                </li>

                <li class="sidebar-title">Keluar</li>
                <li class="sidebar-item">
                    <a type="button" class='sidebar-link' id="button-logout">
                        <i class="bi bi-box-arrow-left"></i>
                        <span>Keluar</span>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
