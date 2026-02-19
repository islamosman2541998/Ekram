@if ($categories->count() > 0 && $showSection)
    {{-- <section class="sections home">
        <div class="category-container">
            <p class="title text-center">الأقســـــــام</p>
            <div class="SectionSwiper mt-lg-5 mt-sm-0">
                <div class="swiper ProjectSections">
                    <div class="swiper-wrapper">
                        @foreach ($categories as $key => $category)
                            <div class="swiper-slide">
                                <a href="{{ route('site.projectCategories.show', $category->transNow->slug) }}">
                                    <div class="category-content Card">
                                        @if ($category->background_image)
                                            <img class="category-img"
                                                src="{{ asset(getImage($category->background_image) ?? 'site/img/icon3.png') }}"
                                                alt="">
                                        @endif

                                        @php
                                            $title = $category->trans->first()->title ?? '';
                                        @endphp

                                        @if (strlen($title) > 10)
                                            <div class="category-desc category-title">
                                                {{ $title }}
                                            </div>
                                        @else
                                            <div class="category-desc">
                                                {{ $title }}
                                            </div>
                                        @endif
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    @if ($categories->count() > 1)
                        <div class="swiper-button-prev ProjectSection-button-prev"></div>
                        <div class="swiper-button-next ProjectSection-button-next"></div>
                    @endif
                </div>
                @if ($categories->count() > 1)
                    <div class="swiper-pagination"></div>
                @endif
                <div class="infoBox text-center mt-1 px-3 py-1">
                    <a href="{{ route('site.projectCategories.index') }}"
                        class="btn btn-success flex-grow-1 custom-card-donate-btn">
                        المزيـــــــــد
                    </a>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- الاقسام -->
    <section class="programs-section py-5" dir="rtl">
        <div class="container">

            <!-- Title -->
            <div class="text-center mb-5">
                <h1 class="fw-bold fs-1 main-font mb-3">
                    <span class="main-font" style="color:#469e8d ;">البرامج</span>
                    <span style="color:#faa440 ;">والمبادرات </span>
                    <span style="color:#ee5a34 ;">والفعاليات</span>
                </h1>
            </div>
            <!-- Cards -->
            <div class="swiper ProjectSections">
                <div class="swiper-wrapper">
                    <!-- Card 1 -->
                    @foreach ($categories as $key => $category)
                        <div class=" swiper-slide">
                            <a href="{{ route('site.projectCategories.show', $category->transNow->slug) }}"
                                class="text-decoration-none">
                                <div class="program-card h-100">
                                    <div class="program-card-img">
                                        @if ($category->background_image)
                                            <img src="{{ asset(getImage($category->background_image) ?? 'site/img/icon3.png') }}"
                                                class="img-fluid" alt="برنامج ترفيهي">
                                        @endif
                                    </div>
                                    <div class="program-card-body program-card-entertain">
                                        <div class="program_title">
                                            @php
                                                $title = $category->trans->first()->title ?? '';
                                            @endphp
                                            <h1 class="program-card-title fw-bold mb-3 main-font">{{ $title }}
                                            </h1>
                                            <img src="./img/3 (4).png" class="programImg">
                                        </div>
                                        <div class="programP">
                                            @php
                                                $description = $category->trans->first()->description ?? '';
                                            @endphp
                                            <p class="mb-0 desc_P second-font">
                                             {!! $description !!}
                                            </p>

                                        </div>
                                    </div>
                                </div>
                            </a>

                        </div>
                    @endforeach
                </div>
                <div class="swiper-button-next ProjectSection-button-next"></div>
                <div class="swiper-button-prev ProjectSection-button-prev"></div>
            </div>
        </div>
    </section>
@endif
<style>
    .programP p {
        color:white !important;
    }
</style>