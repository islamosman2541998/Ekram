@php
$settings = App\Charity\Settings\SettingSingleton::getInstance();
@endphp

<header>

    <style>
        .topBar {
            .logoBox {
                height: 213px;
            }
        }
    </style>
    <div class="topBar">
        <img class="back" src="{{ site_path('img/nav-banner.png') }}" alt="">
        <div class="UserBox ">
            <div onclick="window.location.href='/'" class="logoBox p-4 d-none d-lg-block">
                <img src="{{ asset(getImage($settings->getItem('logo')) ?? site_path('img/logo.png')) }}" class="img-fluid logo-img" alt="" />
            </div>

            <div class="Name d-none d-lg-block">
                @php
                    $welcomeMessage = $settings->getItem('welcome_message_' . app()->getLocale());
                @endphp
                {{ $welcomeMessage ?? 'مرحبا بكم في جمعية يدا بيد' }}
            </div>


            <div class="useraction mx-auto mx-lg-0">
                <div onclick="window.location.href='/'" class="logoBoxModile  d-lg-none text-center">
                    <img src="{{ asset(getImage($settings->getItem('logo_mobile')) ?? site_path('img/logo.png')) }}" class="img-fluid" alt="" />
                </div>

                <div class="loginbox ">
                    <div class="user ">
                        {{-- <livewire:site.profile.user-icon /> --}}
                    </div>

                    <div class="nav-left">
                        <div class="user-mobile ">

                            {{-- <livewire:site.profile.user-icon /> --}}

                        </div>

                        {{-- <div class="nav-icon">
                            <button class="navbar-toggler custom-hamburger" type="button">
                                <span class="hamburger-bar"></span>
                                <span class="hamburger-bar"></span>
                                <span class="hamburger-bar"></span>
                            </button>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

</header>
