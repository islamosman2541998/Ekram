@extends('admin.app')

@section('title', trans('products.products'))
@section('title_page', trans('products.show_products'))

@section('title_route', route('admin.eccommerce.products.index') )
@section('button_page')
<a href="{{ route('admin.eccommerce.products.create') }}" class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">@lang('button.create')</a>
@endsection

@section('style')
    @livewireStyles
@endsection

@section('content')
    <div class="container-fluid">
        @livewire('admin.product.product-table-index')
        <!-- container-fluid -->
    </div>
@endsection


@section('script')
    @livewireScripts
@endsection
