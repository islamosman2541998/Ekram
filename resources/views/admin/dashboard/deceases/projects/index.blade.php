@extends('admin.app')

@section('title', trans('decease.decease_projects'))
@section('title_page', trans('decease.decease_projects'))
@section('title_route', route('admin.deceases.projects.index') )
@section('button_page')
{{-- <a href="{{ route('admin.deceases.projects.create') }}" class="btn btn-outline-success">@lang('admin.create')</a> --}}
@endsection

@section('style')
    @livewireStyles
@endsection

@section('content')
    @livewire('admin.deceases.projects.index')
@endsection

@section('script')
    @livewireScripts
@endsection
