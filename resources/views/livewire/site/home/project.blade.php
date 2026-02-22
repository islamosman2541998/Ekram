<div>
    <div class="CardBox custom-card">
        <div class="custom-card-header d-flex align-items-center justify-content-between custom-card-header-bg">
            <span class="custom-card-title">{{ @$project['title'] ?? $project->transNow?->title }}</span>
            <i class="fa-solid fa-share-nodes custom-card-icon"></i>
        </div>
        <div onclick="window.location.href='{{ route('site.charity-project.show', @$project['slug'] ?? $project->transNow?->slug) }}'" class="custom-card-img custom-card-img-bg image-container">
            @if( @$progressBar['avarge'] == "100" || @$project->finished == 1)
                <span class="closed">مغلق</span>
                <div class="complete-icon">✔</div>
            @endif
            <img src="{{ asset(getImage($project['cover_image']) ?? 'site/img/project3.png') }}" alt="project" class="custom-card-img-el">
        </div>
        <div class="custom-card-body custom-card-body-bg">
            <div class="money-collected">
                <div class="d-flex justify-content-between mb-2 custom-card-amount-row">
                    <span>تم جمع: <br>{{ number_format($progressBar['collected']) }} ر.س</span>
                    <span>المبلغ المتبقي: <br>{{ number_format(max(0, $progressBar['target_price'] - $progressBar['collected'])) }} ر.س</span>
                </div>
                <div class="progress mb-2 custom-card-progress">
                    <div class="progress-bar custom-card-progress-bar" role="progressbar"
                         style="width: {{ $progressBar['avarge'] }}%"
                         aria-valuenow="{{ $progressBar['avarge'] }}" aria-valuemin="0" aria-valuemax="100">
                        %{{ $progressBar['avarge'] }}
                    </div>
                </div>
            </div>

            {{-- Donation Types --}}
            @if (is_array($donation))
                @switch($donation['type'])

                    @case('unit')
                        @if (!empty($donation['data']) && is_array($donation['data']))
                            <div class="d-flex align-items-center justify-content-between mb-3 custom-card-btn-row">
                                @foreach ($donation['data'] as $key => $data)
                                    <label title="{{ $data['name'] ?? '' }}"
                                           class="amount-btn {{ $unitValueRadio == json_encode($data) ? 'active' : '' }}"
                                           style="background-color: {{ $colors[$key % count($colors)] }}">
                                        <input wire:model.live="unitValueRadio" type="radio" value="{{ json_encode($data) }}" style="display: none;">
                                        {{ $data['value'] ?? '' }}
                                    </label>
                                @endforeach
                                <input class="form-control custom-card-input" type="number" wire:model.live="unitValueInput" min="0" placeholder="مبلغ آخر">
                            </div>
                        @endif
                    @break

                    @case('share')
                        @if (!empty($donation['data']) && is_array($donation['data']))
                            <div class="d-flex align-items-center justify-content-between mb-3 custom-card-btn-row">
                                @foreach ($donation['data'] as $key => $data)
                                    <label title="{{ $data['name'] ?? '' }}"
                                           class="amount-btn {{ $shareValue == json_encode($data) ? 'active' : '' }}"
                                           style="background-color: {{ $colors[$key % count($colors)] }}">
                                        <input wire:model.live="shareValue" type="radio" value="{{ json_encode($data) }}" style="display: none;">
                                        {{ $data['value'] ?? '' }} <span>ر.س</span>
                                    </label>
                                @endforeach
                            </div>
                        @endif
                    @break

                    @case('fixed')
                        <div class="d-flex align-items-center justify-content-between mb-3 custom-card-btn-row">
                            <label title="{{ @$project['title'] }}" class="amount-btn" style="background-color: {{ @$colors[0] ?? '#3B82F6' }}">
                                {{ @$donation['data'] }} <span>ر.س</span>
                            </label>
                        </div>
                    @break

                    @case('open')
                        <div class="input-open-container">
                            <input class="form-control open custom-placeholder" type="number" placeholder="@lang('Price')" wire:model="openValue" min="0">
                        </div>
                    @break

                    @default
                        <div class="input-open-container">
                            <input class="form-control open" type="number" placeholder="مبلغ التبرع">
                        </div>
                @endswitch
            @else
                <div class="input-open-container">
                    <input class="form-control open" type="number" placeholder="مبلغ التبرع">
                </div>
            @endif

            <div class="d-flex align-items-center justify-content-between mb-3 custom-card-action-row">
                <input disabled class="form-control custom-card-input" type="text" placeholder="مبلغ التبرع" wire:model="donationAmt">
                <a href="{{ route('site.charity-project.show', $project['slug'] ?? $project->transNow?->slug) }}?amount={{ @$donationAmt }}">
                    <button class="btn btn-success flex-grow-1 custom-card-donate-btn">
                        تبرع الآن
                    </button>
                </a>
                <button class="btn btn-outline-secondary custom-card-cart-btn" wire:click="addToCart">
                    <i class="fa-solid fa-cart-plus"></i>
                </button>
            </div>

            @include('site.layouts.cart-msg')
        </div>
    </div>
</div>
<style>
    /* ========================================
   Project Cards - Fixed Design
   ======================================== */

/* Card Container */
.custom-card {
    background: #ffffff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
    border: 1px solid #e8e8e8;
}
.custom-card {
    max-width: 90% !important;
}
.custom-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
}

/* Card Header */
.custom-card-header {
    padding: 12px 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    direction: rtl;
}

.custom-card-header-bg {
    background: linear-gradient(135deg, #2d6a5a 0%, #3a8f7a 100%);
}

.custom-card-title {
    color: #ffffff;
    font-size: 16px;
    font-weight: 700;
    flex: 1;
    text-align: right;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.custom-card-icon {
    color: #ffffff;
    font-size: 16px;
    cursor: pointer;
    margin-right: 8px;
    opacity: 0.85;
    transition: opacity 0.2s;
}

.custom-card-icon:hover {
    opacity: 1;
}

/* Card Image */
.custom-card-img {
    position: relative;
    width: 100%;
    height: 160px;
    overflow: hidden;
    cursor: pointer;
}

.custom-card-img-bg {
    background: #f0f0f0;
}

.custom-card-img-el {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.custom-card-img:hover .custom-card-img-el {
    transform: scale(1.03);
}

/* Closed / Complete Badge */
.custom-card-img .closed {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(220, 53, 69, 0.9);
    color: #fff;
    padding: 4px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    z-index: 2;
}

.custom-card-img .complete-icon {
    position: absolute;
    top: -10px;
    left: 50%;
    transform: translateX(-50%);
    background: #28a745;
    color: #fff;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    font-weight: bold;
    z-index: 3;
    border: 3px solid #fff;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
}

/* Card Body */
.custom-card-body {
    padding: 16px;
    direction: rtl;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.custom-card-body-bg {
    background: #ffffff;
}

/* Money Collected Section */
.money-collected {
    margin-bottom: 12px;
}

.custom-card-amount-row {
    font-size: 12px;
    color: #555;
    direction: rtl;
}

.custom-card-amount-row span {
    line-height: 1.4;
}

.custom-card-amount-row span br {
    display: inline;
}

/* Progress Bar */
.custom-card-progress {
    height: 10px !important;
    border-radius: 10px !important;
    background-color: #e9ecef !important;
    overflow: hidden;
}

.custom-card-progress-bar {
    background: linear-gradient(90deg, #28a745 0%, #20c997 100%) !important;
    border-radius: 10px !important;
    transition: width 0.6s ease;
}

/* Donation Buttons Row */
.custom-card-btn-row {
    display: flex !important;
    gap: 6px !important;
    flex-wrap: wrap;
    justify-content: center !important;
    margin-bottom: 12px;
}

.amount-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 8px 16px;
    border-radius: 10px;
    color: #ffffff;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    border: 2px solid transparent;
    min-width: 70px;
    text-align: center;
    white-space: nowrap;
}

.amount-btn:hover {
    opacity: 0.9;
    transform: translateY(-1px);
}

.amount-btn.active {
    border-color: #333 !important;
    box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.15);
    transform: scale(1.05);
}

.amount-btn span {
    margin-right: 4px;
    font-size: 12px;
}

.amount-btn input[type="radio"] {
    display: none !important;
}

/* Open Amount Input */
.input-open-container {
    flex: 1;
    min-width: 100px;
}

.input-open-container input.open,
input.form-control.open {
    width: 100%;
    height: 40px;
    border: 1.5px solid #ddd;
    border-radius: 10px;
    padding: 6px 12px;
    font-size: 14px;
    text-align: center;
    direction: rtl;
    background: #fafafa;
    transition: border-color 0.2s;
}

.input-open-container input.open:focus,
input.form-control.open:focus {
    border-color: #3a8f7a;
    outline: none;
    box-shadow: 0 0 0 3px rgba(58, 143, 122, 0.1);
    background: #fff;
}

.custom-placeholder::placeholder {
    color: #aaa;
    font-size: 13px;
}

/* Action Row: Amount + Donate Button + Cart */
.custom-card-action-row {
    display: flex !important;
    align-items: center;
    gap: 8px;
    direction: rtl;
}

.custom-card-input {
    width: 90px !important;
    min-width: 90px;
    text-align: center;
    border-radius: 10px !important;
    border: 1.5px solid #ddd !important;
    background: #f9f9f9 !important;
    font-size: 14px;
    font-weight: 600;
    color: #333;
}

.custom-card-donate-btn {
    flex: 1;
    background: linear-gradient(135deg, #2d6a5a 0%, #3a8f7a 100%) !important;
    border: none !important;
    border-radius: 10px !important;
    color: #fff !important;
    font-weight: 700;
    font-size: 15px;
    padding: 8px 20px;
    transition: all 0.2s ease;
    white-space: nowrap;
}

.custom-card-donate-btn:hover {
    background: linear-gradient(135deg, #245a4c 0%, #2f7a66 100%) !important;
    transform: translateY(-1px);
    box-shadow: 0 3px 10px rgba(45, 106, 90, 0.3);
}

.custom-card-cart-btn {
    width: 42px;
    height: 42px;
    border-radius: 10px !important;
    border: 1.5px solid #ddd !important;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fff !important;
    color: #555 !important;
    transition: all 0.2s;
    padding: 0;
    flex-shrink: 0;
}

.custom-card-cart-btn:hover {
    border-color: #3a8f7a !important;
    color: #3a8f7a !important;
    background: #f0faf7 !important;
}

.custom-card-cart-btn i {
    font-size: 18px;
}

/* ========================================
   Swiper Fixes
   ======================================== */
.RamdanProjectSwiper .swiper-slide {
    height: auto;
}

.swiperMargin {
    padding: 10px 5px;
}

/* Swiper Navigation Buttons */
.RamdanProject-button-next,
.RamdanProject-button-prev {
    color: #2d6a5a !important;
}

.RamdanProject-button-next::after,
.RamdanProject-button-prev::after {
    font-size: 22px !important;
    font-weight: bold;
}

/* ========================================
   D-flex-t fix (unit type layout)
   ======================================== */
.d-flex-t {
    display: flex;
    gap: 8px;
    align-items: stretch;
    direction: rtl;
}

.d-flex-t .donations {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
}

.d-flex-t .input-open-container {
    display: flex;
    align-items: center;
}

/* ========================================
   Responsive Design
   ======================================== */

/* Tablets */
@media (max-width: 991.98px) {
    .custom-card-img {
        height: 140px;
    }
    
    .amount-btn {
        padding: 6px 12px;
        font-size: 13px;
        min-width: 60px;
    }
}

/* Mobile */
@media (max-width: 767.98px) {
    .CardBox.custom-card {
        margin: 0 auto;
        max-width: 320px;
    }
    
    .custom-card-img {
        height: 150px;
    }
    
    .custom-card-body {
        padding: 14px;
    }
    
    .custom-card-title {
        font-size: 15px;
    }
    
    .amount-btn {
        padding: 7px 10px;
        font-size: 13px;
        min-width: 55px;
        border-radius: 8px;
    }
    
    .custom-card-action-row {
        flex-wrap: nowrap;
    }
    
    .custom-card-input {
        width: 75px !important;
        min-width: 75px;
        font-size: 13px;
    }
    
    .custom-card-donate-btn {
        font-size: 14px;
        padding: 8px 14px;
    }
    
    .custom-card-cart-btn {
        width: 38px;
        height: 38px;
    }
    
    .d-flex-t {
        flex-direction: column;
    }
    
    .d-flex-t .donations {
        justify-content: center;
    }
}

/* Small Mobile */
@media (max-width: 575.98px) {
    .col-12.col-md-6.col-lg-6.col-xl-4 {
        padding-left: 8px;
        padding-right: 8px;
    }
    
    .custom-card-amount-row {
        font-size: 11px;
    }

    /* Swiper spacing fix */
.RamdanProjectSwiper {
    padding: 10px 5px;
}

.RamdanProjectSwiper .swiper-slide {
    height: auto;
    box-sizing: border-box;
}

.swiperMargin {
    padding: 8px 10px;
}
}
</style>