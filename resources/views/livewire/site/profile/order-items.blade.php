<div wire:keydown.escape="keyUp()" class="ek-od">
    <button type="button" class="ek-od__open" wire:click="toggleModal()" wire:loading.attr="disabled" wire:target="toggleModal">
        <span wire:loading.remove wire:target="toggleModal">@lang('Show')</span>
        <span wire:loading wire:target="toggleModal">...</span>
    </button>

    @if ($show_details && $order)
        @php
            $Orderdetails = $order->details->groupBy('item_type');
            $statusMap = [
                '0' => ['Pending', 'wait'],
                '1' => ['Confirmed', 'ok'],
                '3' => ['Waiting', 'info'],
                '4' => ['Canceled', 'bad'],
            ];
            $st = $statusMap[(string) $order->status] ?? null;
        @endphp

        <div class="ek-od__overlay" wire:click.self="toggleModal()">
            <div class="ek-od__dialog" role="dialog" aria-modal="true" aria-labelledby="ek-od-title-{{ $order_id }}">

                <div class="ek-od__head">
                    <div>
                        <div class="ek-od__eyebrow">تفاصيل الطلب</div>
                        <h3 class="ek-od__title" id="ek-od-title-{{ $order_id }}">#{{ $order->identifier }}</h3>
                    </div>
                    <div class="ek-od__head-end">
                        @if ($st)
                            <span class="ek-od__status ek-od__status--{{ $st[1] }}">@lang($st[0])</span>
                        @endif
                        <button type="button" class="ek-od__close" wire:click="toggleModal()" aria-label="@lang('Close')">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </div>

                <div class="ek-od__body">
                    <dl class="ek-od__summary">
                        <div>
                            <dt>@lang('orders.total')</dt>
                            <dd>{{ number_format($order->total, 2) }} <small>ر.س</small></dd>
                        </div>
                        <div>
                            <dt>@lang('orders.payment_methods')</dt>
                            <dd>{{ $order->paymentMethod?->trans_ar->title ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt>@lang('admin.created_at')</dt>
                            <dd><span dir="ltr">{{ date('Y/m/d - H:i', strtotime($order->created_at)) }}</span></dd>
                        </div>
                        <div>
                            <dt>@lang('orders.source')</dt>
                            <dd>{{ trans($order->source) }}</dd>
                        </div>
                    </dl>

                    @if ($order->payment_method_id == 3 && $order->banktransferproof)
                        <a href="{{ getImage($order->banktransferproof) }}" target="_blank" class="ek-od__link">
                            <i class="fa-solid fa-paperclip"></i> عرض إيصال التحويل
                        </a>
                    @endif

                    @if (@isset($Orderdetails['App\Models\Product']))
                        <div class="ek-od__row-note">
                            @lang('admin.shippingStatus'): <strong>{{ $order->shipping_status ?? '—' }}</strong>
                        </div>
                    @endif

                    {{-- Projects --}}
                    @if (@$Orderdetails['App\Models\CharityProject'])
                        <h4 class="ek-od__section">@lang('refer.detailsProjects')</h4>

                        <div class="ek-od__items">
                            @foreach ($Orderdetails['App\Models\CharityProject'] as $details)
                                @php
                                    $giftCard = $details->gift_details != null ? json_decode($details->gift_details) : null;
                                    $slug = @$details->item?->trans->where('locale', $current_lang)->first()->slug;
                                @endphp
                                <div class="ek-od__item">
                                    <div class="ek-od__item-main">
                                        <div class="ek-od__item-name">
                                            @if ($slug)
                                                <a href="{{ route('site.charity-project.show', $slug) }}" target="_blank">{{ $details->item_name }}</a>
                                            @else
                                                {{ $details->item_name }}
                                            @endif
                                        </div>
                                        <div class="ek-od__item-meta">
                                            @if ($details->item_sub_type)
                                                {{ $details->item_sub_type == 'Gift Product' ? trans('Gift Product') : $details->item_sub_type }} ·
                                            @endif
                                            {{ $details->quantity }} × {{ number_format($details->price, 2) }} ر.س
                                        </div>
                                    </div>
                                    <div class="ek-od__item-total">{{ number_format($details->total, 2) }} <small>ر.س</small></div>

                                    @if (@$giftCard->giver_name)
                                        <button type="button" class="ek-od__gift-toggle" wire:click="showGiftCart({{ $details->id }})">
                                            إهداء إلى {{ $giftCard->giver_name }}
                                            <i class="fa-solid fa-chevron-{{ @$showGift[$details->id] == 1 ? 'up' : 'down' }}"></i>
                                        </button>

                                        @if (@$showGift[$details->id] == 1)
                                            <div class="ek-od__gift">
                                                @if (@$giftCard->image)
                                                    <a href="{{ getImageThumb($giftCard->image) }}" target="_blank" class="ek-od__gift-img">
                                                        <img src="{{ getImageThumb($giftCard->image) }}" alt="">
                                                    </a>
                                                @endif
                                                <dl>
                                                    <div><dt>@lang('settings.giver_name')</dt><dd>{{ @$giftCard->giver_name }}</dd></div>
                                                    <div><dt>@lang('settings.giver_mobile')</dt><dd dir="ltr">{{ @$giftCard->giver_mobile ?: '—' }}</dd></div>
                                                    @if (@$giftCard->giver_email)
                                                        <div><dt>@lang('settings.giver_email')</dt><dd>{{ $giftCard->giver_email }}</dd></div>
                                                    @endif
                                                    <div><dt>@lang('settings.gift_type')</dt><dd>{{ @$giftCard->cardTitle ?: '—' }}</dd></div>
                                                </dl>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Products --}}
                    @if (@isset($Orderdetails['App\Models\Product']))
                        <h4 class="ek-od__section">@lang('refer.detailsProducts')</h4>

                        <div class="ek-od__items">
                            @foreach ($Orderdetails['App\Models\Product'] as $details)
                                <div class="ek-od__item">
                                    <div class="ek-od__item-main">
                                        <div class="ek-od__item-name">
                                            <a href="{{ route('site.charity-product.show', @$details->item->id) }}" target="_blank">{{ $details->item_name }}</a>
                                        </div>
                                        <div class="ek-od__item-meta">
                                            {{ $details->quantity }} × {{ number_format($details->price, 2) }} ر.س
                                            @if (@$details->giver->name)
                                                · إهداء إلى {{ $details->giver->name }} ({{ $details->giver->mobile }})
                                            @endif
                                        </div>
                                    </div>
                                    <div class="ek-od__item-total">{{ number_format($details->total, 2) }} <small>ر.س</small></div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="ek-od__foot">
                    @if ($order->status == 1)
                        <a href="{{ route('site.invoices', @$order->id) }}" target="_blank" class="ek-od__btn ek-od__btn--primary">
                            <i class="fa-regular fa-file-lines"></i> @lang('admin.invoices')
                        </a>
                    @endif
                    <button type="button" class="ek-od__btn" wire:click="toggleModal()">@lang('Close')</button>
                </div>
            </div>
        </div>
    @endif
</div>
