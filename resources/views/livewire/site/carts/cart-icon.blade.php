<a href="{{ route('site.cart.show') }}" class="ek-action ek-action--icon" aria-label="@lang('Cart')">
    <i class="fa-solid fa-cart-shopping"></i>
    <span class="ek-action__text">@lang('Cart')</span>
    @if ($cartQuantity)
        <span class="ek-action__badge">{{ $cartQuantity }}</span>
    @endif
</a>
