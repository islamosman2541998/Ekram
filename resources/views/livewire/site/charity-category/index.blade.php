<section class="programs-section py-5" dir="rtl">
    <div class="container">

        <!-- Title -->
        <div class="text-center mb-5">
            <h1 class="fw-bold fs-1 main-font mb-3">
                <span style="color:#469e8d;">البرامج</span>
                <span style="color:#faa440;">والمبادرات </span>
                <span style="color:#ee5a34;">والفعاليات</span>
            </h1>
        </div>

        <!-- Cards -->
        @php
            $cardColors = ['#ee5a34', '#469e8d', '#faa440', '#2c7a7b'];
        @endphp

        <!-- Cards -->
        <div class="swiper ProjectSections">
            <div class="swiper-wrapper">
                @forelse ($categoriesCarousels as $carouselIndex => $carousel)
                    @forelse ($carousel as $key => $category)
                        <div class="swiper-slide">
                            <a href="{{ route('site.projectCategories.show', @$category['trans'][0]['slug']) }}"
                                class="text-decoration-none">
                                <div class="program-card h-100">
                                    <div class="program-card-img">
                                        @if ($category['background_image'])
                                            <img src="{{ asset(getImage($category['background_image'])) }}"
                                                class="img-fluid" alt="{{ @$category['trans'][0]['title'] }}">
                                        @endif
                                    </div>
                                    <div class="program-card-body"
                                        style="background-color: {{ $cardColors[$key % count($cardColors)] }};">
                                        <div class="program_title">
                                            <h1 class="program-card-title fw-bold mb-3 main-font">
                                                {{ @$category['trans'][0]['title'] }}
                                            </h1>
                                            <img src="{{ asset('img/3 (4).png') }}" class="programImg">
                                        </div>
                                        <div class="programP">
                                            <p class="mb-0 desc_P second-font">
                                                {!! @$category['trans'][0]['description'] !!}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                    @endforelse
                @empty
                @endforelse
            </div>
            <div class="swiper-button-next ProjectSection-button-next"></div>
            <div class="swiper-button-prev ProjectSection-button-prev"></div>
        </div>

        <div class="text-center mt-3">
            @if ($categoriesCount - count($categoriesCarousels) * 8 > 0)
                <a class="btn btn-primary px-5 d-inline-block" wire:click="loadCategories" role="button">
                    @lang('More')
                </a>
            @endif
        </div>

    </div>
</section>



<style>
    .programP p {
        color: white !important;
    }
</style>
