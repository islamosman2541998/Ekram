@extends('admin.app')

@section('title', trans('substitutes.substitutes'))
@section('title_page', trans('substitutes.show_substitutes'))
@section('title_route', route('admin.badal.substitutes.index') )
@section('button_page')
<a href="{{ route('admin.badal.substitutes.create') }}" class="btn btn-outline-success btn-sm">@lang('admin.create')</a>
@endsection


@section('button_page')
    <a href="{{ route('admin.badal.projects.create') }}" class="btn btn-outline-success">@lang('admin.create')</a>
@endsection

@section('style')
    @livewireStyles
@endsection

@section('content')
    @livewire('admin.badal.substitutes.index')
@endsection

@section('script')
    @livewireScripts
@endsection



