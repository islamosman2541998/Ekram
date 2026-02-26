@php
$settings = App\Charity\Settings\SettingSingleton::getInstance();
@endphp

<!-- google tags pixel script -->
@if ($settings->getPixel('show_body_pixel'))
   {!! $settings->getPixel('body_pixel_id') !!}
@endif

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom" dir="ltr">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <div class="custom-hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </button>

        <!-- Logo -->
        <a class="navbar-brand d-lg-none logo-mobile" href="{{ url('/') }}">
            <img src="{{ asset('img/Untitled-1.png') }}" alt="Logo">
        </a>

        <div class="collapse navbar-collapse justify-content-center navmenu" id="navbarNav">
            <ul class="navbar-nav">

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
                @endphp

                @foreach ($items->where('parent_id', $parent_id ?? 0) as $item)
                    @php
                        $totalChildren = $items->where('parent_id', $item->id)->count();
                        $itemTitle = $item->trans?->where('locale', $current_lang)->first()->title ?? '';
                        $itemUrl = $item->type == 'dynamic' ? $item->dynamic_url : $item->url;
                        $isActive =
                            @$item->id == @$menu->id ||
                            @$item_parent_id == $item->id ||
                            in_array($item->id, $menu_parent_ids ?? []);
                    @endphp

                    @if ($totalChildren)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle @if ($isActive) active @endif"
                                href="#" data-bs-toggle="dropdown">
                                {{ $itemTitle }}
                            </a>
                            <ul class="dropdown-menu text-end @if ($isActive) active current @endif"
                                aria-labelledby="navbarDropdown">
                                @include('site.layouts.menuItem', ['parent_id' => $item->id])
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link @if ($isActive) active @endif"
                                href="{{ $itemUrl }}">
                                {{ $itemTitle }}
                            </a>
                        </li>
                    @endif

                    @if (!$loop->last)
                        <li class="nav-divider"></li>
                    @endif
                @endforeach

                <div class="user-cart d-lg-none mt-3">
                        <livewire:site.profile.user-icon />

                         <livewire:site.carts.cart-icon />

                </div>
            </ul>
        </div>

        <div class="user-cart d-none d-lg-flex">
             <livewire:site.profile.user-icon />

            <livewire:site.carts.cart-icon />
        </div>
    </div>
</nav>



  <style>
    .collapse
 {
    visibility: unset;
}
.navbar-nav .nav-link {
   
    font-size: 14px;
}
.ms-3 {
    margin-left: -2rem !important;
}
.fa-cart-shopping , .Badge , .usericon 
{
    color: #2C5F5D !important;
}
.start-100 {
    left: 69% !important;
}
.user-items{
    display: flex;
    align-items: center;
}


.navbar-nav .nav-item.dropdown > .nav-link.dropdown-toggle {
    text-decoration: none !important;
    border-bottom: none !important;
}
.navbar-nav .nav-item.dropdown > .nav-link.dropdown-toggle::after {
    border-bottom: none !important;
}
.navbar-nav .nav-item .nav-link.active::after,
.navbar-nav .nav-item .nav-link:hover::after {
}

.navbar-nav .nav-item.dropdown > .nav-link.dropdown-toggle::after {
    display: inline-block !important;
    border-top: 0.3em solid #2C5F5D;
    border-right: 0.3em solid transparent;
    border-bottom: 0;
    border-left: 0.3em solid transparent;
    vertical-align: middle;
    margin-right: 5px;
    background: none !important;
    content: "" !important;
    width: auto !important;
    height: auto !important;
    position: relative !important;
    bottom: auto !important;
    left: auto !important;
}

.navbar-nav .nav-item:not(.dropdown) > .nav-link:hover::after,
.navbar-nav .nav-item:not(.dropdown) > .nav-link.active::after {
    display: block !important;
    background: #2C5F5D !important;
}

.navbar-nav .dropdown-menu {
    right: auto !important;
    left: 0 !important;
    top: 100%;
}

.dropdown-menu .dropdown-menu {
    top: 0 !important;
    right: 100% !important;
    left: auto !important;
    margin-top: 0;
    margin-right: 0.5rem;
}

[dir="rtl"] .dropdown-menu .dropdown-menu,
.navbar[dir="ltr"] .dropdown-menu .dropdown-menu {
    right: auto !important;
    left: -2.5rem !important;
    margin-left: -2.5rem;
    margin-right: 0;
}

  </style>

