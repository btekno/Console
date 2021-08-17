@extends('console::today.theme')
@section('inner-title', "Social Media - ")

@section('sm-pengaturan-show', 'show')
@section('sm-pengaturan', 'active')
@section('sm-pengaturan-style', 'style=display:block')
@section('sm-social-media', 'active')

@section('inner-css')
@endsection

@section('inner-js')
@endsection

@section('inner-content')

	@include('console::layouts.components.breadcrumb', [
		'title' => 'Social Media', 
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
                    <label for="facebookpage" class="col-sm-5 col-form-label font-weight-bold">
                        Facebook URL
                        <span class="d-block text-muted small">Button Text (Leave empty for default)</span>
                    </label>
                    <div class="col-sm-7">
                        <div class="input-group input-group-sm-down-break">
                            <input type="text" class="form-control" name="facebookpage" placeholder="Facebook URL" value="">
                            <input type="text" class="form-control" name="facebookpage_btn_text" value="" placeholder="Follow Us on Facebook">
                        </div>
                    </div>
                </div>

                <div class="row form-group mb-2">
                    <label for="twitterpage" class="col-sm-5 col-form-label font-weight-bold">
                        Twitter
                        <span class="d-block text-muted small">Button Text (Leave empty for default)</span>
                    </label>
                    <div class="col-sm-7">
                        <div class="input-group input-group-sm-down-break">
                            <input type="text" class="form-control" name="twitterpage" placeholder="Twitter URL" value="">
                            <input type="text" class="form-control" name="twitterpage_btn_text" value="" placeholder="Follow Us on Twitter">
                        </div>
                    </div>
                </div>

                <div class="row form-group mb-2">
                    <label for="youtubepage" class="col-sm-5 col-form-label font-weight-bold">
                        Youtube
                        <span class="d-block text-muted small">Button Text (Leave empty for default)</span>
                    </label>
                    <div class="col-sm-7">
                        <div class="input-group input-group-sm-down-break">
                            <input type="text" class="form-control" name="youtubepage" placeholder="Youtube Channel URL" value="">
                            <input type="text" class="form-control" name="youtubepage_btn_text" value="" placeholder="Subscribe Us on Youtube">
                        </div>
                    </div>
                </div>

                <div class="row form-group mb-2">
                    <label for="instagrampage" class="col-sm-5 col-form-label font-weight-bold">
                        Instagram
                        <span class="d-block text-muted small">Button Text (Leave empty for default)</span>
                    </label>
                    <div class="col-sm-7">
                        <div class="input-group input-group-sm-down-break">
                            <input type="text" class="form-control" name="instagrampage" placeholder="Instagram URL" value="">
                            <input type="text" class="form-control" name="instagrampage_btn_text" value="" placeholder="Follow Us on Instagram">
                        </div>
                    </div>
                </div>

                <div class="row form-group mb-2">
                    <label for="rsspage" class="col-sm-5 col-form-label font-weight-bold">
                        RSS
                        <span class="d-block text-muted small">Button Text (Leave empty for default)</span>
                    </label>
                    <div class="col-sm-7">
                        <div class="input-group input-group-sm-down-break">
                            <input type="text" class="form-control" name="rsspage" placeholder="RSS URL" value="">
                            <input type="text" class="form-control" name="rsspage_btn_text" value="" placeholder="Subscribe to our RSS">
                        </div>
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