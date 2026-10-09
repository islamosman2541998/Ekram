<div>
    <form wire:submit.prevent="checkout">
        <div class="applepay payment-content">
            @include('livewire.site.payments.message')

            {{-- Apple Pay sheet opens on the Moyasar page after this step --}}
            <p class="fast-visa-note">
                <i class="fa fa-lock"></i>
                سيتم تحويلك إلى صفحة الدفع الآمنة لإتمام التبرع عبر Apple Pay.
            </p>

            <div class="cart-form-actions">
                <button type="submit" class="pay-btn" wire:loading.attr="disabled" wire:target="checkout">
                    <i class="fa fa-check"></i> الدفع
                </button>
                <a href="{{ route('site.home') }}" class="cancel-btn"><i class="fa fa-times"></i></a>
            </div>
        </div>
    </form>
</div>
