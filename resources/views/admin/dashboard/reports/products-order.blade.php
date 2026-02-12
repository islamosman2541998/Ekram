@extends('admin.app')

@section('title', trans('reports.product_reports'))

@section('title', trans('reports.product_reports'))
@section('title_page', trans('reports.reports'))
@section('title_route', route('admin.reports.order-products') )
@section('button_page')@endsection

@section('style')
    @livewireStyles
@endsection

@section('content')
    @livewire('admin.reports.prodcuts-order-report')
@endsection

@section('script')
    @livewireScripts
@endsection