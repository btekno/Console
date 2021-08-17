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
                    <!-- Chart -->
                    <div class="chartjs-custom" style="height: 3rem;"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                      <canvas class="js-chart chartjs-render-monitor" data-hs-chartjs-options="{
                                &quot;type&quot;: &quot;line&quot;,
                                &quot;data&quot;: {
                                   &quot;labels&quot;: [&quot;1 May&quot;,&quot;2 May&quot;,&quot;3 May&quot;,&quot;4 May&quot;,&quot;5 May&quot;,&quot;6 May&quot;,&quot;7 May&quot;,&quot;8 May&quot;,&quot;9 May&quot;,&quot;10 May&quot;,&quot;11 May&quot;,&quot;12 May&quot;,&quot;13 May&quot;,&quot;14 May&quot;,&quot;15 May&quot;,&quot;16 May&quot;,&quot;17 May&quot;,&quot;18 May&quot;,&quot;19 May&quot;,&quot;20 May&quot;,&quot;21 May&quot;,&quot;22 May&quot;,&quot;23 May&quot;,&quot;24 May&quot;,&quot;25 May&quot;,&quot;26 May&quot;,&quot;27 May&quot;,&quot;28 May&quot;,&quot;29 May&quot;,&quot;30 May&quot;,&quot;31 May&quot;],
                                   &quot;datasets&quot;: [{
                                    &quot;data&quot;: [21,20,24,20,18,17,15,17,18,30,31,30,30,35,25,35,35,40,60,90,90,90,85,70,75,70,30,30,30,50,72],
                                    &quot;backgroundColor&quot;: [&quot;rgba(55, 125, 255, 0)&quot;, &quot;rgba(255, 255, 255, 0)&quot;],
                                    &quot;borderColor&quot;: &quot;#377dff&quot;,
                                    &quot;borderWidth&quot;: 2,
                                    &quot;pointRadius&quot;: 0,
                                    &quot;pointHoverRadius&quot;: 0
                                  }]
                                },
                                &quot;options&quot;: {
                                   &quot;scales&quot;: {
                                     &quot;yAxes&quot;: [{
                                       &quot;display&quot;: false
                                     }],
                                     &quot;xAxes&quot;: [{
                                       &quot;display&quot;: false
                                     }]
                                   },
                                  &quot;hover&quot;: {
                                    &quot;mode&quot;: &quot;nearest&quot;,
                                    &quot;intersect&quot;: false
                                  },
                                  &quot;tooltips&quot;: {
                                    &quot;postfix&quot;: &quot;k&quot;,
                                    &quot;hasIndicator&quot;: true,
                                    &quot;intersect&quot;: false
                                  }
                                }
                              }" style="display: block; height: 48px; width: 96px;" width="192" height="96">
                      </canvas>
                    </div>
                    <!-- End Chart -->
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
                    <!-- Chart -->
                    <div class="chartjs-custom" style="height: 3rem;"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                      <canvas class="js-chart chartjs-render-monitor" data-hs-chartjs-options="{
                                &quot;type&quot;: &quot;line&quot;,
                                &quot;data&quot;: {
                                   &quot;labels&quot;: [&quot;1 May&quot;,&quot;2 May&quot;,&quot;3 May&quot;,&quot;4 May&quot;,&quot;5 May&quot;,&quot;6 May&quot;,&quot;7 May&quot;,&quot;8 May&quot;,&quot;9 May&quot;,&quot;10 May&quot;,&quot;11 May&quot;,&quot;12 May&quot;,&quot;13 May&quot;,&quot;14 May&quot;,&quot;15 May&quot;,&quot;16 May&quot;,&quot;17 May&quot;,&quot;18 May&quot;,&quot;19 May&quot;,&quot;20 May&quot;,&quot;21 May&quot;,&quot;22 May&quot;,&quot;23 May&quot;,&quot;24 May&quot;,&quot;25 May&quot;,&quot;26 May&quot;,&quot;27 May&quot;,&quot;28 May&quot;,&quot;29 May&quot;,&quot;30 May&quot;,&quot;31 May&quot;],
                                   &quot;datasets&quot;: [{
                                    &quot;data&quot;: [21,20,24,20,18,17,15,17,30,30,35,25,18,30,31,35,35,90,90,90,85,100,120,120,120,100,90,75,75,75,90],
                                    &quot;backgroundColor&quot;: [&quot;rgba(55, 125, 255, 0)&quot;, &quot;rgba(255, 255, 255, 0)&quot;],
                                    &quot;borderColor&quot;: &quot;#377dff&quot;,
                                    &quot;borderWidth&quot;: 2,
                                    &quot;pointRadius&quot;: 0,
                                    &quot;pointHoverRadius&quot;: 0
                                  }]
                                },
                                &quot;options&quot;: {
                                   &quot;scales&quot;: {
                                     &quot;yAxes&quot;: [{
                                       &quot;display&quot;: false
                                     }],
                                     &quot;xAxes&quot;: [{
                                       &quot;display&quot;: false
                                     }]
                                   },
                                  &quot;hover&quot;: {
                                    &quot;mode&quot;: &quot;nearest&quot;,
                                    &quot;intersect&quot;: false
                                  },
                                  &quot;tooltips&quot;: {
                                    &quot;postfix&quot;: &quot;%&quot;,
                                    &quot;hasIndicator&quot;: true,
                                    &quot;intersect&quot;: false
                                  }
                                }
                              }" width="192" height="96" style="display: block; height: 48px; width: 96px;">
                      </canvas>
                    </div>
                    <!-- End Chart -->
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
                    <!-- Chart -->
                    <div class="chartjs-custom" style="height: 3rem;"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                      <canvas class="js-chart chartjs-render-monitor" data-hs-chartjs-options="{
                                &quot;type&quot;: &quot;line&quot;,
                                &quot;data&quot;: {
                                   &quot;labels&quot;: [&quot;1 May&quot;,&quot;2 May&quot;,&quot;3 May&quot;,&quot;4 May&quot;,&quot;5 May&quot;,&quot;6 May&quot;,&quot;7 May&quot;,&quot;8 May&quot;,&quot;9 May&quot;,&quot;10 May&quot;,&quot;11 May&quot;,&quot;12 May&quot;,&quot;13 May&quot;,&quot;14 May&quot;,&quot;15 May&quot;,&quot;16 May&quot;,&quot;17 May&quot;,&quot;18 May&quot;,&quot;19 May&quot;,&quot;20 May&quot;,&quot;21 May&quot;,&quot;22 May&quot;,&quot;23 May&quot;,&quot;24 May&quot;,&quot;25 May&quot;,&quot;26 May&quot;,&quot;27 May&quot;,&quot;28 May&quot;,&quot;29 May&quot;,&quot;30 May&quot;,&quot;31 May&quot;],
                                   &quot;datasets&quot;: [{
                                    &quot;data&quot;: [25,18,30,31,35,35,60,60,60,75,21,20,24,20,18,17,15,17,30,120,120,120,100,90,75,90,90,90,75,70,60],
                                    &quot;backgroundColor&quot;: [&quot;rgba(55, 125, 255, 0)&quot;, &quot;rgba(255, 255, 255, 0)&quot;],
                                    &quot;borderColor&quot;: &quot;#377dff&quot;,
                                    &quot;borderWidth&quot;: 2,
                                    &quot;pointRadius&quot;: 0,
                                    &quot;pointHoverRadius&quot;: 0
                                  }]
                                },
                                &quot;options&quot;: {
                                   &quot;scales&quot;: {
                                     &quot;yAxes&quot;: [{
                                       &quot;display&quot;: false
                                     }],
                                     &quot;xAxes&quot;: [{
                                       &quot;display&quot;: false
                                     }]
                                   },
                                  &quot;hover&quot;: {
                                    &quot;mode&quot;: &quot;nearest&quot;,
                                    &quot;intersect&quot;: false
                                  },
                                  &quot;tooltips&quot;: {
                                    &quot;postfix&quot;: &quot;%&quot;,
                                    &quot;hasIndicator&quot;: true,
                                    &quot;intersect&quot;: false
                                  }
                                }
                              }" width="192" height="96" style="display: block; height: 48px; width: 96px;">
                      </canvas>
                    </div>
                    <!-- End Chart -->
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
                    <div class="chartjs-custom" style="height: 3rem;"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                      <canvas class="js-chart chartjs-render-monitor" data-hs-chartjs-options="{
                                &quot;type&quot;: &quot;line&quot;,
                                &quot;data&quot;: {
                                   &quot;labels&quot;: [&quot;1 May&quot;,&quot;2 May&quot;,&quot;3 May&quot;,&quot;4 May&quot;,&quot;5 May&quot;,&quot;6 May&quot;,&quot;7 May&quot;,&quot;8 May&quot;,&quot;9 May&quot;,&quot;10 May&quot;,&quot;11 May&quot;,&quot;12 May&quot;,&quot;13 May&quot;,&quot;14 May&quot;,&quot;15 May&quot;,&quot;16 May&quot;,&quot;17 May&quot;,&quot;18 May&quot;,&quot;19 May&quot;,&quot;20 May&quot;,&quot;21 May&quot;,&quot;22 May&quot;,&quot;23 May&quot;,&quot;24 May&quot;,&quot;25 May&quot;,&quot;26 May&quot;,&quot;27 May&quot;,&quot;28 May&quot;,&quot;29 May&quot;,&quot;30 May&quot;,&quot;31 May&quot;],
                                   &quot;datasets&quot;: [{
                                    &quot;data&quot;: [21,20,24,15,17,30,30,35,35,35,40,60,12,90,90,85,70,75,43,75,90,22,120,120,90,85,100,92,92,92,92],
                                    &quot;backgroundColor&quot;: [&quot;rgba(55, 125, 255, 0)&quot;, &quot;rgba(255, 255, 255, 0)&quot;],
                                    &quot;borderColor&quot;: &quot;#377dff&quot;,
                                    &quot;borderWidth&quot;: 2,
                                    &quot;pointRadius&quot;: 0,
                                    &quot;pointHoverRadius&quot;: 0
                                  }]
                                },
                                &quot;options&quot;: {
                                   &quot;scales&quot;: {
                                     &quot;yAxes&quot;: [{
                                       &quot;display&quot;: false
                                     }],
                                     &quot;xAxes&quot;: [{
                                       &quot;display&quot;: false
                                     }]
                                   },
                                  &quot;hover&quot;: {
                                    &quot;mode&quot;: &quot;nearest&quot;,
                                    &quot;intersect&quot;: false
                                  },
                                  &quot;tooltips&quot;: {
                                    &quot;postfix&quot;: &quot;k&quot;,
                                    &quot;hasIndicator&quot;: true,
                                    &quot;intersect&quot;: false
                                  }
                                }
                              }" width="192" height="96" style="display: block; height: 48px; width: 96px;">
                      </canvas>
                    </div>
                    <!-- End Chart -->
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