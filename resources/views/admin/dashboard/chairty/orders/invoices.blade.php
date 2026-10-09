@php
    // create_date is never filled on orders: use created_at (it showed "now" before)
    $invoiceDate = $order->created_at ?? now();
    $orgName = env('APP_NAME_AR') ?: 'إكرام المسنين';
@endphp
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>إيصال استلام #{{ $order->identifier }} | جمعية {{ $orgName }}</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    <style>
        @font-face {
            font-family: "brando";
            src: url("{{ asset('site/fonts/din-next-lt-w23-regular.ttf') }}") format("truetype");
            font-weight: 400;
        }

        @font-face {
            font-family: "brando";
            src: url("{{ asset('site/fonts/din-next-lt-w23-medium.ttf') }}") format("truetype");
            font-weight: 700;
        }

        :root {
            --teal: #469e8d;
            --teal-dark: #04525A;
            --orange: #ee5a34;
            --amber: #faa440;
            --sand: #f8d5ae;
            --cream: #FCF4EC;
            --text: #1F2A2A;
            --muted: #66706F;
            --line: #E7E1DA;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 32px 16px;
            background: var(--cream);
            color: var(--text);
            font-family: "brando", "Segoe UI", Tahoma, sans-serif;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .receipt {
            max-width: 820px;
            margin: 0 auto;
            overflow: hidden;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 12px 40px rgba(4, 82, 90, .10);
        }

        /* brand strip: the four identity colours */
        .receipt__strip { display: flex; height: 8px; }
        .receipt__strip span { flex: 1; }
        .receipt__strip span:nth-child(1) { background: var(--teal-dark); }
        .receipt__strip span:nth-child(2) { background: var(--teal); }
        .receipt__strip span:nth-child(3) { background: var(--amber); }
        .receipt__strip span:nth-child(4) { background: var(--orange); }

        .receipt__head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 28px 36px 24px;
            border-bottom: 1px solid var(--line);
        }

        .receipt__logo img { display: block; height: 78px; width: auto; }

        .receipt__title { text-align: left; }
        .receipt__title h1 { margin: 0; color: var(--teal-dark); font-size: 28px; font-weight: 700; }
        .receipt__title p { margin: 4px 0 0; color: var(--muted); font-size: 14px; }

        .receipt__body { padding: 28px 36px; }

        .receipt__meta {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            margin-bottom: 26px;
            border: 1px solid var(--line);
            border-radius: 12px;
        }

        .receipt__meta > div { padding: 14px 18px; }
        .receipt__meta > div + div { border-inline-start: 1px solid var(--line); }
        .receipt__meta dt { color: var(--muted); font-size: 13px; }
        .receipt__meta dd { margin: 4px 0 0; font-size: 16px; font-weight: 700; }

        .receipt__table { width: 100%; border-collapse: collapse; font-size: 15px; }

        .receipt__table th {
            padding: 11px 16px;
            background: var(--teal-dark);
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            text-align: start;
        }

        .receipt__table th:first-child { border-start-start-radius: 10px; }
        .receipt__table th:last-child { border-start-end-radius: 10px; text-align: end; }

        .receipt__table td { padding: 12px 16px; border-bottom: 1px solid var(--line); }
        .receipt__table td:last-child { font-weight: 700; text-align: end; white-space: nowrap; }
        .receipt__table td small { color: var(--muted); font-size: 12px; font-weight: 400; }
        .receipt__table .sub { display: block; margin-top: 2px; color: var(--muted); font-size: 13px; }

        .receipt__total {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 18px;
            padding: 16px 20px;
            border-radius: 12px;
            background: var(--cream);
            border: 1px solid var(--sand);
        }

        .receipt__total span { color: var(--teal-dark); font-size: 16px; font-weight: 700; }
        .receipt__total strong { color: var(--orange); font-size: 26px; }
        .receipt__total strong small { color: var(--muted); font-size: 14px; font-weight: 400; }

        .receipt__thanks {
            margin: 24px 0 0;
            padding-inline-start: 14px;
            border-inline-start: 3px solid var(--amber);
            color: var(--text);
            font-size: 15px;
            line-height: 1.9;
        }

        .receipt__foot {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            padding: 16px 36px;
            background: var(--teal-dark);
            color: rgba(255, 255, 255, .85);
            font-size: 13px;
        }

        .receipt__foot a { color: #fff; font-weight: 700; text-decoration: none; }

        .actions { margin: 22px auto 0; text-align: center; }

        .actions button,
        .actions a {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            height: 44px;
            margin: 0 4px;
            padding: 0 22px;
            border: 1px solid var(--teal-dark);
            border-radius: 10px;
            background: var(--teal-dark);
            color: #fff;
            font: inherit;
            font-size: 15px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
        }

        .actions a { background: #fff; color: var(--teal-dark); }

        @media (max-width: 640px) {
            body { padding: 16px 10px; }
            .receipt__head { flex-direction: column-reverse; align-items: flex-start; padding: 22px 20px 18px; }
            .receipt__title { text-align: start; }
            .receipt__logo img { height: 64px; }
            .receipt__body { padding: 20px; }
            .receipt__meta { grid-template-columns: minmax(0, 1fr); }
            .receipt__meta > div + div { border-inline-start: 0; border-top: 1px solid var(--line); }
            .receipt__table th, .receipt__table td { padding: 10px 12px; }
            .receipt__foot { padding: 14px 20px; }
            .actions button, .actions a { margin: 4px; }
        }

        @media print {
            body { padding: 0; background: #fff; }
            .receipt { max-width: none; border-radius: 0; box-shadow: none; }
            .actions { display: none; }
        }
    </style>
</head>

<body>
    <div class="receipt">
        <div class="receipt__strip"><span></span><span></span><span></span><span></span></div>

        <header class="receipt__head">
            <a href="{{ route('site.home') }}" class="receipt__logo">
                <img src="{{ asset('img/Untitled-1.png') }}" alt="جمعية {{ $orgName }}">
            </a>
            <div class="receipt__title">
                <h1>إيصال استلام تبرع</h1>
                <p>رقم العملية #{{ $order->identifier }}</p>
            </div>
        </header>

        <div class="receipt__body">
            <dl class="receipt__meta">
                <div>
                    <dt>اسم المتبرع</dt>
                    <dd>{{ $order->donor?->full_name ?: 'فاعل خير' }}</dd>
                </div>
                <div>
                    <dt>تاريخ التبرع</dt>
                    <dd><span dir="ltr">{{ $invoiceDate->format('Y/m/d') }}</span></dd>
                </div>
                <div>
                    <dt>وقت التبرع</dt>
                    <dd><span dir="ltr">{{ $invoiceDate->format('h:i A') }}</span></dd>
                </div>
            </dl>

            <table class="receipt__table">
                <thead>
                    <tr>
                        <th>المشروع</th>
                        <th>المبلغ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->details as $detail)
                        <tr>
                            <td>
                                {{ $detail->item_name }}
                                @if ($detail->quantity > 1)
                                    <span class="sub">{{ $detail->quantity }} × {{ number_format($detail->price, 2) }} ريال</span>
                                @endif
                            </td>
                            <td>{{ number_format($detail->total, 2) }} <small>ريال</small></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="receipt__total">
                <span>إجمالي قيمة التبرع</span>
                <strong>{{ number_format($order->total, 2) }} <small>ريال</small></strong>
            </div>

            <p class="receipt__thanks">
                شكرًا لعطائك، تقبّل الله منك وجعله في ميزان حسناتك.
                <br>هذا الإيصال إلكتروني ولا يحتاج إلى ختم أو توقيع.
            </p>
        </div>

        <footer class="receipt__foot">
            <span>&copy; جميع الحقوق محفوظة لجمعية {{ $orgName }}</span>
            <a href="{{ route('site.home') }}">{{ preg_replace('#^https?://#', '', rtrim(config('app.url'), '/')) }}</a>
        </footer>
    </div>

    <div class="actions">
        <button type="button" onclick="window.print()">طباعة الإيصال</button>
        <a href="{{ route('site.home') }}">العودة للموقع</a>
    </div>
</body>

</html>
