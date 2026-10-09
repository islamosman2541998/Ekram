<div>
    <form wire:submit.prevent="checkout" class="">
        <div class="visa payment-content">
            @include('livewire.site.payments.message')
            <div class="label bank-text">
                <p> @lang('Pay From Visa') </p>
            </div>

            {{-- card details are entered on the secure Moyasar page after this step --}}
            <p class="fast-visa-note">
                <i class="fa fa-lock"></i>
                سيتم تحويلك إلى صفحة الدفع الآمنة لإدخال بيانات البطاقة (مدى، فيزا، ماستركارد).
            </p>

            <div class="cart-form-actions">
                <p class="proceed-text">
                    اتمام الدفع
                </p>
                <button type="submit" class="pay-btn" wire:loading.attr="disabled" wire:target="checkout">
                    <i class="fa fa-check"></i> الدفع
                </button>
                <a href="{{ route('site.home') }}" type="button" class="cancel-btn"><i class="fa fa-times"></i></a>
            </div>
        </div>
    </form>

    <style>
        .fast-visa-note {
            margin: 6px 0 12px;
            padding: 10px 12px;
            border-radius: 10px;
            background: #F3F8F7;
            color: #2C5F5D;
            font-size: 13px;
            font-weight: 600;
            line-height: 1.7;
            text-align: center;
        }

        .fast-visa-note i { margin-inline-end: 4px; }
    </style>
</div>
