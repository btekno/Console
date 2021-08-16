@extends('console::layouts.app')
@section('m-today', 'active')
@section('title')
	@yield('inner-title') Today Module
@endsection

@section('css')
	@yield('inner-css')
@endsection

@section('js')
	@yield('inner-js')
@endsection

@section('content')
	<div class="row no-gutters">
		<div class="col-lg-2">
			<div class="navbar-vertical navbar-expand-lg mb-0">
				<button type="button" class="navbar-toggler btn btn-block btn-white mb-0 mb-lg-3" aria-label="Toggle navigation" aria-expanded="false" aria-controls="navbarVerticalNavMenu" data-toggle="collapse" data-target="#navbarVerticalNavMenu">
					<span class="d-flex justify-content-between align-items-center">
						<span class="h5 mb-0 text-muted">Today Module</span>
						<span class="navbar-toggle-default">
							<i class="tio-menu-hamburger"></i>
						</span>
						<span class="navbar-toggle-toggled">
							<i class="tio-clear"></i>
						</span>
					</span>
				</button>
				<div id="navbarVerticalNavMenu" class="collapse navbar-collapse">
					<ul class="navbar-nav navbar-nav-sm nav-tabs card rounded-0 shadow-none bg-light card-navbar-nav pt-2">
						<li class="nav-item mb-0 @yield('sm-home')">
							<a class="nav-link pl-3 py-1" href="{{ route('console::today.index') }}">
								<i class="tio-clock nav-icon"></i> Beranda
							</a>
						</li>
						<li class="nav-item mb-0 {{ request('only') == 'unapproved' ? 'active' : '' }}">
							<a class="nav-link pl-3 py-1" href="{{ route('console::today.posts.index') }}?only=unapproved">
								<i class="tio-checkmark-square nav-icon"></i> Unapproved
							</a>
						</li>
						<li class="nav-item mb-0 @yield('sm-posts')">
							<a class="nav-link pl-3 py-1" href="{{ route('console::today.posts.index') }}">
								<i class="tio-bookmarks nav-icon"></i> Latest Posts
							</a>
						</li>
						<li class="nav-item mb-0 {{ request('only') == 'featured' ? 'active' : '' }}">
							<a class="nav-link pl-3 py-1" href="{{ route('console::today.posts.index') }}?only=featured">
								<i class="tio-star nav-icon"></i> Featured Posts
							</a>
						</li>
						<li class="nav-item mb-0 {{ request('only') == 'trashed' ? 'active' : '' }}">
							<a class="nav-link pl-3 py-1" href="{{ route('console::today.posts.index') }}?only=trashed">
								<i class="tio-delete nav-icon"></i> Recycle Bin
							</a>
						</li>

						<li class="px-3 mt-3">
							<p class="text-muted text-cap small mb-2">Referensi</p>
						</li>
						<li class="nav-item {{ request()->segment(2) == 'menu' ? 'active' : '' }}">
							<a class="nav-link pl-3 py-1" href="{{ route('console::today.menu.index') }}">
								<i class="tio-format-points nav-icon"></i> Menu
							</a>
						</li>
						<li class="nav-item {{ request()->segment(2) == 'kategori' ? 'active' : '' }}">
							<a class="nav-link pl-3 py-1" href="{{ route('console::today.kategori.index') }}">
								<i class="tio-folder-outlined nav-icon"></i> Kategori
							</a>
						</li>
						<li class="nav-item {{ request()->segment(2) == 'laman' ? 'active' : '' }}">
							<a class="nav-link pl-3 py-1" href="{{ route('console::today.laman.index') }}">
								<i class="tio-pages-outlined nav-icon"></i> Halaman
							</a>
						</li>
						<li class="nav-item {{ request()->segment(2) == 'reaksi' ? 'active' : '' }}">
							<a class="nav-link pl-3 py-1" href="{{ route('console::today.reaksi.index') }}">
								<i class="tio-smile nav-icon"></i> Reaction
							</a>
						</li>
						<li class="nav-item {{ request()->segment(2) == 'widget' ? 'active' : '' }}">
							<a class="nav-link pl-3 py-1" href="{{ route('console::today.widget.index') }}">
								<i class="tio-layout nav-icon"></i> Iklan
							</a>
						</li>
						<li class="nav-item {{ request()->segment(2) == 'member' ? 'active' : '' }}">
							<a class="nav-link pl-3 py-1" href="{{ route('console::today.member.index') }}">
								<i class="tio-account-circle nav-icon"></i> Member
							</a>
						</li>
						<li class="nav-item {{ request()->segment(2) == 'pengaturan' ? 'active' : '' }} mt-3">
							<a class="nav-link pl-3 py-1" href="{{ route('console::today.pengaturan.index') }}">
								<i class="tio-settings nav-icon"></i> Pengaturan
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-lg-10">
			<div class="card card-bordered shadow-none rounded-0" style="min-height: calc(100vh - 105px)">
				@yield('inner-content')
			</div>
		</div>
	</div>
@endsection