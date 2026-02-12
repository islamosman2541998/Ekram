@extends('admin.app')

@section('title', trans('products.categories'))
@section('title_page', trans('products.categories'))

@section('style')
    {{-- @vite(['resources/assets/admin/css/data-tables.js']) --}}
    @livewireStyles
@endsection

@section('content')
    <div class="container-fluid">
        @livewire('admin.product.product-category-index')

    </div>
@endsection

@section('script')
    @livewireScripts
@endsection
