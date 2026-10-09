{{-- Brand side panel shared by the login and register pages --}}
<aside class="ek-auth__side">
    <a href="{{ route('site.home') }}" class="ek-auth__logo">
        <img src="{{ asset('img/Untitled-1.png') }}" alt="{{ env('APP_NAME') }}">
    </a>

    <h2 class="ek-auth__side-title">{{ $sideTitle }}</h2>
    <p class="ek-auth__side-text">{{ $sideText }}</p>

    <ul class="ek-auth__perks">
        <li><span><i class="fa-solid fa-shield-halved"></i></span> تبرّع بسهولة وأمان تام</li>
        <li><span><i class="fa-solid fa-clock-rotate-left"></i></span> تابع تبرعاتك وإيصالاتك في مكان واحد</li>
        <li><span><i class="fa-solid fa-gift"></i></span> أهدِ تبرعك لمن تحب وشاركهم الأجر</li>
    </ul>
</aside>
