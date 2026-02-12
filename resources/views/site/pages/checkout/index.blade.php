@extends('site.app')
@section('title', __('Checkout'))
@section('content')


<main>
    <div class="checkout">
        <div class="head">
            <div class="container">
                <div class="Path d-flex justify-content-center justify-content-lg-start">
                    <h3 class="ms-3 fw-bold"><a class="text-main" href="{{ route('site.home') }}"> الرئيسية </a> <span class="px-2"> / </span> </h3>
                    <h3 class="ms-3 fw-bold"><a class="text-primary"> الدفع </a></h3>
                </div>
            </div>
        </div>

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
