@extends('console::today.theme')
@section('inner-title', "Other Settings - ")

@section('sm-pengaturan-show', 'show')
@section('sm-pengaturan', 'active')
@section('sm-pengaturan-style', 'style=display:block')
@section('sm-other-settings', 'active')

@section('inner-css')
@endsection

@section('inner-js')
@endsection

@section('inner-content')

	@include('console::layouts.components.breadcrumb', [
		'title' => 'Other Settings', 
		'breadcrumbs' => [
			route('console::today.index') => 'Today', 
			'#pengaturan' => 'Pengaturan', 
		]
	])

    {!! Form::open(['route' => "$prefix.store", 'autocomplete' => 'off']) !!}
        {!! Form::hidden('page', request('page')) !!}
        
        <div class="card card-bordered shadow-none rounded-0">
            <div class="card-body pb-0" style="height: calc(100vh - 245px);overflow-y: scroll;">
                
                <div class="row form-group mb-0">
                    <label for="siteposturl" class="col-sm-7 col-form-label py-0">
                        <span class="font-weight-bold">Site Posts Url Type?</span>
                        <span class="help-block d-block small">You can change your post pages url here.</span>
                    </label>
                    <div class="col-sm-5">
                        <select class="form-control" name="siteposturl"><option value="1" selected="selected">yoursite.com/{category}/{slug} (Default)</option><option value="2">yoursite.com/{category}/{id}</option><option value="3">yoursite.com/{username}/{slug}</option><option value="4">yoursite.com/{username}/{id}</option><option value="5">yoursite.com/{category}/{slug}-{id}</option></select>
                    </div>
                </div>
                <hr/>
                <div class="row form-group mb-2">
                    <label for="sitevoting" class="col-sm-8 col-form-label py-0">
                        <span class="font-weight-bold">Enable Guest Voting</span>
                        <span class="help-block d-block small">Users can vote without registration?</span>
                    </label>
                    <div class="col-sm-4">
                        <select class="form-control" name="sitevoting"><option value="0">Yes</option><option value="1">No</option></select>
                    </div>
                </div>
                <div class="row form-group mb-2">
                    <label for="AutoInHomepage" class="col-sm-8 col-form-label py-0">
                        <span class="font-weight-bold">Auto-listed on Homepage</span>
                        <span class="help-block d-block small">If this option is enabled, all new posts show up in homepage. If disabled admins must select posts for homepage.</span>
                    </label>
                    <div class="col-sm-4">
                        <select class="form-control" name="AutoInHomepage"><option value="yes" selected="selected">On</option><option value="no">Off</option></select>
                    </div>
                </div>
                <div class="row form-group mb-2">
                    <label for="AutoApprove" class="col-sm-8 col-form-label py-0">
                        <span class="font-weight-bold">Auto Approve Posts</span>
                        <span class="help-block d-block small">Non-admin posts will be automatically approved if this option is ON.</span>
                    </label>
                    <div class="col-sm-4">
                        <select class="form-control" name="AutoApprove"><option value="yes">On</option><option value="no" selected="selected">Off</option></select>
                    </div>
                </div>
                <div class="row form-group mb-2">
                    <label for="AutoLoadLists" class="col-sm-8 col-form-label py-0">
                        <span class="font-weight-bold">Auto-approve edited posts</span>
                        <span class="help-block d-block small">Edited posts will be automatically approved if this option is ON.</span>
                    </label>
                    <div class="col-sm-4">
                        <select class="form-control" name="AutoEdited"><option value="yes">On</option><option value="no" selected="selected">Off</option></select>
                    </div>
                </div>
                <div class="row form-group mb-2">
                    <label for="AutoLoadLists" class="col-sm-8 col-form-label py-0">
                        <span class="font-weight-bold">Auto-Load on Lists</span>
                        <span class="help-block d-block small">You may want to use Auto-Load on the homepage lists and posts page "You may also like" posts.</span>
                    </label>
                    <div class="col-sm-4">
                        <select class="form-control" name="AutoLoadLists"><option value="yes" selected="selected">Yes</option><option value="no">No - Use load more button</option></select>
                    </div>
                </div>
                
                <hr/>
                
                <div class="row form-group mb-2">
                    <label for="site_default_text_editor" class="col-sm-8 col-form-label py-0">
                        <span class="font-weight-bold">Post Text Editor</span>
                        <span class="help-block d-block small">Here you can choose the text editor we use on the post create page.</span>
                    </label>
                    <div class="col-sm-4">
                        <select class="form-control" data-dependecy="text_editor" name="site_default_text_editor"><option value="tinymce" selected="selected">TinyMCE Text Editor</option><option value="froala">Froala Text Editor</option><option value="simditor">Simditor Text Editor</option></select>
                    </div>
                </div>
                <div class="row form-group mb-2">
                    <label for="showreactioniconon" class="col-sm-8 col-form-label py-0">
                        <span class="font-weight-bold">Reaction Vote Count</span>
                        <span class="help-block d-block small">Assign reaction icon to post if reached this threshold.</span>
                    </label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control input-lg" name="showreactioniconon" value="20">
                    </div>
                </div>

                
                <hr>
                <h3>User Permissions</h3>
                <div class="row form-group mb-2">
                    <label for="UserCanPost" class="col-sm-8 col-form-label py-0 font-weight-bold">
                        <span class="font-weight-bold">User can post on site?</span>
                        <span class="help-block d-block small">Create button only available for admins if it picked as NO</span>
                    </label>
                    <div class="col-sm-4">
                        <select class="form-control" name="UserCanPost"><option value="yes" selected="selected">Yes</option><option value="no">No</option></select>
                    </div>
                </div>
                <div class="row form-group mb-2">
                    <label for="UserDeletePosts" class="col-sm-8 col-form-label py-0 font-weight-bold">
                        <span class="font-weight-bold">Enable Delete</span>
                        <span class="help-block d-block small">Users can delete own posts?</span>
                    </label>
                    <div class="col-sm-4">
                        <select class="form-control" name="UserDeletePosts"><option value="yes" selected="selected">Yes</option><option value="no">No</option></select>
                    </div>
                </div>
                <div class="row form-group mb-2">
                    <label for="UserEditPosts" class="col-sm-8 col-form-label py-0 font-weight-bold">
                        <span class="font-weight-bold">Enable Edit</span>
                        <span class="help-block d-block small">Users can edit own posts?</span>
                    </label>
                    <div class="col-sm-4">
                        <select class="form-control" name="UserEditPosts"><option value="yes" selected="selected">Yes</option><option value="no">No</option></select>
                    </div>
                </div>
                <div class="row form-group mb-2">
                    <label for="UserEditUsername" class="col-sm-8 col-form-label py-0 font-weight-bold">
                        <span class="font-weight-bold">Enable Edit Username</span>
                        <span class="help-block d-block small">Users can edit own usernames?</span>
                    </label>
                    <div class="col-sm-4">
                        <select class="form-control" name="UserEditUsername"><option value="yes" selected="selected">Yes</option><option value="no">No</option></select>
                    </div>
                </div>
                <div class="row form-group mb-2">
                    <label for="UserEditEmail" class="col-sm-8 col-form-label py-0 font-weight-bold">
                        <span class="font-weight-bold">Enable Edit Email</span>
                        <span class="help-block d-block small">Users can edit own emails?</span>
                    </label>
                    <div class="col-sm-4">
                        <select class="form-control" name="UserEditEmail"><option value="yes" selected="selected">Yes</option><option value="no">No</option></select>
                    </div>
                </div>

                <div class="row form-group mb-2">
                    <label for="UserAddSocial" class="col-sm-8 col-form-label py-0 font-weight-bold">
                        <span class="font-weight-bold">Enable Social Media</span>
                        <span class="help-block d-block small">Users can add own social media addresses?</span>
                    </label>
                    <div class="col-sm-4">
                        <select class="form-control" name="UserAddSocial"><option value="yes" selected="selected">Yes</option><option value="no">No</option></select>
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