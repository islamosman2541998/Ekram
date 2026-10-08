@extends('site.app')

@section('content')
    @livewire('site.fast-donation.index')

    <main class="ek-home">

        <x-site.home.sliders />

        <x-site.home.category />

        @livewire('site.home.projects')

        @livewire('site.home.requested-projects')

        <x-site.home.statistics />

        <x-site.home.news />

        @include('site.pages.maps')
    </main>

    <style>
        /* ================= Home: unified card sections ================= */
        .ek-home {
            --ek-frame: 1140px;
            --ek-teal: #2C5F5D;
            --ek-card-radius: 20px;
            --ek-card-border: #E6ECEB;
            --ek-card-shadow: 0 10px 28px rgba(31, 70, 69, .08);
            --ek-card-shadow-hover: 0 18px 40px rgba(31, 70, 69, .16);
            --ek-dots-h: 34px;
        }

        /* ---- Sections ---- */
        .ek-home .programs-section,
        .ek-home .RamdanProjects,
        .ek-home .media-center-section {
            padding: 56px 0 !important;
            margin: 0 !important;
        }

        /* ---- Titles ---- */
        .ek-home .programs-section .container > .text-center { margin-bottom: 0 !important; }

        .ek-home .programs-section .container > .text-center > h1,
        .ek-home .RamdanProjects .container > h1,
        .ek-home .RamdanProjects .container > h2,
        .ek-home .media-center-section .media-title {
            margin: 0 0 32px !important;
            font-family: 'brando', sans-serif !important;
            font-size: clamp(28px, 2.6vw, 40px) !important;
            font-weight: 700 !important;
            line-height: 1.3 !important;
            text-align: center;
        }

        .ek-home .RamdanProjects .container > br { display: none; }

        /* ---- Slider frame (same width for every section) ---- */
        .ek-home .ek-slider,
        .ek-home .RamdanProjects .Ramdan {
            position: relative;
            width: 100%;
            max-width: var(--ek-frame) !important;
            margin: 0 auto !important;
            padding: 0 !important;
        }

        .ek-home .ek-slider > .swiper,
        .ek-home .RamdanProjects .Ramdan > .swiper {
            width: 100%;
            max-width: none !important;
            margin: 0 !important;
            padding: 8px 2px 16px !important;
            overflow: hidden !important;
        }

        .ek-home .ek-slider .swiper-wrapper,
        .ek-home .RamdanProjects .swiper-wrapper { align-items: stretch; }

        .ek-home .ek-slider .swiper-slide,
        .ek-home .RamdanProjects .swiper-slide {
            height: auto !important;
            display: flex;
            margin-top: 0 !important;
            margin-bottom: 0 !important;
            padding: 0 !important;
        }

        .ek-home .ek-slider .swiper-slide > *,
        .ek-home .RamdanProjects .swiper-slide > * { width: 100%; }

        /* ---- Arrows (same look everywhere) ---- */
        .ek-home .ek-slider > .swiper-button-next,
        .ek-home .ek-slider > .swiper-button-prev,
        .ek-home .RamdanProjects .Ramdan > .swiper-button-next,
        .ek-home .RamdanProjects .Ramdan > .swiper-button-prev {
            position: absolute !important;
            top: calc((100% - var(--ek-dots-h)) / 2) !important;
            bottom: auto !important;
            display: flex !important;
            align-items: center;
            justify-content: center;
            width: 46px !important;
            height: 46px !important;
            margin: -23px 0 0 !important;
            border: 1px solid var(--ek-card-border) !important;
            border-radius: 50% !important;
            background: #fff !important;
            box-shadow: 0 8px 20px rgba(31, 70, 69, .14) !important;
            color: var(--ek-teal) !important;
            opacity: 1;
            z-index: 5;
            transform: none !important;
            transition: background-color .2s ease, color .2s ease, box-shadow .2s ease;
        }

        .ek-home .ek-slider > .swiper-button-next,
        .ek-home .RamdanProjects .Ramdan > .swiper-button-next { left: -66px !important; right: auto !important; }

        .ek-home .ek-slider > .swiper-button-prev,
        .ek-home .RamdanProjects .Ramdan > .swiper-button-prev { right: -66px !important; left: auto !important; }

        .ek-home .ek-slider > .swiper-button-next:hover,
        .ek-home .ek-slider > .swiper-button-prev:hover,
        .ek-home .RamdanProjects .Ramdan > .swiper-button-next:hover,
        .ek-home .RamdanProjects .Ramdan > .swiper-button-prev:hover {
            background: var(--ek-teal) !important;
            color: #fff !important;
        }

        .ek-home .ek-slider > .swiper-button-next::after,
        .ek-home .ek-slider > .swiper-button-prev::after,
        .ek-home .RamdanProjects .Ramdan > .swiper-button-next::after,
        .ek-home .RamdanProjects .Ramdan > .swiper-button-prev::after {
            font-family: swiper-icons !important;
            font-size: 15px !important;
            font-weight: 700 !important;
            color: inherit !important;
            background: none !important;
        }

        .ek-home .ek-slider > .swiper-button-next::after,
        .ek-home .RamdanProjects .Ramdan > .swiper-button-next::after { content: 'prev' !important; }

        .ek-home .ek-slider > .swiper-button-prev::after,
        .ek-home .RamdanProjects .Ramdan > .swiper-button-prev::after { content: 'next' !important; }

        .ek-home .swiper-button-disabled { opacity: .35 !important; pointer-events: none; }

        .ek-home .ek-slider > .swiper-button-lock,
        .ek-home .RamdanProjects .Ramdan > .swiper-button-lock { display: none !important; }

        @media (max-width: 1299.98px) {
            .ek-home .ek-slider > .swiper-button-next,
            .ek-home .RamdanProjects .Ramdan > .swiper-button-next { left: 6px !important; }

            .ek-home .ek-slider > .swiper-button-prev,
            .ek-home .RamdanProjects .Ramdan > .swiper-button-prev { right: 6px !important; }
        }

        /* ---- Pagination dots ---- */
        .ek-home .ek-dots {
            position: static !important;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 8px;
            width: 100% !important;
            min-height: var(--ek-dots-h);
            margin: 0 !important;
            padding: 4px 64px 0;
            transform: none !important;
            inset: auto !important;
        }

        .ek-home .ek-dots .swiper-pagination-bullet {
            width: 9px;
            height: 9px;
            margin: 0 !important;
            border-radius: 999px;
            background: var(--ek-teal);
            opacity: .22;
            cursor: pointer;
            transition: width .3s ease, opacity .3s ease, background-color .3s ease;
        }

        .ek-home .ek-dots .swiper-pagination-bullet:hover { opacity: .5; }

        .ek-home .ek-dots .swiper-pagination-bullet-active {
            width: 28px;
            opacity: 1;
            background: linear-gradient(90deg, var(--ek-teal), #469e8d);
        }

        .ek-home .ek-dots.swiper-pagination-lock { display: none; }

        @media (max-width: 767.98px) {
            .ek-home { --ek-dots-h: 52px; }

            .ek-home .ek-dots { padding: 6px 56px 0; }

            /* arrows sit on both ends of the dots bar */
            .ek-home .ek-slider > .swiper-button-next,
            .ek-home .ek-slider > .swiper-button-prev,
            .ek-home .RamdanProjects .Ramdan > .swiper-button-next,
            .ek-home .RamdanProjects .Ramdan > .swiper-button-prev {
                top: auto !important;
                bottom: 3px !important;
                width: 42px !important;
                height: 42px !important;
                margin: 0 !important;
            }

            .ek-home .ek-slider > .swiper-button-next,
            .ek-home .RamdanProjects .Ramdan > .swiper-button-next { left: 2px !important; }

            .ek-home .ek-slider > .swiper-button-prev,
            .ek-home .RamdanProjects .Ramdan > .swiper-button-prev { right: 2px !important; }

            .ek-home .ek-slider > .swiper-button-next::after,
            .ek-home .ek-slider > .swiper-button-prev::after,
            .ek-home .RamdanProjects .Ramdan > .swiper-button-next::after,
            .ek-home .RamdanProjects .Ramdan > .swiper-button-prev::after { font-size: 14px !important; }
        }

        /* ---- Shared card shell ---- */
        .ek-home .programs-section .program-card,
        .ek-home .RamdanProjects .custom-card,
        .ek-home .media-center-section .media-card {
            border: 1px solid var(--ek-card-border) !important;
            border-radius: var(--ek-card-radius) !important;
            box-shadow: var(--ek-card-shadow);
            overflow: hidden;
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .ek-home .programs-section .program-card:hover,
        .ek-home .RamdanProjects .custom-card:hover,
        .ek-home .media-center-section .media-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--ek-card-shadow-hover);
        }

        /* ---- Programs cards ---- */
        .ek-home .programs-section .swiper-slide > a { display: flex; }

        .ek-home .programs-section .program-card {
            display: flex;
            flex-direction: column;
            width: 100%;
            background: #fff;
        }

        .ek-home .programs-section .program-card-img img {
            height: 190px;
            width: 100%;
            object-fit: cover;
            border-radius: 0 !important;
        }

        .ek-home .programs-section .program-card-body {
            flex: 1;
            margin-top: 0 !important;
            padding: 18px 20px 20px !important;
            border-radius: 0 !important;
        }

        .ek-home .programs-section .program_title { align-items: center !important; }

        .ek-home .programs-section .program-card-title {
            margin: 0 !important;
            font-size: 28px !important;
            line-height: 1.3;
        }

        .ek-home .programs-section .programImg {
            width: 42px !important;
            margin: 0 !important;
        }

        .ek-home .programs-section .programP { margin-top: 10px !important; }

        .ek-home .programs-section .programP p,
        .ek-home .programs-section .programP .desc_P {
            margin: 0 !important;
            font-size: 15px !important;
            line-height: 1.75 !important;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* ---- Project cards (مشاريع متنوعة / الأكثر طلبا) ---- */
        .ek-home .RamdanProjects .custom-card {
            width: 100% !important;
            max-width: none !important;
            height: 100% !important;
            margin: 0 !important;
            background: #fff;
        }

        .ek-home .RamdanProjects .custom-card-header-bg {
            border-radius: 0 !important;
            padding: 14px 18px 10px !important;
        }

        .ek-home .RamdanProjects .custom-card-title { font-size: 17px !important; }

        .ek-home .RamdanProjects .custom-card-img { height: 225px !important; }

        .ek-home .RamdanProjects .custom-card-body { flex: 1; }

        /* ---- News cards ---- */
        .ek-home .media-center-section .media-card {
            display: flex;
            flex-direction: column;
            width: 100%;
            background: #fff;
        }

        .ek-home .media-center-section .media-link {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .ek-home .media-center-section .media-img { height: 200px !important; }

        .ek-home .media-center-section .media-body { flex: 1; padding: 14px 18px 18px !important; }

        .ek-home .media-center-section .media-heading {
            min-height: 0 !important;
            margin: 0 !important;
            font-size: 17px !important;
            line-height: 1.6 !important;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .ek-home .media-center-section .media-more-wrap { margin-top: 18px !important; }

        @media (max-width: 767.98px) {
            .ek-home .programs-section,
            .ek-home .RamdanProjects,
            .ek-home .media-center-section { padding: 40px 0 !important; }

            .ek-home .programs-section .container > .text-center > h1,
            .ek-home .RamdanProjects .container > h1,
            .ek-home .RamdanProjects .container > h2,
            .ek-home .media-center-section .media-title { margin-bottom: 22px !important; }
        }
    </style>

    <script>
        (function () {
            var breakpoints = {
                0: { slidesPerView: 1, spaceBetween: 16 },
                768: { slidesPerView: 2, spaceBetween: 20 },
                1200: { slidesPerView: 3, spaceBetween: 24 }
            };

            // Give the Blade-only sections (programs, news) the same frame the Livewire ones have,
            // with their arrows outside the swiper so they can sit beside the cards.
            function frame(swiperEl, arrows) {
                if (!swiperEl || swiperEl.parentElement.classList.contains('ek-slider')) return;
                var wrap = document.createElement('div');
                wrap.className = 'ek-slider';
                swiperEl.parentNode.insertBefore(wrap, swiperEl);
                wrap.appendChild(swiperEl);
                arrows.forEach(function (sel) {
                    var btn = document.querySelector(sel);
                    if (btn) wrap.appendChild(btn);
                });
            }

            function unify(swiperEl) {
                var s = swiperEl && swiperEl.swiper;
                if (!s) return;
                // Loop mode misbehaves with only a few slides (dots jump to the wrong slide);
                // rewind keeps the "endless" autoplay feel while dots stay accurate.
                if (s.params.loop) {
                    s.loopDestroy();
                    s.params.loop = s.originalParams.loop = false;
                }
                s.params.rewind = s.originalParams.rewind = true;
                s.params.breakpoints = breakpoints;
                s.originalParams.breakpoints = breakpoints;
                s.currentBreakpoint = null;
                s.setBreakpoint();
                s.update();
                s.slideTo(0, 0, false);
            }

            // Point a swiper's pagination at a new element (re-initialising the module).
            function paginate(s, el) {
                if (!s || !s.pagination || !el) return;
                if (s.pagination.el) {
                    try { s.pagination.destroy(); } catch (e) {}
                }
                s.params.pagination = Object.assign({}, s.params.pagination, {
                    el: el,
                    type: 'bullets',
                    clickable: true,
                    dynamicBullets: false
                });
                s.pagination.init();
                s.pagination.render();
                s.pagination.update();
            }

            // Dots row under the cards, inside the section's slider frame.
            function addDots(swiperEl) {
                if (!swiperEl || !swiperEl.swiper) return;
                var frameEl = swiperEl.parentElement;
                var dots = frameEl.querySelector(':scope > .ek-dots');
                if (!dots) {
                    dots = document.createElement('div');
                    dots.className = 'ek-dots';
                    swiperEl.insertAdjacentElement('afterend', dots);
                }
                paginate(swiperEl.swiper, dots);
            }

            window.addEventListener('load', function () {
                var home = document.querySelector('.ek-home');
                if (!home) return;

                frame(home.querySelector('.programs-section .ProjectSections'),
                    ['.ProjectSection-button-next', '.ProjectSection-button-prev']);
                frame(home.querySelector('.media-center-section .media-grid'),
                    ['.media-section-button-next', '.media-section-button-prev']);

                ['.programs-section .ProjectSections', '.RamdanProjectSwiper', '.projectsSlider', '.media-center-section .media-grid']
                    .forEach(function (sel) {
                        var el = home.querySelector(sel);
                        unify(el);
                        addDots(el);
                    });

                // The programs slider used the global ".swiper-pagination" selector and was drawing its
                // dots inside the hero/statistics sliders. Give those sliders back their own dots.
                ['.bannerSwiper', '.statisticsSwiper'].forEach(function (sel) {
                    var el = home.querySelector(sel);
                    var pg = el && el.querySelector(':scope > .swiper-pagination');
                    if (!el || !el.swiper || !pg) return;
                    paginate(el.swiper, pg);
                    pg.style.display = el.swiper.slides.length > 1 ? '' : 'none';
                });
            });
        })();
    </script>
@endsection
