<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <div class="app-brand">
        <a href="#" class="app-brand-link">
            <span class="app-brand-logo">
                <img src="{{ asset('img/logo.png') }}" alt="logo"
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
        <li class="menu-item {{ request()->is('students') ? 'active' : '' }}">
            <a href="{{route('student.dashboard')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Pages</span>
        </li>
        
        <li class="menu-item {{ request()->is('students/create-request') ? 'active' : '' }}">
            <a href="{{ route('student.request.create') }}" class="menu-link">
                <i class='menu-icon bx bx-user-voice'></i>
                <div data-i18n="Requestor">Add Request</div>
            </a>
        </li>

        <li class="menu-item {{ request()->is('students/profile*') ? 'active open' : '' }}">
            <a href="#" class="menu-link menu-toggle">                
                <i class='menu-icon bx bx-cog'></i>
                <div class="text-truncate" data-i18n="Profile">
                    Profile
                </div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('students/profile/information') ? 'active' : '' }}">
                    <a href="{{ route('student.profile') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Information">Information</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('students/profile/education') ? 'active' : '' }}">
                    <a href="{{ route('student.profile.education') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Education">Education</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('students/profile/change-password') ? 'active' : '' }}">
                    <a href="{{ route('student.profile.change.password') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Change Password">Change Password</div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>
