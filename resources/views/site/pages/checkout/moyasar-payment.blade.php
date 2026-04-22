

@extends('site.payment-layout')

@section('title', 'إتمام الدفع')

@section('content')
<div class="container" style="max-width:600px; margin:40px auto; padding:20px;">
    
    <div style="text-align:center; margin-bottom:30px;">
        <h4>إتمام الدفع</h4>
        <div style="font-size:28px; font-weight:bold; color:#28a745;">
            {{ number_format($order->total, 2) }} <small>ر.س</small>
        </div>
        <div style="color:#888; font-size:14px;">
            طلب رقم #{{ $order->identifier }}
        </div>
    </div>

    <!-- Moyasar Payment Form -->
    <div class="mysr-form"></div>

</div>
@endsection

@push('js')
<script src="https://cdn.moyasar.com/mpf/1.7.3/moyasar.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof Moyasar === 'undefined') {
        console.error('Moyasar SDK not loaded');
        return;
    }

    Moyasar.init({
        element: '.mysr-form',
        amount: {{ (int) $amount }},
        currency: 'SAR',
        description: '{{ addslashes($description) }}',
        publishable_api_key: '{{ $publishableKey }}',
        callback_url: '{{ $callbackUrl }}?order_id={{ $order->id }}',
        language: 'ar',
        methods: {!! json_encode($methods) !!},
        supported_networks: ['visa', 'mastercard', 'mada'],
        metadata: {
            order_id: '{{ $order->id }}',
            order_identifier: '{{ $order->identifier }}',
        },
        apple_pay: {
            country: 'SA',
            label: 'جمعية إكرام المسنين',
            validate_merchant_url: 'https://api.moyasar.com/v1/applepay/initiate'
        },
        on_failure: async function (error) {
            console.log('Moyasar error:', error);
        }
    });
});
</script>
@endpush