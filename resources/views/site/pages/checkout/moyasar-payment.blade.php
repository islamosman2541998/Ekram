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
        // TEMPORARY Apple Pay trace: logs each step of the Apple Pay session (laravel.log, "APPLEPAY-TRACE")
        // so we can see where "Payment Not Completed" happens. Remove once Apple Pay works.
        (function () {
            if (!window.ApplePaySession) return;
            var Orig = window.ApplePaySession;
            var t0 = Date.now();

            function trace(stage, extra) {
                try {
                    fetch('{{ route('site.moyasar.client-error') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                        },
                        body: JSON.stringify({
                            order_id: '{{ $order->id }}',
                            method: 'applepay-trace',
                            error: 'APPLEPAY-TRACE +' + ((Date.now() - t0) / 1000).toFixed(1) + 's ' + stage + (extra ? ' ' + extra : ''),
                            host: location.host
                        })
                    });
                } catch (e) {}
            }

            function Traced(version, request) {
                t0 = Date.now();
                var s = new Orig(version, request);
                trace('session-created', JSON.stringify({
                    version: version,
                    networks: request.supportedNetworks,
                    capabilities: request.merchantCapabilities,
                    countries: request.supportedCountries,
                    amount: request.total && request.total.amount
                }));

                ['onvalidatemerchant', 'onpaymentmethodselected', 'onpaymentauthorized', 'oncancel'].forEach(function (name) {
                    var desc = Object.getOwnPropertyDescriptor(Orig.prototype, name);
                    if (!desc || !desc.set) return;
                    Object.defineProperty(s, name, {
                        configurable: true,
                        get: function () { return desc.get.call(s); },
                        set: function (fn) {
                            desc.set.call(s, function (event) {
                                var extra = '';
                                if (name === 'oncancel' && event && event.sessionError) {
                                    extra = JSON.stringify({ code: event.sessionError.code, info: event.sessionError.info });
                                }
                                if (name === 'onpaymentmethodselected' && event && event.paymentMethod) {
                                    extra = JSON.stringify({ type: event.paymentMethod.type, network: event.paymentMethod.network });
                                }
                                trace(name, extra);
                                return fn.apply(this, arguments);
                            });
                        }
                    });
                });

                ['completeMerchantValidation', 'completePayment', 'abort'].forEach(function (name) {
                    var orig = s[name];
                    s[name] = function (arg) {
                        trace(name, name === 'completePayment' ? JSON.stringify(arg) : '');
                        return orig.apply(s, arguments);
                    };
                });

                return s;
            }

            Traced.prototype = Orig.prototype;
            ['canMakePayments', 'canMakePaymentsWithActiveCard', 'supportsVersion', 'openPaymentSetup'].forEach(function (k) {
                if (typeof Orig[k] === 'function') Traced[k] = function () { return Orig[k].apply(Orig, arguments); };
            });
            ['STATUS_SUCCESS', 'STATUS_FAILURE'].forEach(function (k) { Traced[k] = Orig[k]; });

            window.ApplePaySession = Traced;
        })();
    </script>
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
                // card-issuing countries accepted by Apple Pay (Moyasar's default is SA only)
                supported_countries: ['SA', 'EG', 'AE', 'KW', 'QA', 'BH', 'OM', 'JO'],
                label: 'Ekram',
                validate_merchant_url: 'https://api.moyasar.com/v1/applepay/initiate'
            }
        });
    </script>
@endpush
