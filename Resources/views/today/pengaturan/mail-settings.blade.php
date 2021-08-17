@extends('console::today.theme')
@section('inner-title', "Mail Settings - ")

@section('sm-pengaturan-show', 'show')
@section('sm-pengaturan', 'active')
@section('sm-pengaturan-style', 'style=display:block')
@section('sm-mail-settings', 'active')

@section('inner-css')
@endsection

@section('inner-js')
    <script>
        $(function() {
            $('.js-select2-custom').each(function () {
                var select2 = $.HSCore.components.HSSelect2.init($(this), {
                    'minimumResultsForSearch': 'Infinity'
                });
            });
        });

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
		'title' => 'Mail Settings', 
		'breadcrumbs' => [
			route('console::today.index') => 'Today', 
			'#pengaturan' => 'Pengaturan', 
		]
	])

    {!! Form::open(['route' => "$prefix.store", 'autocomplete' => 'off']) !!}
        {!! Form::hidden('page', request('page')) !!}
        
        <div class="card card-bordered shadow-none rounded-0">
            <div class="card-body pb-0" style="height: calc(100vh - 245px);overflow-y: scroll;">

                <div class="row form-group mb-5">
                    <label for="MAIL_DRIVER" class="col-sm-2 col-form-label font-weight-bold">
                        Mail Driver
                    </label>
                    <div class="col-sm-10">
                        {!! Form::select('MAIL_DRIVER', [
                            'smtp' => 'SMTP', 
                            'ses' => 'Ses (Amazon Simple Email Service)', 
                            'mailgun' => 'Mailgun', 
                            'mail' => 'PHP Mail', 
                            'sendmail' => 'SendMail', 
                            'log' => 'Log (Email will be saved to error log)', 
                        ], null, ['class' => 'form-control js-select2-custom', 'data-dependecy' => 'mail_driver_input']) !!}
                    </div>
                </div>

                <div class="row form-group mb-2" data-target="mail_driver_input" data-value="smtp" style="display: none;">
                    <label for="MAIL_HOST" class="col-sm-2 col-form-label font-weight-bold">
                        Mail Host
                    </label>
                    <div class="col-sm-10">
                        {!! Form::text('MAIL_HOST', null, ['class' => 'form-control', 'placeholder' => 'smtp.gmail.com']) !!}
                    </div>
                </div>

                <div class="row form-group mb-2" data-target="mail_driver_input" data-value="smtp" style="display: none;">
                    <label for="MAIL_PORT" class="col-sm-2 col-form-label font-weight-bold">
                        Mail Port
                    </label>
                    <div class="col-sm-10">
                        {!! Form::text('MAIL_PORT', null, ['class' => 'form-control', 'placeholder' => '587']) !!}
                    </div>
                </div>

                <div class="row form-group mb-2" data-target="mail_driver_input" data-value="smtp" style="display: none;">
                    <label for="MAIL_USERNAME" class="col-sm-2 col-form-label font-weight-bold">
                        Mail Username
                    </label>
                    <div class="col-sm-10">
                        {!! Form::text('MAIL_USERNAME', null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="row form-group mb-2" data-target="mail_driver_input" data-value="smtp" style="display: none;">
                    <label for="MAIL_PASSWORD" class="col-sm-2 col-form-label font-weight-bold">
                        Mail Password
                    </label>
                    <div class="col-sm-10">
                        {!! Form::text('MAIL_PASSWORD', null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="row form-group mb-2" data-target="mail_driver_input" data-value="smtp" style="display: none;">
                    <label for="MAIL_ENCRYPTION" class="col-sm-2 col-form-label font-weight-bold">
                        Mail Encryption
                    </label>
                    <div class="col-sm-10">
                        {!! Form::text('MAIL_ENCRYPTION', null, ['class' => 'form-control', 'placeholder' => 'tls']) !!}
                    </div>
                </div>

                <div class="row form-group mb-2" data-target="mail_driver_input" data-value="ses" style="display: none;">
                    <label for="SES_ACCESS_KEY_ID" class="col-sm-2 col-form-label font-weight-bold">
                        SES Access Key ID
                    </label>
                    <div class="col-sm-10">
                        {!! Form::text('SES_ACCESS_KEY_ID', null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="row form-group mb-2" data-target="mail_driver_input" data-value="ses" style="display: none;">
                    <label for="SES_SECRET_ACCESS_KEY" class="col-sm-2 col-form-label font-weight-bold">
                        SES Secret Access Key
                    </label>
                    <div class="col-sm-10">
                        {!! Form::text('SES_SECRET_ACCESS_KEY', null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="row form-group mb-2" data-target="mail_driver_input" data-value="ses" style="display: none;">
                    <label for="SES_DEFAULT_REGION" class="col-sm-2 col-form-label font-weight-bold">
                        SES Default Region
                    </label>
                    <div class="col-sm-10">
                        {!! Form::text('SES_DEFAULT_REGION', null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="row form-group mb-2" data-target="mail_driver_input" data-value="mailgun" style="display: none;">
                    <label for="MAILGUN_DOMAIN" class="col-sm-2 col-form-label font-weight-bold">
                        Mailgun Domain
                    </label>
                    <div class="col-sm-10">
                        {!! Form::text('MAILGUN_DOMAIN', null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="row form-group mb-2" data-target="mail_driver_input" data-value="mailgun" style="display: none;">
                    <label for="MAILGUN_SECRET" class="col-sm-2 col-form-label font-weight-bold">
                        Mailgun Secret
                    </label>
                    <div class="col-sm-10">
                        {!! Form::text('MAILGUN_SECRET', null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="divider mt-4 mb-3">General Settings</div>
                <div class="row form-group mb-2">
                    <label for="MAIL_FROM_NAME" class="col-sm-2 col-form-label font-weight-bold">
                        Mail From Name
                    </label>
                    <div class="col-sm-10">
                        {!! Form::text('MAIL_FROM_NAME', null, ['class' => 'form-control', 'placeholder' => 'Btekno']) !!}
                    </div>
                </div>
                <div class="row form-group mb-5">
                    <label for="MAIL_FROM_ADDRESS" class="col-sm-2 col-form-label font-weight-bold">
                        Mail From Address
                    </label>
                    <div class="col-sm-10">
                        {!! Form::text('MAIL_FROM_ADDRESS', null, ['class' => 'form-control', 'placeholder' => 'mail@btekno.id']) !!}
                    </div>
                </div>

            </div>
            <div class="card-footer p-2 rounded-0 bg-light d-flex justify-content-end">
                <a href="" class="btn btn-secondary mr-2" data-toggle="tooltip" data-original-title="Save your mail settings then send a test mail to current logged user email (demo@admin.com)  and check if any issue occurs">
                    <i class="tio-invisible"></i> Send Test Mail
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="tio-save"></i> Simpan Perubahan
                </button>
            </div>
        </div>

    {!! Form::close() !!}

@endsection