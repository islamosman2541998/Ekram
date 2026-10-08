@extends('site.app')
@section('title', __('Checkout'))
@section('content')


<main>
    <div class="checkout">
        @php $ekIsDonor = @auth('account')->user()?->types->where('type', 'donor')->first() != null; @endphp
        <div class="ek-co-hero">
            <div class="ek-co-hero__inner">
                <nav class="ek-co-breadcrumb" aria-label="breadcrumb">
                    <a href="{{ route('site.home') }}">الرئيسية</a>
                    <i class="fa-solid fa-chevron-left"></i>
                    <a href="{{ route('site.cart.show') }}">السلة</a>
                    <i class="fa-solid fa-chevron-left"></i>
                    <span>الدفع</span>
                </nav>
                <h1 class="ek-co-hero__title">إتمام التبرع</h1>

                <ol class="ek-co-steps">
                    <li class="is-done"><span><i class="fa-solid fa-check"></i></span> السلة</li>
                    <li class="{{ $ekIsDonor ? 'is-done' : 'is-current' }}">
                        <span>@if ($ekIsDonor)<i class="fa-solid fa-check"></i>@else 2 @endif</span> بيانات المتبرع
                    </li>
                    <li class="{{ $ekIsDonor ? 'is-current' : '' }}"><span>3</span> الدفع</li>
                </ol>
            </div>
        </div>

        <style>
            .ek-co-hero { padding: 36px 16px 28px; }
            .ek-co-hero__inner { max-width: 1200px; margin: 0 auto; padding: 0 16px; text-align: start; }

            .ek-co-breadcrumb {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                gap: 8px;
                margin-bottom: 8px;
                color: #6B7C7A;
                font-size: 14px;
            }

            .ek-co-breadcrumb a { color: #6B7C7A; text-decoration: none; }
            .ek-co-breadcrumb a:hover { color: #2C5F5D; }
            .ek-co-breadcrumb i { font-size: 10px; opacity: .6; }
            .ek-co-breadcrumb span { color: #2C5F5D; font-weight: 600; }

            .ek-co-hero__title {
                margin: 0 0 20px;
                color: #1F3B3A;
                font-size: clamp(26px, 3vw, 34px);
                font-weight: 800;
            }

            .ek-co-steps {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                gap: 8px;
                margin: 0;
                padding: 0;
                list-style: none;
            }

            .ek-co-steps li {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 6px 14px 6px 6px;
                border-radius: 999px;
                background: #fff;
                border: 1px solid #E3ECEB;
                color: #6B7C7A;
                font-size: 14px;
                font-weight: 600;
            }

            .ek-co-steps li span {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 26px;
                height: 26px;
                border-radius: 50%;
                background: #F3F8F7;
                color: #6B7C7A;
                font-size: 12px;
                font-weight: 700;
            }

            .ek-co-steps li.is-done span { background: #469e8d; color: #fff; }
            .ek-co-steps li.is-done { color: #2C5F5D; }

            .ek-co-steps li.is-current {
                border-color: #2C5F5D;
                color: #2C5F5D;
                box-shadow: 0 6px 16px rgba(44, 95, 93, .12);
            }

            .ek-co-steps li.is-current span { background: #2C5F5D; color: #fff; }

            @media (max-width: 575.98px) {
                .ek-co-hero { padding: 24px 12px 18px; }
                .ek-co-hero__inner { padding: 0 12px; }
                .ek-co-hero__title { margin-bottom: 14px; }
                .ek-co-steps { gap: 6px; }
                .ek-co-steps li { padding: 4px 10px 4px 4px; font-size: 12.5px; gap: 6px; }
                .ek-co-steps li span { width: 22px; height: 22px; font-size: 11px; }
            }
        </style>

        <livewire:site.checkout.show />

    </div>
</main>

@php
    $ga4Items = $cartDatabase->getItems()->map(function ($item) {
        return [
            'item_id' => $item->id ?? 'unknown_id',
            'item_name' => $item->item_name ?? 'Unknown Project',
            'price' => (float) ($item->price ?? 0),
            'quantity' => (int) ($item->quantity ?? 1),
        ];
    })->toArray();
@endphp

<script>
    dataLayer.push({
      event: 'begin_checkout',
      ecommerce: {
        value: {{ $cartDatabase->getItemsWithInfo()['total'] }},
        currency: 'SAR',
        items: @json($ga4Items)
      }
    });
</script>

@endsection
