@extends('site.app')
@section('title', __('Orders List'))
@section('content')


<main class="ek-profile">
    <div class="ek-profile__wrap">
        <x-site.profile.side-menu />

        <section class="ek-profile__main">
            <div class="ek-pf-card ek-pf-card--content">
                @livewire('site.profile.orders')
            </div>
        </section>
    </div>
</main>

@endsection
