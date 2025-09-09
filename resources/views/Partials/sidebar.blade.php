<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url("/") }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-tools"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SIPM</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    @if (auth()->user()->is_admin === 1)
        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            <a class="nav-link" href="{{ url("/") }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        {{-- <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div> --}}

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-table"></i>
                <span>Barang</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="collapse-inner rounded bg-white py-2">
                    <h6 class="collapse-header">Barang</h6>
                    <a class="collapse-item" href="{{ url("/item") }}">Barang </a>
                    <a class="collapse-item" href="{{ url("/received-item") }}">Barang Masuk</a>
                    <a class="collapse-item" href="{{ url("/outgoing-item") }}">Barang Keluar</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Tables -->
        <li class="nav-item">
            <a class="nav-link" href="{{ url("/users") }}">
                <i class="fas fa-fw fa-users"></i>
                <span>User</span></a>
        </li>

        <!-- Nav Item - Tables -->
        <li class="nav-item">
            <a class="nav-link" href="{{ url("/order") }}">
                <i class="fas fa-fw fa-business-time"></i>
                <span>Order</span></a>
        </li>

        <!-- Nav Item - Tables -->
        {{-- <li class="nav-item">
            <a class="nav-link" href="{{ url("/edit-admin") }}">
                <i class="fas fa-fw fa-business-time"></i>
                <span>Admin</span></a>
        </li> --}}
    @else
        <!-- Nav Item - Tables -->
        <li class="nav-item">
            <a class="nav-link" href="{{ url("/user-worker") }}">
                <i class="fas fa-fw fa-business-time"></i>
                <span>Pekerjaan</span></a>
        </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="d-none d-md-inline text-center">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->
    {{-- <div class="sidebar-card d-none d-lg-flex">
        <img class="sidebar-card-illustration mb-2" src="{{ asset("FE/img/undraw_rocket.svg") }}" alt="...">
        <p class="mb-2 text-center"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!
        </p>
        <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
    </div> --}}
</ul>
