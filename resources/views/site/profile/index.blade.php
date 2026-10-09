@extends('site.app')
@section('title', __('Profile'))

@section('content')
    @php
        $recentOrders = $orders->sortByDesc('id')->take(5);
        $lastOrder = $orders->sortByDesc('id')->first();
        $statusMap = ['0' => ['Pending', 'wait'], '1' => ['Confirmed', 'ok'], '3' => ['Waiting', 'info'], '4' => ['Canceled', 'bad']];
    @endphp

    <main class="ek-profile">
        <div class="ek-profile__wrap">
            <x-site.profile.side-menu />

            <section class="ek-profile__main">

                <header class="ek-pf-pagehead">
                    <div>
                        <h1 class="ek-pf-pagehead__title">حسابي</h1>
                        <p class="ek-pf-pagehead__sub">مرحبًا {{ $donor->full_name }}، هنا تجد ملخص تبرعاتك وبيانات حسابك.</p>
                    </div>
                    <a href="{{ route('site.projectCategories.index') }}" class="ek-pf-btn ek-pf-btn--primary">تبرّع الآن</a>
                </header>

                <!-- Summary -->
                <div class="ek-pf-card ek-pf-summary">
                    <div class="ek-pf-summary__item">
                        <span class="ek-pf-summary__label">@lang('Total Amount')</span>
                        <span class="ek-pf-summary__value">{{ number_format($orders->sum('total')) }} <small>ر.س</small></span>
                    </div>
                    <div class="ek-pf-summary__item">
                        <span class="ek-pf-summary__label">@lang('Number of donates')</span>
                        <span class="ek-pf-summary__value">{{ $orders->count() }}</span>
                    </div>
                    <div class="ek-pf-summary__item">
                        <span class="ek-pf-summary__label">آخر تبرع</span>
                        <span class="ek-pf-summary__value ek-pf-summary__value--sm">
                            <span dir="ltr">{{ $lastOrder ? \Carbon\Carbon::parse($lastOrder->created_at)->format('Y/m/d') : '—' }}</span>
                        </span>
                    </div>
                </div>

                <!-- Recent donations -->
                <div class="ek-pf-card">
                    <div class="ek-pf-card__head">
                        <h2 class="ek-pf-card__title">آخر تبرعاتي</h2>
                        @if ($orders->count())
                            <a href="{{ route('site.profile.orders') }}" class="ek-pf-link">سجل الطلبات كاملًا</a>
                        @endif
                    </div>

                    @if ($recentOrders->count())
                        <div class="ek-pf-table-wrap">
                            <table class="ek-pf-table">
                                <thead>
                                    <tr>
                                        <th>رقم الطلب</th>
                                        <th>التاريخ</th>
                                        <th>وسيلة الدفع</th>
                                        <th>المبلغ</th>
                                        <th>الحالة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentOrders as $order)
                                        @php $st = $statusMap[(string) $order->status] ?? null; @endphp
                                        <tr>
                                            <td class="ek-pf-table__strong">#{{ $order->identifier }}</td>
                                            <td><span dir="ltr">{{ \Carbon\Carbon::parse($order->created_at)->format('Y/m/d') }}</span></td>
                                            <td>{{ $order->payment_method_ar ?: '—' }}</td>
                                            <td class="ek-pf-table__strong">{{ number_format($order->total) }} <small>ر.س</small></td>
                                            <td>
                                                @if ($st)
                                                    <span class="ek-od__status ek-od__status--{{ $st[1] }}">@lang($st[0])</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="ek-pf-empty">
                            <p>لا توجد تبرعات حتى الآن.</p>
                            <a href="{{ route('site.projectCategories.index') }}" class="ek-pf-btn ek-pf-btn--primary">ابدأ أول تبرع</a>
                        </div>
                    @endif
                </div>

                <!-- Personal info -->
                <div class="ek-pf-card">
                    <div class="ek-pf-card__head">
                        <h2 class="ek-pf-card__title">@lang('personal account information')</h2>
                        <a href="{{ route('site.profile.edit') }}" class="ek-pf-btn ek-pf-btn--outline">@lang('Edit')</a>
                    </div>

                    <dl class="ek-pf-info">
                        <div>
                            <dt>@lang('Name')</dt>
                            <dd>{{ $donor->full_name }}</dd>
                        </div>
                        <div>
                            <dt>@lang('Mobile')</dt>
                            <dd><span dir="ltr">{{ $donor->account->mobile }}</span></dd>
                        </div>
                        <div>
                            <dt>@lang('Email')</dt>
                            <dd>{{ $donor->account->email ?: '—' }}</dd>
                        </div>
                    </dl>
                </div>
            </section>
        </div>
    </main>
@endsection
