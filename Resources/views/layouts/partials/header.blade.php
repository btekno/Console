<header id="header" class="navbar navbar-expand-lg navbar-fixed navbar-bordered flex-lg-column px-0">
    <div class="w-100">
        <div class="container-fluid px-3">
            <div class="navbar-nav-wrap">
                <div class="navbar-brand-wrapper">
                    <a class="navbar-brand" href="{{ route('console::index') }}" aria-label="">
                        <img class="navbar-brand-logo" src="{{ asset('assets/default/img/logo-btekno.png') }}" alt="Logo">
                    </a>
                </div>
                <div class="navbar-nav-wrap-content-left">
                    <div class="d-none d-lg-block">
                        <form class="position-relative">
                            <div class="input-group input-group-merge input-group-borderless input-group-hover-light navbar-input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="tio-search"></i>
                                    </div>
                                </div>
                                <input type="search" class="js-form-search form-control" placeholder="Pencarian cepat ...">
                                <a class="input-group-append" href="javascript:;">
                                    <span class="input-group-text">
                                        <i id="clearSearchResultsIcon" class="tio-clear" style="display: none;"></i>
                                    </span>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="navbar-nav-wrap-content-right">
                    <ul class="navbar-nav align-items-center flex-row">
                        <li class="nav-item d-lg-none">
                            <div class="hs-unfold">
                                <a class="js-hs-unfold-invoker btn btn-icon btn-ghost-light rounded-circle" href="javascript:;" data-hs-unfold-options="{
                                        &quot;target&quot;: &quot;#searchDropdown&quot;,
                                        &quot;type&quot;: &quot;css-animation&quot;,
                                        &quot;animationIn&quot;: &quot;fadeIn&quot;,
                                        &quot;hasOverlay&quot;: &quot;rgba(46, 52, 81, 0.1)&quot;,
                                        &quot;closeBreakpoint&quot;: &quot;md&quot;
                                    }" data-hs-unfold-target="#searchDropdown" data-hs-unfold-invoker="">
                                    <i class="tio-search"></i>
                                </a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <div class="hs-unfold">
                                <a class="js-hs-unfold-invoker navbar-dropdown-account-wrapper" href="javascript:;" data-hs-unfold-options="{
                                        &quot;target&quot;: &quot;#accountNavbarDropdown&quot;,
                                        &quot;type&quot;: &quot;css-animation&quot;
                                    }" data-hs-unfold-target="#accountNavbarDropdown" data-hs-unfold-invoker="">
                                    <div class="avatar avatar-sm avatar-circle">
                                        <img class="avatar-img" src="{{ me()->photo }}" alt="{{ me()->name }}">
                                        <span class="avatar-status avatar-sm-status avatar-status-success"></span>
                                    </div>
                                </a>
                                <div id="accountNavbarDropdown" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right navbar-dropdown-menu navbar-dropdown-account hs-unfold-hidden hs-unfold-content-initialized hs-unfold-css-animation animated" style="width: 16rem; animation-duration: 300ms;" data-hs-target-height="396.281" data-hs-unfold-content="" data-hs-unfold-content-animation-in="slideInUp" data-hs-unfold-content-animation-out="fadeOut">
                                    <div class="dropdown-item-text">
                                        <div class="media align-items-center">
                                            <div class="avatar avatar-sm avatar-circle mr-2">
                                                <img class="avatar-img" src="{{ me()->photo }}" alt="{{ me()->name }}">
                                            </div>
                                            <div class="media-body">
                                                <span class="card-title h5">{{ me()->name }}</span>
                                                <span class="card-text text-truncate">{{ me()->email }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="dropdown-divider"></div>

                                    <a class="dropdown-item" href="{{ route('logout') }}">
                                        <span class="text-truncate text-danger pr-2" title="SSO Logout">
                                            <b>SSO LOGOUT</b>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item">
                            <button type="button" class="navbar-toggler btn btn-ghost-light rounded-circle" aria-label="Toggle navigation" aria-expanded="false" aria-controls="navbarNavMenu" data-toggle="collapse" data-target="#navbarNavMenu">
                                <i class="tio-menu-hamburger"></i>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @include('console::layouts.partials.nav')
</header>