<div>
    <div class="CardBox custom-card">
        <div class="custom-card-header d-flex align-items-center justify-content-between custom-card-header-bg">
            <span class="custom-card-title">{{ $project->trans->first()?->title }}</span>
            <i class="fa-solid fa-share-nodes custom-card-icon"></i>
        </div>
        <div onclick="window.location.href='{{ route('site.charity-project.show', $project->trans->first()?->slug) }}'" class="custom-card-img custom-card-img-bg">
            @if( @$progressBar['avarge'] == "100" || @$project->finished == 1)
                <span class="closed">مغلق</span>
                <div class="complete-icon">✔</div>
            @endif
            <img src="{{ asset(getImage($project['cover_image']) ?? 'site/img/project3.png') }}" alt="project" class="custom-card-img-el">
        </div>
        <div class="custom-card-body custom-card-body-bg">
            {{-- Progress Section --}}
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

            {{-- Action Row --}}
            <div class="d-flex align-items-center justify-content-between mb-3 custom-card-action-row">
                <input disabled class="form-control custom-card-input" type="text" placeholder="مبلغ التبرع" wire:model="donationAmt">
                <a href="{{ route('site.charity-project.show', $project->trans->first()?->slug) }}?amount={{ @$donationAmt }}">
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

