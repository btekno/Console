@extends('console::today.theme')
@section('inner-title', "Edit $title - ")

@section('inner-css')
@endsection

@section('inner-js')
	@include('components.tinymce', ['height' => 350])
@endsection

@section('inner-content')
	@include('console::layouts.components.breadcrumb', [
        'title' => 'Edit', 
        'kembali' => route("$prefix.index"), 
        'breadcrumbs' => [
            route('console::today.index') => 'Today', 
            '#referensi' => 'Referensi', 
            route("$prefix.index") => $title 
        ]
    ])

    {!! Form::model($edit, ['route' => ["$prefix.update", $edit->id], 'autocomplete' => 'off', 'method' => 'PUT']) !!}
    
        <div class="card card-bordered shadow-none rounded-0">
            @include("$view.form")
        </div>

    {!! Form::close() !!}
@endsection