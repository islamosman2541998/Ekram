{{-- livewire/site/payments/apple-pay.blade.php --}}
<div>
    <div class="container text-center py-3">
        <h5 class="fs-6 mb-3">@lang('Pay From ApplePay')</h5>
        <button wire:click="checkout" class="btn w-100 btn-success">
            <i class="fa-brands fa-apple"></i> @lang('Pay')
        </button>
    </div>
</div>