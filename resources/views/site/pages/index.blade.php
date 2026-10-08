@extends('site.app')

@section('content')
    @livewire('site.fast-donation.index')

    <main class="ek-home">

        <x-site.home.sliders />

        <x-site.home.category />

        @livewire('site.home.projects')

        @livewire('site.home.requested-projects')

        <x-site.home.statistics />

        <x-site.home.news />

        @include('site.pages.maps')
    </main>

    @include('site.layouts.ek-card-sliders')
@endsection
