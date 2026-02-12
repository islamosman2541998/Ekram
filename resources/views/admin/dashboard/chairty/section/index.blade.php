@extends('admin.app')

@section('title', trans('sections.sections'))
@section('title_page', trans('sections.show_all'))
@section('title_route', route('admin.charity.sections.index') )
@section('button_page')
<a href="{{ route('admin.charity.sections.create') }}" class="btn btn-outline-success btn-sm">@lang('admin.create')</a>
@endsection


@section('style')
    @livewireStyles
@endsection

@section('content')
        @livewire('admin.charity.sections.index')
@endsection

@section('script')    
    @livewireScripts
@endsection



