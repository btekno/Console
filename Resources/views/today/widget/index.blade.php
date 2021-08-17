@extends('console::today.theme')
@section('inner-title', "$title - ")

@section('inner-css')
@endsection

@section('inner-js')
    <script>
        $(function() {
            $('.js-select2-custom').each(function () {
                var select2 = $.HSCore.components.HSSelect2.init($(this), {
                	"minimumResultsForSearch": "Infinity"
                });
            });
        });
    </script>

    @include('console::layouts.components.scripts.swal', [
		'redirect' => route("$prefix.index", 'position=' . request('position'))
	])
@endsection

@section('inner-content')
	
	@include('console::layouts.components.breadcrumb', [
        'title' => $title, 
        'hapus' => true, 
        'breadcrumbs' => [
            route('console::today.index') => 'Today', 
            '#referensi' => 'Referensi', 
        ]
    ])

    <div class="row no-gutters">
    	<div class="col-md-7">
    		<div class="card border-0 shadow-none rounded-0">
    			<div class="card-header rounded-0 bg-dark py-2 px-3">
					<h3 class="card-title text-light h5">
						<i class="tio-format-points"></i> List {{ $title }}
					</h3>
				</div>
				<div class="card-body p-0">
					{!! Form::open(['method' => 'GET', 'class' => 'p-2 bg-light']) !!}
						<select class="js-select2-custom custom-select" size="1" style="opacity: 0;" name="position" 
							onchange="this.form.submit()" 
							data-hs-select2-options='{
								"minimumResultsForSearch": "Infinity"
						}'>
						<option value="">Pilih Lokasi Widget</option>
						@foreach(lokasi_widget() as $i => $temp)
							<option value="{{ $i }}"
								@if(request()->filled('position'))
									{{ request('position') == $i ? 'selected' : '' }}
								@endif
								>{{ $temp }}</option>
						@endforeach
						</select>
				    {!! Form::close() !!}

				    <div class="p-2">
				    	@if(!request()->filled('position'))
				    		<div class="row justify-content-sm-center text-center py-10 pb-0 min-height-200px">
								<div class="col-sm-9">
									<img class="img-fluid mb-5" src="https://cdn.btekno.id/templates/console/svg/illustrations/graphs.svg" alt="" style="max-width: 10rem;">
									<h2>Posisi Widget Belum Dipilih</h2>
									<p>Silahkan pilih salah satu posisi widget yang ingin diperbarui.</p>
								</div>
							</div>
				    	@endif

				    	@if(request()->filled('position') && !count($widget))
				    		<div class="row justify-content-sm-center text-center py-10 pb-0 min-height-200px">
								<div class="col-sm-9">
									<img class="img-fluid mb-5" src="https://cdn.btekno.id/templates/console/svg/illustrations/graphs.svg" alt="" style="max-width: 10rem;">
									<h2>Widget Masih Kosong</h2>
									<p>Silahkan tambahkan widget melalui form disamping.</p>
								</div>
							</div>
						@else 
							<div class="accordion" id="accordion-widget">
								@foreach($widget as $i => $temp)
									<div class="card rounded-sm shadow-none p-0" id="heading-{{ ++$i }}">
										<div class="card-header bg-dark text-light btn-block py-2 px-3 collapsed">
											#{{ $i }}. {!! $temp['name'] !!}
											<div>
												<a href="{{ route("$prefix.edit", $temp->id) }}?position={{ request('position') }}" class="mr-2" data-toggle="tooltip" data-original-title="Edit">
													<i class="tio-new-message text-success"></i>
												</a>
												<a href="javascript:;" onclick="modalHapus('{{ $temp->id }}')" class="mr-2" data-toggle="tooltip" data-original-title="Hapus">
													<i class="tio-delete text-danger"></i>
												</a>
												<a class="card-btn-toggle" href="javascript:;" data-toggle="collapse" data-target="#collapse-{{ $i }}" aria-expanded="false" aria-controls="collapse-{{ $i }}">
													<i class="tio-add text-light"></i>
												</a>
											</div>
										</div>
										<div id="collapse-{{ $i }}" class="collapse" aria-labelledby="heading-{{ $i }}" data-parent="#accordion-widget">
											<div class="card-body p-3">
												{!! $temp['html'] !!}
											</div>
											<div class="card-footer p-1 bg-light text-right">
												<span class="text-muted small mr-2">{{ $temp['created_at'] }}</span>
											</div>
										</div>
									</div>
								@endforeach
							</div>
				    	@endif
				    </div>
				</div>
			</div>
    	</div>
		<div class="col-md-5">
			@isset($edit)
				{!! Form::model($edit, ['route' => ["$prefix.update", $edit->id], 'method' => 'PUT', 'files' => true]) !!}
					<div class="card rounded-0 border-0 shadow-none mb-0">
						<div class="card-header rounded-0 bg-dark py-2 px-3">
							<h3 class="card-title text-light h5">
								<i class="tio-new-message"></i> {{ $title }}
							</h3>
						</div>
						@include("$view.form")
					</div>
				{!! Form::close() !!}
			@else
				{!! Form::open(['route' => "$prefix.store", 'files' => true]) !!}
					<div class="card rounded-0 border-0 shadow-none mb-0">
						<div class="card-header rounded-0 bg-dark py-2 px-3">
							<h3 class="card-title text-light h5">
								<i class="tio-add-square-outlined"></i> {{ $title }} Baru
							</h3>
						</div>
						@include("$view.form")
					</div>
				{!! Form::close() !!}
			@endisset
		</div>
    </div>

@endsection