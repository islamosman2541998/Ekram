<div>
    <div class="visa payment-content">
        <div class="cart-form-actions">
            <p class="proceed-text">اتمام الدفع</p>
            <button 
                wire:click="checkout"
                wire:loading.attr="disabled"
                class="pay-btn"
                @if(@auth('account')->user()?->types->where('type', 'donor')->first() == null) disabled @endif
            >
                <span wire:loading.remove wire:target="checkout">
                    <i class="fa fa-check"></i> @lang('Pay')
                </span>
                <span wire:loading wire:target="checkout">
                    جاري التحويل...
                </span>
            </button>
            <a href="{{ route('site.home') }}" class="cancel-btn">
                <i class="fa fa-times"></i>
            </a>
        </div>
    </div>
</div>