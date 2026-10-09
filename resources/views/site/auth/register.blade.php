@extends('site.app')

@section('title', __('Register'))

@section('content')
    <main class="ek-auth">
        <div class="ek-auth__wrap">
            @include('site.auth.layout-side', [
                'sideTitle' => 'انضم إلى أسرة العطاء',
                'sideText' => 'أنشئ حسابك في أقل من دقيقة، وكن سببًا في رسم الابتسامة على وجوه كبار السن.',
            ])

            <section class="ek-auth__main">
                <livewire:site.auth.register />
            </section>
        </div>
    </main>

    @include('site.auth.styles')
@endsection
