@php
    $menuDonor = auth('account')->user()?->donor;
    $menuName = $menuDonor?->full_name ?? '';
@endphp

<aside class="ek-profile__side">
    <div class="ek-pf-card ek-pf-side">
        <div class="ek-pf-strip"><span></span><span></span><span></span><span></span></div>

        <div class="ek-pf-user">
            <a href="{{ route('site.home') }}" class="ek-pf-user__logo">
                <img src="{{ asset('img/Untitled-1.png') }}" alt="{{ env('APP_NAME') }}">
            </a>
            <div class="ek-pf-user__name">{{ $menuName }}</div>
            @if ($menuDonor?->account?->mobile)
                <div class="ek-pf-user__meta"><span dir="ltr">+{{ ltrim($menuDonor->account->mobile, '+') }}</span></div>
            @endif
        </div>

        <nav class="ek-pf-nav">
            <a href="{{ route('site.profile.index') }}"
                class="ek-pf-nav__item {{ Route::is('site.profile.index') ? 'active' : '' }}" id="personal-info-tab">
                <i class="fa-regular fa-user"></i> حسابك الشخصي
            </a>
            <a href="{{ route('site.profile.orders') }}"
                class="ek-pf-nav__item {{ Route::is('site.profile.orders') ? 'active' : '' }}" id="orders-tab">
                <i class="fa-regular fa-file-lines"></i> سجل الطلبات
            </a>
            <a href="{{ route('site.profile.edit') }}"
                class="ek-pf-nav__item {{ Route::is('site.profile.edit') ? 'active' : '' }}">
                <i class="fa-regular fa-pen-to-square"></i> تعديل البيانات
            </a>
        </nav>

        <div class="ek-pf-side__foot">
            <a href="{{ route('site.logout') }}" class="ek-pf-side__logout">
                <i class="fa-solid fa-arrow-right-from-bracket"></i> @lang('logout')
            </a>
            <a href="#" class="ek-pf-side__action ek-pf-side__action--danger" id="delete-account-tab"
                data-bs-toggle="modal" data-bs-target="#closeAccountModal">حذف الحساب</a>
        </div>
    </div>
</aside>

{{-- outside the sticky sidebar, otherwise the Bootstrap backdrop covers it --}}
<div class="modal fade ek-pf-modal" id="closeAccountModal" tabindex="-1" aria-labelledby="closeAccountModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <h5 class="modal-title" id="closeAccountModalLabel">@lang('Delete Account')</h5>
                <p>@lang('Are you Sure You Want To Close Your Account ?')</p>
            </div>
            <div class="modal-footer">
                <form action="{{ route('site.profile.close') }}" method="POST">
                    @csrf
                    <button type="button" class="ek-pf-btn ek-pf-btn--ghost" data-bs-dismiss="modal">@lang('No')</button>
                    <button type="submit" class="ek-pf-btn ek-pf-btn--danger">@lang('Yes')</button>
                </form>
            </div>
        </div>
    </div>
</div>


@include('site.profile.styles')
