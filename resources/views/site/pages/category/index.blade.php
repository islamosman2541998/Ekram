@extends('site.app')

@section('content')

    <main class="ek-home">

        @livewire('site.charity-category.index')

    </main>

    @include('site.layouts.ek-card-sliders')


@endsection
