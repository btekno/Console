@extends('console::today.theme')
@section('inner-title', "General Settings - ")

@section('sm-pengaturan-show', 'show')
@section('sm-pengaturan', 'active')
@section('sm-pengaturan-style', 'style=display:block')
@section('sm-general-settings', 'active')

@section('inner-css')
@endsection

@section('inner-js')
    <script>
        function check_dependecies(mailer){
            $('.form-group[data-target]').each(function(i, el){
                var target = $(el).data('target'),
                target_value = $(el).data('value'),
                val = $('[data-dependecy="'+target+'"]').val();

                if(target_value == val){
                    $(el).show();
                }else{
                    $(el).hide();
                }
            });
        }

        check_dependecies();

        $('[data-dependecy]').on('change', function(){
            check_dependecies();
        })
    </script>
@endsection

@section('inner-content')

	@include('console::layouts.components.breadcrumb', [
		'title' => 'General Settings', 
		'breadcrumbs' => [
			route('console::today.index') => 'Today', 
			'#pengaturan' => 'Pengaturan', 
		]
	])

    {!! Form::open(['route' => "$prefix.store", 'autocomplete' => 'off']) !!}
        {!! Form::hidden('page', request('page')) !!}
        
        <div class="card card-bordered shadow-none rounded-0">
            <div class="card-body pb-0 mb-5" style="height: calc(100vh - 245px);overflow-y: scroll;">

                <div class="row form-group mb-2">
                    <label for="sitedefaultlanguage" class="col-sm-4 col-form-label font-weight-bold">
                        Site Default Language
                    </label>
                    <div class="col-sm-8">
                        <select class="form-control" name="sitedefaultlanguage"><option value="en" selected="selected">English (en)</option><option value="ar">Arabic (ar)</option><option value="nl">Dutch (nl)</option><option value="it">Italian (it)</option><option value="ru">Russian (ru)</option><option value="es">Spanish (es)</option><option value="tr">Turkish (tr)</option></select>
                    </div>
                </div>

                <div class="row form-group mb-2">
                    <label for="APP_TIMEZONE" class="col-sm-4 col-form-label font-weight-bold">
                        Site Timezone
                    </label>
                    <div class="col-sm-8">
                        <?php
                            $tzlist = \DateTimeZone::listIdentifiers(\DateTimeZone::ALL);
                            $timezones = [];
                            foreach($tzlist as $lang):
                                    $timezones[$lang] = $lang;
                            endforeach;
                        ?>
                        {!! Form::select('APP_TIMEZONE', $timezones, env('APP_TIMEZONE', 'UTC'), ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="row form-group mb-2">
                    <label for="sitename" class="col-sm-4 col-form-label font-weight-bold">
                        Site Name
                    </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control input-lg" name="sitename" value="" required="required">
                    </div>
                </div>

                <div class="row form-group mb-2">
                    <label for="APP_URL" class="col-sm-4 col-form-label font-weight-bold">
                        Site URL
                    </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control input-lg" name="APP_URL" value="https://today.btekno.id" required="required" readonly="">
                    </div>
                </div>

                <hr/>
                <div class="row form-group mb-2">
                    <label for="sitelogo" class="col-sm-4 col-form-label font-weight-bold">
                        <span class="font-weight-bold">Site Logo</span>
                        <span class="help-block d-block small">Upload a site logo here. (Only PNG)</span>
                    </label>
                    <div class="col-sm-8">
                        <img class="field-image-preview img-thumbnail" width="150" src="https://buzzy.akbilisim.com/assets/images/logo.png">
                        <input type="file" id="sitelogo" name="sitelogo" class="form-control mt-2">
                    </div>
                </div>

                <div class="row form-group mb-2">
                    <label for="footerlogo" class="col-sm-4 col-form-label font-weight-bold">
                        <span class="font-weight-bold">Footer Site Logo</span>
                        <span class="help-block d-block small">Upload a site logo here. (Only PNG)</span>
                    </label>
                    <div class="col-sm-8">
                        <img class="field-image-preview img-thumbnail" width="150" src="https://buzzy.akbilisim.com/assets/images/flogo.png">
                        <input type="file" id="footerlogo" name="footerlogo" class="form-control mt-2">
                    </div>
                </div>

                <div class="row form-group mb-2">
                    <label for="favicon" class="col-sm-4 col-form-label font-weight-bold">
                        <span class="font-weight-bold">Site Favicon</span>
                        <span class="help-block d-block small">Upload a favicon here. (Only PNG)</span>
                    </label>
                    <div class="col-sm-8">
                        <img class="field-image-preview img-thumbnail " width="40" src="https://buzzy.akbilisim.com/assets/images/favicon.png">
                        <input type="file" id="favicon" name="favicon" class="form-control mt-2">
                    </div>
                </div>

                <hr/>

                <div class="row form-group mb-2">
                    <label for="sitetitle" class="col-sm-4 col-form-label font-weight-bold">
                        Site Default Meta Title
                    </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="sitetitle" value="Buzzy Demo" required="required">
                    </div>
                </div>
                <div class="row form-group mb-2">
                    <label for="sitemetadesc" class="col-sm-4 col-form-label font-weight-bold">
                        Site Default Meta Description
                    </label>
                    <div class="col-sm-8">
                        {!! Form::textarea('SITE_META_DESC', null, ['class' => 'form-control', 'rows' => 3]) !!}
                    </div>
                </div>
                <div class="row form-group mb-2">
                    <label for="sitemetadesc" class="col-sm-4 col-form-label font-weight-bold">
                        <span class="font-weight-bold">Terms of Use Page Url</span>
                        <span class="help-block d-block small">For register forms.</span>
                    </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control input-lg" name="termspage" value="https://buzzy.akbilisim.com/pages/terms-of-use">
                    </div>
                </div>
                <div class="row form-group mb-2">
                    <label for="siteemail" class="col-sm-4 col-form-label font-weight-bold">
                        Site Email
                    </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control input-lg" name="siteemail" value="contact@akbilisim.com">
                    </div>
                </div>
                <div class="row form-group mb-2">
                    <label for="siteemail" class="col-sm-4 col-form-label font-weight-bold py-0">
                        <span class="font-weight-bold">Site Language &amp; Country Codes</span>
                        <span class="help-block d-block small">
                            For example: en_US, en_EN, de_DE, tr_TR. <br/>
                            For more info please checkout <a href="https://www.w3schools.com/tags/ref_language_codes.asp" target="_blank">Language Codes</a>, <a target="_blank" href="https://www.w3schools.com/tags/ref_country_codes.asp">Country Codes</a>.
                        </span>
                    </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control input-lg" name="sitelanguage" placeholder="en_US" value="en_US">
                    </div>
                </div>

                <hr/>

                <div class="row form-group mb-2">
                    <label for="siteemail" class="col-sm-4 col-form-label font-weight-bold py-0">
                        <span class="font-weight-bold">Site Active?</span>
                        <span class="help-block d-block small">(Maintenance Mode)</span>
                    </label>
                    <div class="col-sm-8">
                        <select data-dependecy="site_active" class="form-control" name="Siteactive"><option value="yes" selected="selected">Yes</option><option value="no">No</option></select>
                    </div>
                </div>
                <div class="row form-group mb-2" data-target="site_active" data-value="no" style="display: none;">
                    <label for="Siteactivenote" class="col-sm-4 col-form-label font-weight-bold">
                        Maintenance Mode Note
                    </label>
                    <div class="col-sm-8">
                        {!! Form::textarea('Siteactivenote', null, ['class' => 'form-control', 'rows' => 3]) !!}
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