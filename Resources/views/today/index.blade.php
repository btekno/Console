@extends('console::today.theme')
@section('inner-title', "Dashboard - ")
@section('sm-home', 'active')

@section('inner-css')
@endsection

@section('inner-js')
@endsection

@section('inner-content')
	
	@include('console::layouts.components.breadcrumb', [
		'title' => 'Dashboard', 
		'breadcrumbs' => [
			route('console::today.index') => 'Today'
		]
	])

	<div class="card card-bordered shadow-none rounded-0">
		<div class="card-body">
			<div class="row gx-2 gx-lg-3">
          <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
            <!-- Card -->
            <a class="card card-hover-shadow h-100" href="#">
              <div class="card-body">
                <h6 class="card-subtitle">Total Users</h6>

                <div class="row align-items-center gx-2 mb-1">
                  <div class="col-6">
                    <span class="card-title h2">72,540</span>
                  </div>

                  <div class="col-6">
                  </div>
                </div>
                <!-- End Row -->

                <span class="badge badge-soft-success">
                  <i class="tio-trending-up"></i> 12.5%
                </span>
                <span class="text-body font-size-sm ml-1">from 70,104</span>
              </div>
            </a>
            <!-- End Card -->
          </div>

          <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
            <!-- Card -->
            <a class="card card-hover-shadow h-100" href="#">
              <div class="card-body">
                <h6 class="card-subtitle">Sessions</h6>

                <div class="row align-items-center gx-2 mb-1">
                  <div class="col-6">
                    <span class="card-title h2">29.4%</span>
                  </div>

                  <div class="col-6">
                  </div>
                </div>
                <!-- End Row -->

                <span class="badge badge-soft-success">
                  <i class="tio-trending-up"></i> 1.7%
                </span>
                <span class="text-body font-size-sm ml-1">from 29.1%</span>
              </div>
            </a>
            <!-- End Card -->
          </div>

          <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
            <!-- Card -->
            <a class="card card-hover-shadow h-100" href="#">
              <div class="card-body">
                <h6 class="card-subtitle">Avg. Click Rate</h6>

                <div class="row align-items-center gx-2 mb-1">
                  <div class="col-6">
                    <span class="card-title h2">56.8%</span>
                  </div>

                  <div class="col-6">
                  </div>
                </div>
                <!-- End Row -->

                <span class="badge badge-soft-danger">
                  <i class="tio-trending-down"></i> 4.4%
                </span>
                <span class="text-body font-size-sm ml-1">from 61.2%</span>
              </div>
            </a>
            <!-- End Card -->
          </div>

          <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
            <!-- Card -->
            <a class="card card-hover-shadow h-100" href="#">
              <div class="card-body">
                <h6 class="card-subtitle">Pageviews</h6>

                <div class="row align-items-center gx-2 mb-1">
                  <div class="col-6">
                    <span class="card-title h2">92,913</span>
                  </div>

                  <div class="col-6">
                    <!-- Chart -->
                  </div>
                </div>
                <!-- End Row -->

                <span class="badge badge-soft-secondary">0.0%</span>
                <span class="text-body font-size-sm ml-1">from 2,913</span>
              </div>
            </a>
            <!-- End Card -->
          </div>
        </div>
		</div>
	</div>
@endsection