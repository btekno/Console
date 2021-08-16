@extends('console::today.theme')
@section('inner-title', "Tambah $title - ")

@section('inner-css')
@endsection

@section('inner-js')
    @include('components.tinymce', ['height' => 350])
@endsection

@section('inner-content')
    @include('console::layouts.components.breadcrumb', [
        'title' => 'Tambah', 
        'kembali' => route("$prefix.index"), 
        'breadcrumbs' => [
            route('console::today.index') => 'Today', 
            '#referensi' => 'Referensi', 
            route("$prefix.index") => $title 
        ]
    ])

    {!! Form::open(['route' => "$prefix.store", 'autocomplete' => 'off']) !!}
    
        <div class="card card-bordered shadow-none rounded-0">
            @include("$view.form")
        </div>

    {!! Form::close() !!}
@endsection