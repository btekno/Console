<div class="container-fluid bg-light">
    <nav class="js-mega-menu flex-grow-1 hs-menu-initialized hs-menu-horizontal">
        <div class="navbar-nav-wrap-navbar collapse navbar-collapse" id="navbarNavMenu">
            <div class="navbar-body">
                <ul class="navbar-nav flex-grow-1">
                    <li class="navbar-nav-item">
                        <a class="navbar-nav-link nav-link py-1 @yield('m-home')" href="{{ route('console::index') }}">
                            <i class="tio-dashboard nav-icon"></i> Home
                        </a>
                    </li>
                    <li class="navbar-nav-item">
                        <a class="navbar-nav-link nav-link py-1 @yield('m-mailbox')" href="">
                            <i class="tio-inbox nav-icon"></i> Mailbox
                        </a>
                    </li>
                    <li class="navbar-nav-item">
                        <a class="navbar-nav-link nav-link py-1 @yield('m-members')" href="{{ route('console::members.index') }}">
                            <i class="tio-account-square nav-icon"></i> Member
                        </a>
                    </li>
                    
                    <li class="navbar-nav-item">
                        <a class="navbar-nav-link nav-link py-1 @yield('m-komix')" href="{{ route('console::komix.index') }}">
                            <i class="tio-album nav-icon"></i> Komix
                        </a>
                    </li>
                    <li class="navbar-nav-item">
                        <a class="navbar-nav-link nav-link py-1 @yield('m-today')" href="{{ route('console::today.index') }}">
                            <i class="tio-feed nav-icon"></i> Today
                        </a>
                    </li>
                    <li class="navbar-nav-item">
                        <a class="navbar-nav-link nav-link py-1 @yield('m-kamus')" href="{{ route('console::kamus.index') }}">
                            <i class="tio-book-opened nav-icon"></i> Qamus
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>