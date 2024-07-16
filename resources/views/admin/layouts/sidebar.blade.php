<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('admin/index') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('assets/img/logo/logo2.png') }}">
        </div>
        <div class="sidebar-brand-text mx-3">Self Holidays</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('hotels.index') }}">
            <i class="fas fa-fw fa-hotel"></i>
            <span>Hotels</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('admin/bookings') }}">
            <i class="fas fa-fw fa-book"></i>
            <span>Bookings</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('users.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Users</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('room-categories.index') }}">
            <i class="fas fa-fw fa-bed"></i>
            <span>Room Categories</span>
        </a>
    </li>
    
    <hr class="sidebar-divider">
    <li class="nav-item p-2">
        <form action="{{ url('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger btn-block">
                <i class="fas fa-fw fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </form>
    </li>
    <hr class="sidebar-divider">
    <div class="version" id="version-ruangadmin"></div>
</ul>
<!-- Sidebar -->
