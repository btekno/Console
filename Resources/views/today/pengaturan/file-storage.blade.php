@extends('console::today.theme')
@section('inner-title', "File Storage - ")

@section('sm-pengaturan-show', 'show')
@section('sm-pengaturan', 'active')
@section('sm-pengaturan-style', 'style=display:block')
@section('sm-file-storage', 'active')

@section('inner-css')
@endsection

@section('inner-js')
@endsection

@section('inner-content')

	@include('console::layouts.components.breadcrumb', [
		'title' => 'File Storage', 
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
                    <label for="user_max_fileupload_size" class="col-sm-2 col-form-label font-weight-bold">
                        Max File Upload Size
                    </label>
                    <div class="col-sm-10">
                        {!! Form::text('user_max_fileupload_size', null, ['class' => 'form-control', 'placeholder' => '2000']) !!}
                        <span class="help-block small">Maximum size for a single file user can upload. Default: 2000=2MB</span>
                    </div>
                </div>

                <hr/>

                <div class="row form-group mb-2">
                    <label for="FILESYSTEM_DRIVER" class="col-sm-2 col-form-label font-weight-bold">
                        Use AWS S3
                    </label>
                    <div class="col-sm-10">
                        {!! Form::select('FILESYSTEM_DRIVER', ['local' => 'No', 's3' => 'Yes'], null, ['class' => 'form-control js-select2-custom']) !!}
                    </div>
                </div>

                <div class="row form-group mb-2">
                    <label for="AWS_ACCESS_KEY_ID" class="col-sm-2 col-form-label font-weight-bold">
                        AWS Key ID
                    </label>
                    <div class="col-sm-10">
                        {!! Form::text('AWS_ACCESS_KEY_ID', null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="row form-group mb-2">
                    <label for="AWS_SECRET_ACCESS_KEY" class="col-sm-2 col-form-label font-weight-bold">
                        AWS Secret Key
                    </label>
                    <div class="col-sm-10">
                        {!! Form::text('AWS_SECRET_ACCESS_KEY', null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="row form-group mb-2">
                    <label for="AWS_DEFAULT_REGION" class="col-sm-2 col-form-label font-weight-bold">
                        AWS Region
                    </label>
                    <div class="col-sm-10">
                        {!! Form::text('AWS_DEFAULT_REGION', null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="row form-group mb-2">
                    <label for="AWS_BUCKET" class="col-sm-2 col-form-label font-weight-bold">
                        AWS Bucket
                    </label>
                    <div class="col-sm-10">
                        {!! Form::text('AWS_BUCKET', null, ['class' => 'form-control']) !!}
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