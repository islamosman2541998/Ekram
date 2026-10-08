@php
    use Illuminate\Support\Str;
@endphp
@php
    $projectTrans = $project->trans?->where('locale', $current_lang)->first();

    $projectTitle = $projectTrans?->title ?? $project->title ?? $settings->getItem('site_name');

    $projectDescription = Str::limit(
        trim(strip_tags($projectTrans?->description ?? '')),
        160
    );

    $projectImages = json_decode($project['images'] ?? '[]', true);

    if (!empty($project['cover_image'])) {
        $projectShareImage = getImage($project['cover_image']);
    } elseif (!empty($projectImages) && isset($projectImages[0])) {
        $projectShareImage = getImageFileManger($projectImages[0]);
    } else {
        $projectShareImage = asset('img/social-preview.png');
    }

    if (!Str::startsWith($projectShareImage, ['http://', 'https://'])) {
        $projectShareImage = asset($projectShareImage);
    }
@endphp

@section('title', $projectTitle)
@section('meta_description', $projectDescription)

@section('og_title', $projectTitle)
@section('og_description', $projectDescription)
@section('og_image', $projectShareImage)
@section('og_url', url()->current())

<div>
    @php
        $pjTitle = $project->trans?->where('locale', $current_lang)->first()->title;
        $pjCategory = $project->categories?->first()?->transNow?->title;
        $pjClosed = @$progressBar['avarge'] == '100' || @$project->finished == 1;
        $pjImages = json_decode((string) ($project['images'] ?? ''), true);
    @endphp

    <div class="ek-project">
        <div class="ek-pj-grid">

            <!-- Media -->
            <section class="ek-pj-media">
                @if ($pjImages != null)
                    <div id="carouselExampleIndicators" class="carousel slide project-image" data-bs-ride="carousel"
                        data-interval="10000">
                        <div class="carousel-indicators">
                            @forelse ($pjImages ?? [] as $key => $img)
                                <button type="button" data-bs-target="#carouselExampleIndicators"
                                    class="{{ $key == 0 ? 'active' : null }}" data-bs-slide-to="{{ $key }}"
                                    aria-label="Slide {{ $key }}"></button>
                            @empty
                            @endforelse
                        </div>
                        <div class="carousel-inner">
                            @forelse ($pjImages ?? [] as $key => $img)
                                <div class="carousel-item {{ $key == 0 ? 'active' : null }}">
                                    <img src="{{ getImageFileManger($img) }}" class="d-block w-100"
                                        alt="{{ $project->title }}">
                                </div>
                            @empty
                            @endforelse
                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button"
                            data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                @else
                    <div class="project-image">
                        <img src="{{ getImage($project['cover_image']) }}" alt="{{ $project->title }}" />
                    </div>
                @endif

                @if ($pjClosed)
                    <span class="ek-pj-closed"><i class="fa-solid fa-circle-check"></i> مكتمل</span>
                @endif
            </section>

            <!-- Donation -->
            <aside class="ek-pj-donate">
                <div class="ek-pj-card donation-card">
                    <div class="ek-pj-head">
                        <div class="ek-pj-head__text">
                            @if ($pjCategory)
                                <span class="ek-pj-chip">{{ $pjCategory }}</span>
                            @endif
                            <h1 class="ek-pj-title">{{ $pjTitle }}</h1>
                        </div>
                        <button class="ek-pj-share" type="button" title="مشاركة"
                            onclick="shareProject('{{ $pjTitle }}')">
                            <i class="fa-solid fa-share-nodes"></i>
                        </button>
                    </div>

                    <!-- Progress -->
                    <div class="ek-pj-progress">
                        <div class="ek-pj-progress__row">
                            <div>
                                <span class="ek-pj-progress__label">تم جمع</span>
                                <span class="ek-pj-progress__value">{{ $progressBar['collected'] }} <small>ر.س</small></span>
                            </div>
                            <span class="ek-pj-progress__pct">{{ $progressBar['avarge'] }}%</span>
                            <div class="text-end">
                                <span class="ek-pj-progress__label">المستهدف</span>
                                <span class="ek-pj-progress__value">{{ $progressBar['target_price'] }} <small>ر.س</small></span>
                            </div>
                        </div>
                        <div class="ek-pj-bar" role="progressbar" aria-valuenow="{{ $progressBar['avarge'] }}"
                            aria-valuemin="0" aria-valuemax="100">
                            <span style="width: {{ min(100, (float) $progressBar['avarge']) }}%"></span>
                        </div>
                    </div>

                    <!-- Amounts -->
                    @if (is_array($donation))
                        <div class="ek-pj-section-label">اختر مبلغ التبرع</div>
                        @switch($donation['type'])
                            @case('unit')
                                @php $amtCount = count(@$donation['data'] ?? []); @endphp
                                <div class="donation-amounts" data-count="{{ $amtCount > 4 ? 'many' : $amtCount }}">
                                    @forelse (@$donation['data'] ?? [] as $key => $data)
                                        <label data-toggle="tooltip" data-placement="top" title="{{ $data['name'] }}"
                                            style="--amt: {{ is_array($colors) && count($colors) > 0 ? $colors[$key % count($colors)] : '#ccc' }}"
                                            class="amount-btn {{ $unitValueRadio == json_encode($data) ? 'active' : null }} {{ $data['value'] == $donationAmt ? 'active' : null }}
                                            @if ($donation_status == 1) input-disable @endif">
                                            <input wire:model.live="unitValueRadio" type="radio" value="{{ json_encode($data) }}"
                                                @if ($donation_status == 1) disabled @endif style="display: none">
                                            <span class="amount-btn__value">{{ $data['value'] }}</span>
                                            <small class="amount-btn__cur">ر.س</small>
                                        </label>
                                    @empty
                                    @endforelse
                                </div>
                                <div class="custom-amount">
                                    <input type="number" wire:model.live="unitValueInput" min="0"
                                        placeholder="@lang('Another amount')" class="amount-input" />
                                    <span class="currency">ر.س</span>
                                </div>
                            @break

                            @case('share')
                                @php $amtCount = count(@$donation['data'] ?? []); @endphp
                                <div class="donation-amounts" data-count="{{ $amtCount > 4 ? 'many' : $amtCount }}">
                                    @forelse (@$donation['data']??[] as $key => $data)
                                        <label data-toggle="tooltip" data-placement="top" title="{{ $data['name'] }}"
                                            for="ab-{{ $key }}"
                                            style="--amt: {{ is_array($colors) && count($colors) > 0 ? $colors[$key % (count($colors) ?? 0)] : '#ccc' }}"
                                            class="amount-btn  {{ $shareValue == json_encode($data) ? 'active' : null }}">
                                            <input wire:model.live="shareValue" type="radio" value="{{ json_encode($data) }}"
                                                id="ab-{{ $key }}" style="display: none">
                                            <span class="amount-btn__value">{{ $data['value'] }}</span>
                                            <small class="amount-btn__cur">{{ $data['name'] }}</small>
                                        </label>
                                    @empty
                                    @endforelse
                                </div>
                            @break

                            @case('fixed')
                                <div class="donation-amounts">
                                    <button class="btn btn-primary amount-btn amount-btn-500 active"
                                        style="--amt: {{ @$colors[0] }}">
                                        <span class="amount-btn__value">{{ @$donation['data'] }}</span>
                                        <small class="amount-btn__cur">ر.س</small>
                                    </button>
                                </div>
                            @break

                            @case('open')
                                <div class="custom-amount">
                                    <input type="number" wire:model="openValue" min="0" placeholder="@lang('Price')"
                                        class="amount-input" />
                                    <span class="currency">ر.س</span>
                                </div>
                            @break

                            @default
                                <span>Something went wrong, please try again</span>
                        @endswitch
                    @endif

                    @livewire('site.gifts.add-gifts', [
                        'cards' => $cards,
                        'donation' => $donation,
                        'colorsAmount' => $colorsAmount,
                        'project' => $project,
                    ])

                    @include('site.layouts.cart-msg')

                    <!-- Total + actions -->
                    <div class="checkout-container">
                        <div class="ek-pj-total">
                            <span class="ek-pj-total__label">إجمالي التبرع</span>
                            <span class="ek-pj-total__value">{{ $this->totalAmt ?: 0 }} <small>ر.س</small></span>
                        </div>
                        <button class="checkout-btn" wire:click="donateNow()" wire:loading.attr="disabled"
                            wire:target="donateNow">
                            <i class="fa-solid fa-hand-holding-heart"></i>
                            تبرع الآن
                        </button>
                        <button class="cart-icon-btn" wire:click="addToCart()" wire:loading.attr="disabled"
                            wire:target="addToCart" title="أضف إلى السلة">
                            <i class="fa-solid fa-cart-plus cart-shop"></i>
                        </button>
                    </div>
                </div>
            </aside>

            <!-- About + stats -->
            <section class="ek-pj-about">
                <div class="ek-pj-card">
                    <h2 class="ek-pj-card__title"><i class="fa-solid fa-circle-info"></i> عن المشروع</h2>
                    <div class="project-details">
                        {!! $project->trans?->where('locale', $current_lang)->first()->description !!}
                    </div>
                </div>

                @if ($project && $project->statistic_status)
                    <div class="statistics-section">
                        <div class="stat-item">
                            <div class="stat-icon"><i class="fa-solid fa-eye"></i></div>
                            <div class="stat-content">
                                <div class="stat-value">{{ number_format($project->visits_count) }}</div>
                                <div class="stat-title">زيارة</div>
                            </div>
                        </div>

                        <div class="stat-item">
                            <div class="stat-icon"><i class="fa-solid fa-hand-holding-dollar"></i></div>
                            <div class="stat-content">
                                <div class="stat-value">{{ number_format($project->donations_count + $project->orderDetails?->sum('quantity')) }}</div>
                                <div class="stat-title">عملية تبرع</div>
                            </div>
                        </div>

                        <div class="stat-item">
                            <div class="stat-icon"><i class="fa-solid fa-hourglass-half"></i></div>
                            <div class="stat-content">
                                @if ($project->last_donation_at)
                                    <div class="stat-value stat-value--sm">{{ \Carbon\Carbon::parse(@$project->orderDetails ? $project->orderDetails?->last()?->created_at : $project->last_donation_at)->diffForHumans() }}</div>
                                    <div class="stat-title">آخر عملية تبرع</div>
                                @else
                                    <div class="stat-value stat-value--sm">—</div>
                                    <div class="stat-title">لا توجد تبرعات بعد</div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </section>
        </div>
    </div>
    @livewire('site.carts.add-modal')

    @include('livewire.site.charity-project.styles')
</div>
<script>
async function shareProject(title) {
    const shareData = {
        title: title,
        url: window.location.href,
    };

    if (navigator.share) {
        try {
            await navigator.share(shareData);
        } catch (err) {
        }
    } else {
        await navigator.clipboard.writeText(window.location.href);
        alert('تم نسخ الرابط!');
    }
}
</script>