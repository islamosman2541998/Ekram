

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
    Moyasar.init({
        element: '.mysr-form',
        amount: {{ $amount }},
        currency: 'SAR',
        description: '{{ addslashes($description) }}',
        publishable_api_key: '{{ $publishableKey }}',
        callback_url: '{{ url("moyasar-callback") }}?order_id={{ $order->id }}',
        language: 'ar',
        methods: {!! json_encode($methods) !!},
        supported_networks: ['visa', 'mastercard', 'mada'],
        metadata: {
            order_id: '{{ $order->id }}',
            order_identifier: '{{ $order->identifier }}',
        }
    });
</script>
@endpush