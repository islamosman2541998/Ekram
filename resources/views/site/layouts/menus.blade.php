@php
$settings = App\Charity\Settings\SettingSingleton::getInstance();
@endphp

<!-- google tags pixel script -->
@if ($settings->getPixel('show_body_pixel'))
   {!! $settings->getPixel('body_pixel_id') !!}
@endif

@php
    $current_lang = app()->getLocale();
    $items = Cache::get('menus');
    if ($items == null) {
        $items = Cache::rememberForever('menus', function () {
            return App\Models\Menue::with('trans')
                ->orderBy('sort', 'ASC')
                ->main()
                ->active()
                ->get();
        });
    }

    // Highlight the menu link that matches the current URL (and all its parents)
    $ekNormalizePath = function ($url) {
        $url = trim((string) $url);
        if ($url === '' || $url === '#' || preg_match('/^(javascript:|mailto:|tel:)/i', $url)) {
            return null;
        }
        $parts = parse_url($url);
        if ($parts === false) {
            return null;
        }
        if (!empty($parts['host'])) {
            $host = preg_replace('/^www\./i', '', strtolower($parts['host']));
            $currentHost = preg_replace('/^www\./i', '', strtolower(request()->getHost()));
            if ($host !== $currentHost) {
                return null;
            }
        }
        $segments = array_values(array_filter(explode('/', urldecode($parts['path'] ?? ''))));
        if (isset($segments[0]) && in_array($segments[0], ['ar', 'en'])) {
            array_shift($segments);
        }
        return implode('/', $segments);
    };

    $ekCurrentPath = $ekNormalizePath(request()->path());
    $ekActiveIds = [];
    $ekBestLength = -1;

    foreach ($items as $ekItem) {
        $ekPath = $ekNormalizePath($ekItem->type == 'dynamic' ? $ekItem->dynamic_url : $ekItem->url);
        if ($ekPath === null) {
            continue;
        }
        $ekMatches = $ekPath === ''
            ? $ekCurrentPath === ''
            : $ekCurrentPath === $ekPath || str_starts_with($ekCurrentPath . '/', $ekPath . '/');
        if ($ekMatches && strlen($ekPath) >= $ekBestLength) {
            if (strlen($ekPath) > $ekBestLength) {
                $ekActiveIds = [];
                $ekBestLength = strlen($ekPath);
            }
            $ekActiveIds[] = $ekItem->id;
        }
    }

    foreach ($ekActiveIds as $ekId) {
        $ekParent = $items->firstWhere('id', $ekId)?->parent_id;
        while ($ekParent && !in_array($ekParent, $ekActiveIds)) {
            $ekActiveIds[] = $ekParent;
            $ekParent = $items->firstWhere('id', $ekParent)?->parent_id;
        }
    }
@endphp

<!-- Navbar -->
<nav class="ek-nav" id="ekNav" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">
    <div class="ek-nav__inner">

        <!-- Logo -->
        <a class="ek-nav__brand" href="{{ url('/') }}">
            <img src="{{ asset('img/Untitled-1.png') }}" alt="{{ $settings->getItem('site_name') }}">
        </a>

        <!-- Mobile toggle -->
        <button class="ek-nav__toggle" type="button" aria-controls="ekNavPanel" aria-expanded="false"
            aria-label="@lang('Menu')">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <div class="ek-nav__overlay" data-ek-close></div>

        <div class="ek-nav__panel" id="ekNavPanel">

            <!-- Drawer head (mobile only) -->
            <div class="ek-nav__panel-head">
                <a class="ek-nav__brand" href="{{ url('/') }}">
                    <img src="{{ asset('img/Untitled-1.png') }}" alt="{{ $settings->getItem('site_name') }}">
                </a>
                <button class="ek-nav__close" type="button" data-ek-close aria-label="@lang('Close')">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Links -->
            <ul class="ek-nav__menu">
                @foreach ($items->where('parent_id', $parent_id ?? 0) as $item)
                    @php
                        $totalChildren = $items->where('parent_id', $item->id)->count();
                        $itemTitle = $item->trans?->where('locale', $current_lang)->first()->title ?? '';
                        $itemUrl = $item->type == 'dynamic' ? $item->dynamic_url : $item->url;
                        $isActive =
                            @$item->id == @$menu->id ||
                            @$item_parent_id == $item->id ||
                            in_array($item->id, $menu_parent_ids ?? []) ||
                            in_array($item->id, $ekActiveIds);
                    @endphp

                    @if ($totalChildren)
                        <li class="ek-nav__item has-sub">
                            <button type="button" class="ek-nav__link ek-nav__sub-toggle @if ($isActive) is-active @endif"
                                aria-expanded="false">
                                <span>{{ $itemTitle }}</span>
                                <i class="fa-solid fa-chevron-down ek-nav__caret"></i>
                            </button>
                            <div class="ek-nav__sub">
                                <ul class="ek-nav__sub-list">
                                    @include('site.layouts.menuItem', ['parent_id' => $item->id])
                                </ul>
                            </div>
                        </li>
                    @else
                        <li class="ek-nav__item">
                            <a class="ek-nav__link @if ($isActive) is-active @endif" href="{{ $itemUrl }}">
                                <span>{{ $itemTitle }}</span>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>

            <!-- User & cart -->
            <div class="ek-nav__actions">
                <livewire:site.profile.user-icon />
                <livewire:site.carts.cart-icon />
            </div>
        </div>
    </div>
</nav>
<div class="ek-nav-spacer" aria-hidden="true"></div>

<style>
    /* Legacy global rules kept from the old navbar (other pages may rely on them) */
    .collapse { visibility: unset; }
    .ms-3 { margin-left: -2rem !important; }
    .fa-cart-shopping, .Badge, .usericon { color: #2C5F5D !important; }
    .start-100 { left: 69% !important; }

    /* ========== Navbar ========== */
    .ek-nav {
        --ek-primary: #2C5F5D;
        --ek-primary-dark: #1F4645;
        --ek-accent: #E8873A;
        --ek-soft: #F1F6F5;
        --ek-border: #E3ECEB;
        --ek-text: #24403F;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1030;
        background: #fff;
        border-bottom: 1px solid var(--ek-border);
        box-shadow: 0 4px 18px rgba(31, 70, 69, .06);
        font-family: inherit;
        transition: box-shadow .25s ease;
    }

    .ek-nav.is-scrolled { box-shadow: 0 8px 26px rgba(31, 70, 69, .14); }

    /* keeps page content below the fixed navbar (height synced by JS) */
    :root { --ek-nav-h: 81px; scroll-padding-top: var(--ek-nav-h); }
    .ek-nav-spacer { height: var(--ek-nav-h); }

    @media (max-width: 1199.98px) {
        :root { --ek-nav-h: 65px; }
    }

    .ek-nav *,
    .ek-nav *::before,
    .ek-nav *::after { box-sizing: border-box; }

    :where(.ek-nav) ul { list-style: none; margin: 0; padding: 0; }
    :where(.ek-nav) a { text-decoration: none; }
    :where(.ek-nav) button { font-family: inherit; }

    .ek-nav__inner {
        display: flex;
        align-items: center;
        gap: 24px;
        max-width: 1880px;
        margin: 0 auto;
        padding: 10px clamp(16px, 3vw, 40px);
    }

    .ek-nav__brand { flex: none; display: inline-flex; align-items: center; }
    .ek-nav__brand img { height: 60px; width: auto; display: block; transition: transform .25s ease; }
    .ek-nav__brand:hover img { transform: scale(1.04); }

    /* ---- Links ---- */
    .ek-nav__link {
        position: relative;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 9px 11px;
        border: 0;
        border-radius: 10px;
        background: transparent;
        color: var(--ek-text);
        font-size: 15px !important;
        font-weight: 500 !important;
        line-height: 1.4;
        white-space: nowrap;
        cursor: pointer;
        transition: color .2s ease, background-color .2s ease;
    }

    .ek-nav__link:hover,
    .ek-nav__link:focus-visible,
    .ek-nav__item.is-open > .ek-nav__link {
        color: var(--ek-primary);
        background: var(--ek-soft);
    }

    .ek-nav__link.is-active { color: var(--ek-primary); font-weight: 700 !important; }

    .ek-nav__caret { font-size: 10px; transition: transform .25s ease; }
    .ek-nav__item.is-open > .ek-nav__link .ek-nav__caret { transform: rotate(180deg); }

    /* ---- Sub menus ---- */
    .ek-nav__sub-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        width: 100%;
        padding: 10px 14px;
        border: 0;
        border-radius: 8px;
        background: transparent;
        color: var(--ek-text);
        font-size: 14px !important;
        font-weight: 500 !important;
        text-align: start;
        white-space: nowrap;
        cursor: pointer;
        transition: color .2s ease, background-color .2s ease, padding .2s ease;
    }

    .ek-nav__sub-link:hover,
    .ek-nav__sub-link:focus-visible,
    .ek-nav__sub-item.is-open > .ek-nav__sub-link {
        color: var(--ek-primary);
        background: var(--ek-soft);
    }

    .ek-nav__sub-link.is-active { color: var(--ek-primary); font-weight: 700 !important; }

    /* ---- Actions (user & cart) ---- */
    .ek-nav__actions { display: flex; align-items: center; gap: 10px; flex: none; }

    .ek-action {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        height: 44px;
        border: 1px solid var(--ek-border);
        border-radius: 999px;
        background: var(--ek-soft);
        color: var(--ek-primary);
        font-size: 14px;
        font-weight: 600;
        white-space: nowrap;
        cursor: pointer;
        transition: background-color .2s ease, color .2s ease, border-color .2s ease, box-shadow .2s ease;
    }

    .ek-action:hover,
    .ek-action:focus-visible,
    .ek-action[aria-expanded="true"] {
        background: var(--ek-primary);
        border-color: var(--ek-primary);
        color: #fff;
        box-shadow: 0 6px 14px rgba(44, 95, 93, .22);
    }

    .ek-action--icon { width: 44px; padding: 0; }
    .ek-action--pill { padding-inline: 6px 16px; }

    .ek-action__icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #fff;
        color: var(--ek-primary);
        font-size: 14px;
    }

    .ek-action i { font-size: 17px; }
    .ek-nav .ek-action .fa-cart-shopping { color: inherit !important; }
    .ek-action__icon i { font-size: 14px; }
    .ek-action--icon .ek-action__text { display: none; }
    .ek-action .ek-nav__caret { font-size: 10px; }

    .ek-action__badge {
        position: absolute;
        top: -5px;
        inset-inline-end: -5px;
        min-width: 20px;
        height: 20px;
        padding: 0 5px;
        border: 2px solid #fff;
        border-radius: 999px;
        background: var(--ek-accent);
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        line-height: 16px;
        text-align: center;
    }

    .ek-user { position: relative; }

    .ek-nav .ek-user__menu {
        min-width: 200px;
        margin-top: 8px !important;
        padding: 8px;
        border: 1px solid var(--ek-border);
        border-radius: 12px;
        box-shadow: 0 14px 34px rgba(31, 70, 69, .14);
        transform: none !important;
        text-align: start;
    }

    .ek-nav .ek-user__menu[data-bs-popper] { top: 100%; left: auto; right: auto; inset-inline-end: 0; }

    .ek-nav .ek-user__menu .dropdown-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 11px;
        border-radius: 8px;
        color: var(--ek-text) !important;
        font-size: 14px;
    }

    .ek-nav .ek-user__menu .dropdown-item:hover { background: var(--ek-soft); color: var(--ek-primary) !important; }
    .ek-nav .ek-user__menu .dropdown-item i { width: 16px; color: var(--ek-primary); }

    .ek-nav__toggle,
    .ek-nav__overlay,
    .ek-nav__panel-head { display: none; }

    /* ========== Desktop ========== */
    @media (min-width: 1200px) {
        .ek-nav__panel {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 24px;
            min-width: 0;
        }

        .ek-nav__menu {
            flex: 1;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: 4px 2px;
        }

        .ek-nav__item { position: relative; }

        /* active indicator */
        .ek-nav__link::after {
            content: "";
            position: absolute;
            bottom: 2px;
            left: 50%;
            width: 0;
            height: 3px;
            border-radius: 3px;
            background: var(--ek-accent);
            transform: translateX(-50%);
            transition: width .25s ease;
        }

        .ek-nav__link.is-active::after { width: 22px; }

        /* dropdown panel */
        .ek-nav__sub {
            position: absolute;
            top: calc(100% + 8px);
            inset-inline-start: 0;
            z-index: 20;
            min-width: 230px;
            padding: 8px;
            border: 1px solid var(--ek-border);
            border-radius: 14px;
            background: #fff;
            box-shadow: 0 18px 40px rgba(31, 70, 69, .14);
            opacity: 0;
            visibility: hidden;
            transform: translateY(8px);
            transition: opacity .2s ease, transform .2s ease, visibility .2s;
        }

        /* hover bridge so the menu doesn't close in the gap */
        .ek-nav__sub::before {
            content: "";
            position: absolute;
            inset-inline: 0;
            top: -10px;
            height: 10px;
        }

        .ek-nav__item.has-sub:hover > .ek-nav__sub,
        .ek-nav__item.has-sub:focus-within > .ek-nav__sub,
        .ek-nav__item.is-open > .ek-nav__sub,
        .ek-nav__sub-item.has-sub:hover > .ek-nav__sub,
        .ek-nav__sub-item.has-sub:focus-within > .ek-nav__sub,
        .ek-nav__sub-item.is-open > .ek-nav__sub {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .ek-nav__item.has-sub:hover > .ek-nav__link .ek-nav__caret { transform: rotate(180deg); }

        .ek-nav__sub-list { display: flex; flex-direction: column; gap: 2px; }
        .ek-nav__sub-item { position: relative; }
        .ek-nav__sub-link:hover { padding-inline-start: 18px; }

        /* nested fly-out */
        .ek-nav__sub .ek-nav__sub {
            top: -9px;
            inset-inline-start: calc(100% + 8px);
        }

        .ek-nav__sub .ek-nav__sub::before {
            top: 0;
            bottom: 0;
            height: auto;
            inset-inline-start: -10px;
            inset-inline-end: auto;
            width: 10px;
        }

        .ek-nav__sub-item .ek-nav__caret { transform: rotate(90deg); }
        .ek-nav[dir="ltr"] .ek-nav__sub-item .ek-nav__caret { transform: rotate(-90deg); }
    }

    /* ========== Mobile / tablet ========== */
    @media (max-width: 1199.98px) {
        .ek-nav__inner { gap: 12px; padding-block: 8px; }
        .ek-nav__brand img { height: 48px; }

        .ek-nav__toggle {
            display: inline-flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 5px;
            width: 46px;
            height: 46px;
            margin-inline-start: auto;
            border: 1px solid var(--ek-border);
            border-radius: 12px;
            background: var(--ek-soft);
            cursor: pointer;
        }

        .ek-nav__toggle span {
            display: block;
            width: 22px;
            height: 2px;
            border-radius: 2px;
            background: var(--ek-primary);
            transition: transform .3s ease, opacity .3s ease;
        }

        .ek-nav.is-open .ek-nav__toggle span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
        .ek-nav.is-open .ek-nav__toggle span:nth-child(2) { opacity: 0; }
        .ek-nav.is-open .ek-nav__toggle span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

        .ek-nav__overlay {
            display: block;
            position: fixed;
            inset: 0;
            z-index: 1;
            background: rgba(20, 40, 39, .45);
            opacity: 0;
            visibility: hidden;
            transition: opacity .3s ease, visibility .3s;
        }

        .ek-nav.is-open .ek-nav__overlay { opacity: 1; visibility: visible; }

        .ek-nav__panel {
            --ek-hide: 100%;
            position: fixed;
            top: 0;
            bottom: 0;
            inset-inline-end: 0;
            z-index: 2;
            display: flex;
            flex-direction: column;
            width: min(86vw, 360px);
            background: #fff;
            box-shadow: 0 0 40px rgba(20, 40, 39, .2);
            transform: translateX(var(--ek-hide));
            visibility: hidden;
            transition: transform .35s cubic-bezier(.4, 0, .2, 1), visibility .35s;
        }

        .ek-nav[dir="rtl"] .ek-nav__panel { --ek-hide: -100%; }

        .ek-nav.is-open .ek-nav__panel { transform: translateX(0); visibility: visible; }

        .ek-nav__panel-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 12px 16px;
            border-bottom: 1px solid var(--ek-border);
        }

        .ek-nav__panel-head .ek-nav__brand img { height: 46px; }

        .ek-nav__close {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border: 0;
            border-radius: 10px;
            background: var(--ek-soft);
            color: var(--ek-primary);
            font-size: 18px;
            cursor: pointer;
        }

        .ek-nav__menu {
            flex: 1;
            overflow-y: auto;
            overscroll-behavior: contain;
            padding: 10px 12px;
        }

        .ek-nav__item { border-bottom: 1px solid var(--ek-border); }
        .ek-nav__item:last-child { border-bottom: 0; }

        .ek-nav__link {
            display: flex;
            justify-content: space-between;
            width: 100%;
            padding: 14px 12px;
            font-size: 16px !important;
            text-align: start;
        }

        .ek-nav__link.is-active {
            background: var(--ek-soft);
            box-shadow: inset -3px 0 0 var(--ek-accent);
        }

        .ek-nav[dir="ltr"] .ek-nav__link.is-active { box-shadow: inset 3px 0 0 var(--ek-accent); }

        /* accordion */
        .ek-nav__sub {
            display: grid;
            grid-template-rows: 0fr;
            transition: grid-template-rows .3s ease;
        }

        .ek-nav__item.is-open > .ek-nav__sub,
        .ek-nav__sub-item.is-open > .ek-nav__sub { grid-template-rows: 1fr; }

        .ek-nav__sub-list {
            min-height: 0;
            overflow: hidden;
            margin-inline-start: 14px;
            border-inline-start: 2px solid var(--ek-border);
        }

        .ek-nav__item.is-open > .ek-nav__sub > .ek-nav__sub-list { margin-bottom: 8px; }

        .ek-nav__sub-link { padding: 11px 14px; font-size: 15px !important; white-space: normal; }
        .ek-nav__sub-item.is-open > .ek-nav__sub-link .ek-nav__caret { transform: rotate(180deg); }

        /* actions at drawer bottom */
        .ek-nav__actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            padding: 14px 16px calc(14px + env(safe-area-inset-bottom));
            border-top: 1px solid var(--ek-border);
            background: #FAFCFC;
        }

        .ek-nav__actions > * { min-width: 0; }

        .ek-action,
        .ek-action--icon { width: 100%; height: 48px; border-radius: 12px; padding-inline: 12px; }
        .ek-action--icon .ek-action__text { display: inline; }
        .ek-action__badge { position: static; border: 0; margin-inline-start: 2px; }
        .ek-action__text { overflow: hidden; text-overflow: ellipsis; }

        .ek-nav .ek-user__menu[data-bs-popper] {
            top: auto;
            bottom: calc(100% + 8px);
            inset-inline-start: 0;
            inset-inline-end: auto;
        }
    }

    html.ek-nav-lock,
    html.ek-nav-lock body { overflow: hidden; }

    @media (prefers-reduced-motion: reduce) {
        .ek-nav *,
        .ek-nav *::before,
        .ek-nav *::after { transition: none !important; }
    }
</style>

<script>
    (function () {
        var nav = document.getElementById('ekNav');
        if (!nav || nav.dataset.ready) return;
        nav.dataset.ready = '1';

        var toggle = nav.querySelector('.ek-nav__toggle');
        var desktop = window.matchMedia('(min-width: 1200px)');
        var root = document.documentElement;

        function syncHeight() {
            root.style.setProperty('--ek-nav-h', nav.offsetHeight + 'px');
        }

        syncHeight();
        if (window.ResizeObserver) new ResizeObserver(syncHeight).observe(nav);
        else window.addEventListener('resize', syncHeight);
        window.addEventListener('load', syncHeight);

        function onScroll() {
            nav.classList.toggle('is-scrolled', window.scrollY > 10);
        }

        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });

        function setOpen(open) {
            nav.classList.toggle('is-open', open);
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            document.documentElement.classList.toggle('ek-nav-lock', open);
        }

        function closeSubs(scope, except) {
            scope.querySelectorAll('.is-open').forEach(function (li) {
                if (li === except || li.contains(except)) return;
                li.classList.remove('is-open');
                var btn = li.querySelector(':scope > .ek-nav__sub-toggle');
                if (btn) btn.setAttribute('aria-expanded', 'false');
            });
        }

        toggle.addEventListener('click', function () {
            setOpen(!nav.classList.contains('is-open'));
        });

        nav.querySelectorAll('[data-ek-close]').forEach(function (el) {
            el.addEventListener('click', function () { setOpen(false); });
        });

        nav.querySelectorAll('.ek-nav__sub-toggle').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                var li = btn.parentElement;
                var willOpen = !li.classList.contains('is-open');
                closeSubs(li.parentElement, li);
                li.classList.toggle('is-open', willOpen);
                btn.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
            });
        });

        document.addEventListener('click', function (e) {
            if (desktop.matches && !e.target.closest('.ek-nav__menu')) closeSubs(nav.querySelector('.ek-nav__menu'));
        });

        document.addEventListener('keydown', function (e) {
            if (e.key !== 'Escape') return;
            setOpen(false);
            closeSubs(nav.querySelector('.ek-nav__menu'));
        });

        function onBreakpoint() {
            setOpen(false);
            closeSubs(nav.querySelector('.ek-nav__menu'));
        }

        if (desktop.addEventListener) desktop.addEventListener('change', onBreakpoint);
        else desktop.addListener(onBreakpoint);
    })();
</script>
