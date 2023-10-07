<div class="layout-wrapper layout-content-navbar">

    <div class="layout-container">
        @include('panels.sidebar')

        <div class="layout-page">
            @include('panels.navbar')

            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <div class="layout-overlay layout-menu-toggle"></div>
</div>