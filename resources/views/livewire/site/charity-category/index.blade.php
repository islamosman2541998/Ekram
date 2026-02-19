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

<section class="service-flow py-5" dir="rtl">
    <div class="container">

        <div class="row justify-content-center mb-4">
            <div class="col-lg-8 text-center">
                <h1 class="fw-bold fs-3 main-font mb-3">
                    <span style="color:#469e8d ;">رحلة</span>
                    <span style="color:#faa440 ;">المستفيد </span>
                    <span style="color:#ee5a34 ;">مع خدماتنا</span>
                </h1>

                <p class="service-flow-subtitle main-font">
                    نرافق كبار السن في كل خطوة، من طلب الخدمة وحتى المتابعة المستمرة لضمان أعلى مستويات الجودة والراحة.
                </p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 position-relative">

                <div class="flow-line d-none d-md-block"></div>

                <div class="row g-4 text-center text-md-right align-items-start">

                    <div class="col-md-4">
                        <div class="flow-step">
                            <div class="step-circle step-orange">1</div>
                            <h3 class="step-title">طلب الخدمة</h3>
                            <p class="step-text main-font">
                                يستقبل فريق الجمعية طلبات الخدمة عبر الهاتف، الموقع الإلكتروني أو الزيارات المباشرة
                                من كبار السن أو ذويهم.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="flow-step">
                            <div class="step-circle step-yellow">2</div>
                            <h3 class="step-title">تقييم الاحتياج</h3>
                            <p class="step-text main-font">
                                يتم تقييم حالة المستفيد بشكل إنساني ومهني لتحديد نوع البرامج المناسبة له
                                من اجتماعية، ترفيهية أو تعليمية.
                            </p>
                        </div>
                    </div>

                    <!-- خطوة 3 -->
                    <div class="col-md-4">
                        <div class="flow-step">
                            <div class="step-circle step-green">3</div>
                            <h3 class="step-title">تنفيذ ومتابعة</h3>
                            <p class="step-text main-font">
                                تبدأ رحلة المستفيد مع البرامج المختارة، مع متابعة دورية للتأكد من رضا كبار السن
                                وتحسين جودة الخدمات المقدمة لهم.
                            </p>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
</section>

<style>
    .programP p {
        color: white !important;
    }
</style>
