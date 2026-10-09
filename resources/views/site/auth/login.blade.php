@extends('site.app')

@section('title', __('Login'))

@section('content')
    <main class="ek-auth">
        <div class="ek-auth__wrap">
            @include('site.auth.layout-side', [
                'sideTitle' => 'أهلاً بعودتك',
                'sideText' => 'سجّل دخولك برقم جوالك وتابع رحلتك في العطاء مع جمعية إكرام المسنين.',
            ])

            <section class="ek-auth__main">
                <livewire:site.auth.login />
            </section>
        </div>
    </main>

    @include('site.auth.styles')
@endsection
