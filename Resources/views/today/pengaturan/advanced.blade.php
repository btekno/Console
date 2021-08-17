@extends('console::today.theme')
@section('inner-title', "Advanced Settings - ")

@section('sm-pengaturan-show', 'show')
@section('sm-pengaturan', 'active')
@section('sm-pengaturan-style', 'style=display:block')
@section('sm-advanced', 'active')

@section('inner-css')
@endsection

@section('inner-js')
@endsection

@section('inner-content')

	@include('console::layouts.components.breadcrumb', [
		'title' => 'Advanced Settings', 
		'breadcrumbs' => [
			route('console::today.index') => 'Today', 
			'#pengaturan' => 'Pengaturan', 
		]
	])

	{!! Form::open(['route' => "$prefix.store", 'autocomplete' => 'off']) !!}
		{!! Form::hidden('page', request('page')) !!}
		
		<div class="card card-bordered shadow-none rounded-0">
			<div class="card-body pb-0" style="height: calc(100vh - 245px);overflow-y: scroll;">

				<div class="row form-group mb-2">
					<label for="head_code" class="col-sm-2 col-form-label font-weight-bold">
						Head Code
					</label>
					<div class="col-sm-10">
						{!! Form::textarea('head_code', null, ['class' => 'form-control', 'rows' => 7]) !!}
						<span class="ml-1 text-muted small">You may want to add some html/css/js code to head. For example custom css. Google verification code or other meta tags etc.</span>
					</div>
				</div>

				<div class="row form-group mb-2">
					<label for="footer_code" class="col-sm-2 col-form-label font-weight-bold">
						Footer Code
					</label>
					<div class="col-sm-10">
						{!! Form::textarea('footer_code', null, ['class' => 'form-control', 'rows' => 7]) !!}
						<span class="ml-1 text-muted small">You may want to add some html/css/js code to footer. For Example Google Analytics code etc.</span>
					</div>
				</div>

			</div>
			<div class="card-footer p-2 rounded-0 bg-light d-flex justify-content-end">
				<button type="submit" class="btn btn-primary">
					<i class="tio-save"></i> Simpan Perubahan
				</button>
			</div>
		</div>

	{!! Form::close() !!}

@endsection