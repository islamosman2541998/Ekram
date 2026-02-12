@extends('admin.app')

@section('title', trans('categories.categories'))
@section('title_page', trans('categories.show_all'))
@section('title_route', route('admin.charity.categories.index') )
@section('button_page')
<a href="{{ route('admin.charity.categories.create') }}" class="btn btn-outline-success btn-sm">@lang('admin.create')</a>
@endsection


@section('style')
    {{-- @vite(['resources/assets/admin/css/data-tables.js']) --}}
    @livewireStyles
@endsection

@section('content')
        @livewire('admin.charity.categories.index')
@endsection

@section('script')    
    @livewireScripts
@endsection



