<!-- Sidebar -->
<nav class="col-md-2 sidebar">
    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            {{-- <li class="nav-item {{ request()->is('/dashboard') ? 'side-nav' : '' }}">
                <a class="nav-link" href="#"><img src="images/eye.png" class="sidebar-icon"/>&nbsp; &nbsp;Dashboard</a>
            </li> --}}
            {{-- <li class="nav-item {{ request()->is('products') ? 'active-link' : '' }}">
                <a class="nav-link" href="#">Products</a>
            </li>
            <li class="nav-item {{ request()->is('orders') ? 'active-link' : '' }} ">
                <a class="nav-link" href="#">Orders</a>
            </li> --}}
            <li class="nav-item side-nav {{ Route::currentRouteName() === 'admin.resale-requests' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.resale-requests') }}"><img src="images/eye.png" class="sidebar-icon"/>&nbsp; &nbsp;Manage Resale Requests</a>
            </li>
        </ul>
    </div>
</nav>
