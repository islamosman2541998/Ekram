<div class="ek-user">
    @if ($user == null)
        <a href="{{ route('site.login') }}" class="ek-action ek-action--pill">
            <span class="ek-action__icon"><i class="fa-solid fa-user"></i></span>
            <span class="ek-action__text">@lang('Login')</span>
        </a>
    @else
        <button type="button" class="ek-action ek-action--pill" id="login" data-bs-toggle="dropdown"
            data-bs-display="static" aria-expanded="false">
            <span class="ek-action__icon"><i class="fa-solid fa-user"></i></span>
            <span class="ek-action__text">{{ @explode(' ', @$user->full_name ?? @$user->name)[0] }}</span>
            <i class="fa-solid fa-chevron-down ek-nav__caret"></i>
        </button>
        <ul class="dropdown-menu ek-user__menu" aria-labelledby="login">
            <li>
                <a class="dropdown-item" href="{{ route('site.profile.index') }}">
                    <i class="fa-regular fa-user"></i> @lang('Profile')
                </a>
            </li>
            <li>
                <hr class="dropdown-divider" />
            </li>
            <li>
                <a class="dropdown-item" href="{{ route('site.logout') }}">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> @lang('logout')
                </a>
            </li>
        </ul>
    @endif
</div>
