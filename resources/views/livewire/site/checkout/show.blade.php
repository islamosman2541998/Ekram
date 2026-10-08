<div class="container ek-checkout">
    @php
        $total = 0;
        $isDonor = @auth('account')->user()?->types->where('type', 'donor')->first() != null;
    @endphp

    <div class="ek-co-grid">

        <!-- Order summary -->
        <aside class="ek-co-summary">
            <div class="ek-co-card">
                <div class="ek-co-card__head">
                    <span class="ek-co-card__icon"><i class="fa-solid fa-basket-shopping"></i></span>
                    <h2 class="ek-co-card__title">ملخص تبرعاتك</h2>
                    <span class="ek-co-badge">{{ count($items) }}</span>
                </div>

                <ul class="ek-co-items">
                    @forelse ($items as $itemCart)
                        @php $total += ($itemCart['price'] * $itemCart['quantity']); @endphp
                        <li class="ek-co-item">
                            <img src="{{ getImage($itemCart->item->cover_image) }}" alt="project" class="ek-co-item__img">

                            <div class="ek-co-item__info">
                                <span class="ek-co-item__title">
                                    {{ @$itemCart->item_name }}
                                    @if (@$itemCart->item_sub_type)
                                        ({{ @$itemCart->item_sub_type }})
                                    @endif
                                </span>
                                <span class="ek-co-item__meta">
                                    العدد: <b>{{ $itemCart['quantity'] }}</b>
                                    <span class="ek-co-dot"></span>
                                    {{ $itemCart['price'] }} ريال للوحدة
                                    @if (json_decode(@$itemCart->gift_details)?->giver_mobile)
                                        <i class="fa-solid fa-gift ek-co-item__gift" title="إهداء"></i>
                                    @endif
                                </span>
                            </div>

                            <div class="ek-co-item__price">
                                {{ $itemCart['price'] * $itemCart['quantity'] }}
                                <small>ريال</small>
                            </div>
                        </li>
                    @empty
                        <li class="ek-co-empty">@lang('Empty Cart')</li>
                    @endforelse
                </ul>

                <div class="ek-co-total">
                    <span class="ek-co-total__label">الإجمالي المطلوب</span>
                    <span class="ek-co-total__value">{{ $total }} <small>ريال</small></span>
                </div>
            </div>
        </aside>

        <!-- Donor + payment -->
        <section class="ek-co-main">
            @if (!$isDonor)
                <div class="ek-co-card">
                    <div class="ek-co-card__head">
                        <span class="ek-co-card__icon"><i class="fa-solid fa-user"></i></span>
                        <h2 class="ek-co-card__title">بيانات المتبرع</h2>
                    </div>
                    @livewire('site.auth.index', ['type' => 'checkout'])
                </div>
            @endif

            <div class="ek-co-card">
                <div class="ek-co-card__head">
                    <span class="ek-co-card__icon"><i class="fa-solid fa-credit-card"></i></span>
                    <h2 class="ek-co-card__title">وسيلة الدفع</h2>
                </div>
                <div class="cart-main mb-0">
                    <div class="cart-form">
                        @livewire('site.payments.index')
                    </div>
                </div>
            </div>

            <p class="ek-co-secure">
                <i class="fa-solid fa-shield-halved"></i>
                عملية الدفع آمنة ومشفّرة بالكامل
            </p>
        </section>
    </div>

    @include('livewire.site.checkout.styles')
</div>
