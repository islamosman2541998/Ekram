<!-- المركز الاعلامى -->
<section class="media-center-section media-section" dir="rtl">
    <div class="container">
        <h2 class="media-title">
            <span class="t2 main-font">المركز</span> <span class="t1 main-font">الإعلامي</span>
        </h2>

        <div class="media-grid swiper">
            <div class="swiper-wrapper">

                @foreach ($news as $item)
                    @php
                        $translation = $item->trans?->where('locale', app()->getLocale())->first();
                        $title = $translation->title ?? '';
                        $slug = $translation->slug ?? '';
                        $image = getImage($item->image);
                    @endphp

                    <article class="swiper-slide media-card">
                        <a href="{{ route('site.news.show', $slug) }}" class="media-link">
                            <div class="media-img">
                                <img src="{{ asset($image) }}" alt="{{ $title }}">
                            </div>

                            <div class="media-body">
                                <div class="media-meta">
                                    <span class="media-date">{{ $item->created_at?->format('Y / m / d') }}</span>
                                    <span class="media-dot"></span>

                                </div>

                                <h3 class="media-heading">
                                    {{ $title }}
                                </h3>
                            </div>
                        </a>
                    </article>
                @endforeach

            </div>
        </div>

        <div class="swiper-button-next media-section-button-next"></div>
        <div class="swiper-button-prev media-section-button-prev"></div>

        <div class="media-more-wrap">
            <a href="{{ route('site.news.index') }}" class="media-more-btn">المزيد</a>
        </div>
    </div>
</section>