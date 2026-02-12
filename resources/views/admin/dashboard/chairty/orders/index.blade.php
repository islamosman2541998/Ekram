@extends('admin.app')

@section('title', trans('orders.orders_show'))
@section('title_page', trans('orders.orders'))
@section('title_route', route('admin.orders.index') )
@section('button_page')@endsection

@section('style')
    @livewireStyles
@endsection
@section('content')
   @livewire('admin.charity.orders.index')
@endsection

@section('script')
    @livewireScripts
@endsection
