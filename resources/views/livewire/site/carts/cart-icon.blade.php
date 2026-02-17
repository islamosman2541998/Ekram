<div onclick="window.location.href='{{ route('site.cart.show') }}' " class=" p-2 ms-3 position-relative">

<i class="fa-solid fa-cart-shopping mx-3 fs-5"></i>
    @if ($cartQuantity)
    <span class="Badge position-absolute top-0 start-100 translate-middle badge rounded-pill">
        {{ $cartQuantity }}
    </span>
    @endif
</div>

