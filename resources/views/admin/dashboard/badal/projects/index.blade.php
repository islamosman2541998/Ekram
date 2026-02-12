@extends('admin.app')

@section('title', trans('charityProject.charity_show'))
@section('title_page', trans('charityProject.badal_project'))

@section('title_route', route('admin.badal.projects.index') )
@section('button_page')
    <a href="{{ route('admin.badal.projects.create') }}" class="btn btn-outline-success">@lang('admin.create')</a>
@endsection

@section('style')
    @livewireStyles
@endsection

@section('content')
    @livewire('admin.badal.projects.index')
@endsection

@section('script')
    @livewireScripts
@endsection
