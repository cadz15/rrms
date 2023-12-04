<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <div class="app-brand">
        <a href="#" class="app-brand-link">
            <span class="app-brand-logo">
                <img src="https://rssoncr.psa.gov.ph/sites/default/files/ocrg_new_logo%20copy_0.png" alt="logo"
                class="">
            </span>
            <span class="app-brand-text menu-text fw-bolder ms-2">RRMS</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <!-- Menu -->
    <ul class="menu-inner py-1" id="sidebar-nav">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->is('/') ? 'active' : '' }}">
            <a href="{{route('dashboard')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Pages</span>
        </li>

        <li class="menu-item {{ request()->is('requestors') ? 'active' : '' }}">
            <a href="{{ route('requestors.list') }}" class="menu-link">
                <i class='menu-icon bx bx-user-voice'></i>
                <div data-i18n="Requestor">Requestor</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('requests.*') ? 'active open' : '' }}">
            <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon bx bx-receipt"></i>
                <div class="text-truncate" data-i18n="Requests">
                    Requests
                </div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('student/create') ? 'active' : '' }}">
                    <a href="/student/create" class="menu-link">
                        <div class="text-truncate" data-i18n="Add Student">Add Request</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('requests.list-web') ? 'active' : '' }}">
                    <a href="{{ route('requests.list-web') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="List">List</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ request()->routeIs('student.*') ? 'active open' : '' }}">
            <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div class="text-truncate" data-i18n="Students">
                    Students
                </div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('student/create') ? 'active' : '' }}">
                    <a href="/student/create" class="menu-link">
                        <div class="text-truncate" data-i18n="Add Student">Add Student</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('student/list') ? 'active' : '' }}">
                    <a href="/student/list" class="menu-link">
                        <div class="text-truncate" data-i18n="List">List</div>
                    </a>
                </li>
            </ul>
        </li>

    </ul>
</aside>
