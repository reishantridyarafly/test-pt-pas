<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="index.html" class="logo logo-dark">
            <span class="logo-sm">
                <img src="https://recruitment-pas.web.app/assets/logo-pas-with-text.a23ed92b.png" alt=""
                    height="13">
            </span>
            <span class="logo-lg">
                <img src="https://recruitment-pas.web.app/assets/logo-pas-with-text.a23ed92b.png" alt=""
                    height="40">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="index.html" class="logo logo-light">
            <span class="logo-sm">
                <img src="https://recruitment-pas.web.app/assets/logo-pas-with-text.a23ed92b.png" alt=""
                    height="13">
            </span>
            <span class="logo-lg">
                <img src="https://recruitment-pas.web.app/assets/logo-pas-with-text.a23ed92b.png" alt=""
                    height="40">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs(['dashboard.*']) ? 'active' : '' }}"
                        href="{{ route('dashboard.index') }}">
                        <i class="mdi mdi-speedometer"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs(['user.*']) ? 'active' : '' }}"
                        href="{{ route('user.index') }}">
                        <i class="mdi mdi-account-group"></i> <span>Pengguna</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs(['customer.*']) ? 'active' : '' }}"
                        href="{{ route('customer.index') }}">
                        <i class="mdi mdi-account"></i> <span>Pelanggan</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
