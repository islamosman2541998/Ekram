@extends('site.app')

@section('title', 'إتمام الدفع')

@push('css')
    <!-- Moyasar Styles -->
    <link rel="stylesheet" href="https://cdn.moyasar.com/mpf/1.7.3/moyasar.css">
    <style>
        .moyasar-payment-wrapper {
            max-width: 500px;
            margin: 40px auto;
            padding: 20px;
        }
        .payment-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .payment-header h4 {
            color: #333;
            margin-bottom: 10px;
        }
        .payment-header .amount {
            font-size: 28px;
            font-weight: bold;
            color: #28a745;
        }
        .payment-header .amount small {
            font-size: 16px;
        }
        .payment-header .order-ref {
            color: #888;
            font-size: 14px;
            margin-top: 5px;
        }
        .mysr-form {
            direction: ltr;
        }
    </style>
@endpush

@section('content')
<div class="container">
    <div class="moyasar-payment-wrapper">
        <div class="payment-header">
            <h4>@lang('Complete Payment')</h4>
            <div class="amount">
                {{ number_format($order->total, 2) }} <small>ر.س</small>
            </div>
            <div class="order-ref">
                @lang('Order') #{{ $order->identifier }}
            </div>
        </div>

        <!-- Moyasar Payment Form -->
        <div class="mysr-form"></div>
    </div>
</div>
@endsection

@push('js')
    <!-- Moyasar Scripts -->
    <script src="https://polyfill.io/v3/polyfill.min.js?features=fetch"></script>
    <script src="https://cdn.moyasar.com/mpf/1.7.3/moyasar.js"></script>
    <script>
        Moyasar.init({
            element: '.mysr-form',
            amount: {{ $amount }},
            currency: 'SAR',
            description: '{{ $description }}',
            publishable_api_key: '{{ $publishableKey }}',
            callback_url: '{{ $callbackUrl }}',
            language: 'ar',

            // طرق الدفع
            methods: ['creditcard', 'applepay', 'stcpay'],

            // الشبكات المدعومة
            supported_networks: ['visa', 'mastercard', 'mada'],

            // إعدادات Apple Pay
            apple_pay: {
                country: 'SA',
                label: '{{ config("app.APP_NAME_AR", "جمعية اكرام الخيرية") }}',
                validate_merchant_url: 'https://api.moyasar.com/v1/applepay/initiate',
            },

            // حفظ معرف الدفع قبل 3DS (مهم)
            on_completed: async function(payment) {
                try {
                    await fetch('{{ route("site.moyasar.save-payment") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            payment_id: payment.id,
                            order_id: '{{ $order->id }}'
                        })
                    });
                } catch (e) {
                    console.error('Failed to save payment ID', e);
                }
            },

            // metadata للبحث في الداشبورد
            metadata: {
                order_id: '{{ $order->id }}',
                order_identifier: '{{ $order->identifier }}',
            }
        });
    </script>
@endpush