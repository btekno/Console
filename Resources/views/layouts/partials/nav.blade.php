<div class="container-fluid">
    <nav class="js-mega-menu flex-grow-1 hs-menu-initialized hs-menu-horizontal">
        <div class="navbar-nav-wrap-navbar collapse navbar-collapse" id="navbarNavMenu">
            <div class="navbar-body">
                <ul class="navbar-nav flex-grow-1">
                    <li class="navbar-nav-item">
                        <a id="dashboardsDropdown" class="navbar-nav-link nav-link @yield('m-home')" href="{{ route('console.index') }}">
                            <i class="tio-home-vs-1-outlined nav-icon"></i> Home
                        </a>
                    </li>

                    @if(me()->level == 'Admin')
                        @include('panel.layouts.partials.nav.admin')
                    @endif

                    @if(me()->level == 'RT')
                        @include('panel.layouts.partials.nav.rt')
                    @endif

                    @if(me()->level == 'Kelurahan')
                        @include('panel.layouts.partials.nav.kelurahan')
                    @endif

                    @if(me()->level == 'Kecamatan')
                        @include('panel.layouts.partials.nav.kecamatan')
                    @endif

                    @if(me()->level == 'BAPPEDA')
                        @include('panel.layouts.partials.nav.bappeda')
                    @endif

                </ul>
            </div>
        </div>
    </nav>
</div>