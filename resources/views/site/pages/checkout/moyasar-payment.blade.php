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

        <div id="mysr-error" role="alert"
            style="display:none; margin-top:16px; padding:12px 14px; border:1px solid #f5c2c7; border-radius:10px; background:#fff5f5; color:#b02a37; font-size:14px; line-height:1.7; text-align:center;">
        </div>

    </div>
@endsection

@push('js')
    <script src="https://cdn.moyasar.com/mpf/1.7.3/moyasar.js"></script>
    <script>
        Moyasar.init({
            element: '.mysr-form',
            amount: {{ (int) $amount }},
            currency: 'SAR',
            description: '{{ addslashes($description) }}',
            publishable_api_key: '{{ $publishableKey }}',
            callback_url: '{{ url('moyasar-callback') }}?order_id={{ $order->id }}',
            language: 'ar',
            methods: {!! json_encode($methods) !!},
            supported_networks: ['visa', 'mastercard', 'mada'],
            metadata: {
                order_id: '{{ $order->id }}',
                order_identifier: '{{ $order->identifier }}',
            },
            // Moyasar only reports failures through this callback; without it the user sees nothing
            on_failure: function (error) {
                function report(text) {
                    var box = document.getElementById('mysr-error');
                    box.innerHTML = 'تعذّر إتمام الدفع، يرجى المحاولة مرة أخرى أو استخدام وسيلة دفع أخرى.' +
                        '<br><small style="color:#888; direction:ltr; display:inline-block; word-break:break-word">' +
                        String(text).replace(/</g, '&lt;') + '</small>';
                    box.style.display = 'block';

                    try {
                        fetch('{{ route('site.moyasar.client-error') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                            },
                            body: JSON.stringify({
                                order_id: '{{ $order->id }}',
                                method: {!! json_encode(implode(',', $methods)) !!},
                                error: String(text),
                                host: location.host
                            })
                        });
                    } catch (e) {}
                }

                // Apple Pay merchant validation failures arrive as a raw fetch Response: read its status + body
                if (error && typeof Response !== 'undefined' && error instanceof Response) {
                    var head = 'HTTP ' + error.status + ' ' + (error.statusText || '') + ' (' + error.url + ')';
                    error.text()
                        .then(function (body) { report(head + ' - ' + body.slice(0, 600)); })
                        .catch(function () { report(head); });
                    return;
                }

                report((error && (error.message || error.toString())) || 'unknown');
            },
            apple_pay: {
                country: 'SA',
                label: 'Ekram',
                validate_merchant_url: 'https://api.moyasar.com/v1/applepay/initiate'
            }
        });
    </script>
@endpush
