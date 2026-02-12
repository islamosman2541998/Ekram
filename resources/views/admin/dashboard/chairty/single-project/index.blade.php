@extends('admin.app')

@section('title', trans('charityProject.charity_show'))
@section('title_page', trans('charityProject.single_project'))

@section('title_route', route('admin.charity.single-projects.index') )
@section('button_page')
    <a href="{{ route('admin.charity.single-projects.create') }}" class="btn btn-outline-success">@lang('admin.create')</a>
@endsection

@section('style')
    @livewireStyles
@endsection

@section('content')
    @livewire('admin.charity.single-projects.index')
@endsection

@section('script')
    @livewireScripts
@endsection
