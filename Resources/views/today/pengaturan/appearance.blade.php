@extends('console::today.theme')
@section('inner-title', "Appearance - ")

@section('sm-pengaturan-show', 'show')
@section('sm-pengaturan', 'active')
@section('sm-pengaturan-style', 'style=display:block')
@section('sm-appearance', 'active')

@section('inner-css')
@endsection

@section('inner-js')
@endsection

@section('inner-content')

	@include('console::layouts.components.breadcrumb', [
		'title' => 'Appearance', 
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
                    <label for="T_modern_googlefont" class="col-sm-5 col-form-label font-weight-bold py-0">
                        <span class="font-weight-bold">Google Font Config</span>
                        <span class="help-block d-block small">
                            Change Google Font Here. Find your perfect font on <a href="https://www.google.com/fonts" target="_blank">Google Fonts</a>.
                        </span>
                    </label>
                    <div class="col-sm-7">
                        {!! Form::text('T_modern_googlefont', null, ['class' => 'form-control', 'placeholder' => 'Lato:400,500,500italic,600,700&amp;subset=latin,latin-ext']) !!}
                    </div>
                </div>

                <div class="row form-group mb-2">
                    <label for="T_modern_sitefontfamily" class="col-sm-5 col-form-label font-weight-bold py-0">
                        <span class="font-weight-bold">Site Font</span>
                        <span class="help-block d-block small">
                            Set your site font family.
                        </span>
                    </label>
                    <div class="col-sm-7">
                        {!! Form::text('T_modern_sitefontfamily', null, ['class' => 'form-control', 'placeholder' => "'Lato', Helvetica, Arial, sans-serif"]) !!}
                    </div>
                </div>

                <hr/>

                <div class="row form-group mb-2">
                    <label for="T_modern_SiteHeadlineStyle" class="col-sm-8 col-form-label font-weight-bold">
                        Homepage Headline Style
                    </label>
                    <div class="col-sm-4">
                        <select class="form-control" name="T_modern_SiteHeadlineStyle"><option value="1">Style 1 - Boxes</option><option value="3">Style 2 - Boxes</option><option value="4">Style 3 - Tall Boxes</option><option value="5">Style 4 - Two Big Boxes</option><option value="2">Style 5 - Slider Type</option><option value="off">No Headline Post</option></select>
                    </div>
                </div>
                <div class="row form-group mb-2">
                    <label for="T_modern_CatHeadlineStyle" class="col-sm-8 col-form-label font-weight-bold">
                        Category Pages Headline Style
                    </label>
                    <div class="col-sm-4">
                        <select class="form-control" name="T_modern_CatHeadlineStyle"><option value="1">Style 1 - Boxes</option><option value="3">Style 2 - Boxes</option><option value="4">Style 3 - Tall Boxes</option><option value="5">Style 4 - Two Big Boxes</option><option value="2">Style 5 - Slider Type</option><option value="off">No Headline Post</option></select>
                    </div>
                </div>
                <div class="row form-group mb-2">
                    <label for="T_modern_PostPageAutoload" class="col-sm-8 col-form-label font-weight-bold">
                        Post Page AutoLoad Style
                    </label>
                    <div class="col-sm-4">
                        <select class="form-control" name="T_modern_PostPageAutoload"><option value="autoload">Autoload Next Post</option><option value="related">Show only "You may also like" section</option></select>
                    </div>
                </div>
                <div class="row form-group mb-2">
                    <label for="T_modern_PostPreviewShow" class="col-sm-8 col-form-label font-weight-bold">
                        Show Preview Image on Post Page
                    </label>
                    <div class="col-sm-4">
                        <select class="form-control" name="T_modern_PostPreviewShow"><option value="no">No</option><option value="yes">Yes</option></select>
                    </div>
                </div>
                <div class="row form-group mb-2">
                    <label for="T_modern_BodyBC" class="col-sm-8 col-form-label font-weight-bold">
                        Site Background Color:
                    </label>
                    <div class="col-sm-4">
                        <div class="input-group my-colorpicker2 colorpicker-element">
                            <input type="text" name="T_modern_BodyBC" class="form-control" value="">
                            <div class="input-group-addon">
                                <i style="background-color: rgb(0, 0, 0);"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row form-group mb-2">
                    <label for="T_modern_NavbarBC" class="col-sm-8 col-form-label font-weight-bold">
                        Navbar Background Color:
                    </label>
                    <div class="col-sm-4">
                        <div class="input-group my-colorpicker2 colorpicker-element">
                            <input type="text" name="T_modern_NavbarBC" class="form-control" value="">
                            <div class="input-group-addon">
                                <i style="background-color: rgb(0, 0, 0);"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row form-group mb-2">
                    <label for="T_modern_NavbarTBLC" class="col-sm-8 col-form-label font-weight-bold">
                        Navbar Top 3 Pixel Border Line Color:
                    </label>
                    <div class="col-sm-4">
                        <div class="input-group my-colorpicker2 colorpicker-element">
                            <input type="text" name="T_modern_NavbarTBLC" class="form-control" value="#377dce">
                            <div class="input-group-addon">
                                <i style="background-color: rgb(55, 124, 206);"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row form-group mb-2">
                    <label for="T_modern_NavbarLC" class="col-sm-8 col-form-label font-weight-bold">
                        Navbar Link Color:
                    </label>
                    <div class="col-sm-4">
                        <div class="input-group my-colorpicker2 colorpicker-element">
                            <input type="text" name="T_modern_NavbarLC" class="form-control" value="">
                            <div class="input-group-addon">
                                <i style="background-color: rgb(0, 0, 0);"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row form-group mb-2">
                    <label for="T_modern_NavbarLHC" class="col-sm-8 col-form-label font-weight-bold">
                        Navbar Link Hover Color:
                    </label>
                    <div class="col-sm-4">
                        <div class="input-group my-colorpicker2 colorpicker-element">
                            <input type="text" name="T_modern_NavbarLHC" class="form-control" value="">
                            <div class="input-group-addon">
                                <i style="background-color: #000000;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row form-group mb-2">
                    <label for="T_modern_NavbarCBBC" class="col-sm-8 col-form-label font-weight-bold">
                        Navbar Create <u>Button Background</u> Color:&lt;
                    </label>
                    <div class="col-sm-4">
                        <div class="input-group my-colorpicker2 colorpicker-element">
                            <input type="text" name="T_modern_NavbarCBBC" class="form-control" value="">
                            <div class="input-group-addon">
                                <i style="background-color: rgb(0, 0, 0);"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row form-group mb-2">
                    <label for="T_modern_NavbarCBFC" class="col-sm-8 col-form-label font-weight-bold">
                        Navbar Create <u>Button Font</u> Color:
                    </label>
                    <div class="col-sm-4">
                        <div class="input-group my-colorpicker2 colorpicker-element">
                            <input type="text" name="T_modern_NavbarCBFC" class="form-control" value="">
                            <div class="input-group-addon">
                                <i style="background-color: rgb(0, 0, 0);"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row form-group mb-2">
                    <label for="T_modern_NavbarCBFC" class="col-sm-8 col-form-label font-weight-bold">
                        Navbar Create <u>Button Hover Background</u> Color:
                    </label>
                    <div class="col-sm-4">
                        <div class="input-group my-colorpicker2 colorpicker-element">
                            <input type="text" name="T_modern_NavbarCBHBC" class="form-control" value="">
                            <div class="input-group-addon">
                                <i style="background-color: rgb(0, 0, 0);"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row form-group mb-2">
                    <label for="T_modern_NavbarCBHFC" class="col-sm-8 col-form-label font-weight-bold">
                        Navbar Create <u>Button Hover Font</u> Color:
                    </label>
                    <div class="col-sm-4">
                        <div class="input-group my-colorpicker2 colorpicker-element">
                            <input type="text" name="T_modern_NavbarCBHFC" class="form-control" value="">
                            <div class="input-group-addon">
                                <i style="background-color: rgb(0, 0, 0);"></i>
                            </div>
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