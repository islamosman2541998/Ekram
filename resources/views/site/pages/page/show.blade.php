@extends('site.app')

@section('title', @$page->trans->where('locale', $current_lang)->first()->meta_title)
@section('meta_key', @$page->trans->where('locale', $current_lang)->first()->meta_key)
@section('meta_description', @$page->trans->where('locale', $current_lang)->first()->meta_description)


@section('content')
    @php
        $isPdf = fn($path) => is_string($path) && str_ends_with(strtolower($path), '.pdf');
        // readable file name: no folder, no extension, no leading upload timestamp
        $fileLabel = function ($path) {
            $name = pathinfo((string) $path, PATHINFO_FILENAME);
            $name = preg_replace('/^\d{6,}[_-]?/', '', $name);
            $name = trim(str_replace(['_', '-'], ' ', $name));
            return $name !== '' ? $name : 'ملف مرفق';
        };

        $pageFiles = is_array($page->files) ? array_values(array_filter($page->files)) : [];
        $pageImages = array_values(array_filter($pageFiles, fn($f) => !$isPdf($f)));
        $pagePdfs = array_values(array_filter($pageFiles, fn($f) => $isPdf($f)));
        $mainIsPdf = $page->image && $isPdf($page->image);
    @endphp

    <main class="ek-page">
        <div class="ek-page__wrap">

            <nav class="ek-page__breadcrumb" aria-label="breadcrumb">
                <a href="{{ route('site.home') }}">الرئيسية</a>
                <i class="fa-solid fa-chevron-left"></i>
                <span>{{ $page->title }}</span>
            </nav>

            <h1 class="ek-page__title">{{ $page->title }}</h1>

            <article class="ek-page__card">

                @if (trim(strip_tags((string) $page->content, '<img><iframe><video><table>')) !== '')
                    <div class="ek-page__content">{!! $page->content !!}</div>
                @endif

                {{-- Main image / main PDF --}}
                @if ($page->image)
                    @if ($mainIsPdf)
                        <a href="{{ getImage($page->image) }}" target="_blank" rel="noopener" class="ek-file ek-file--main">
                            <span class="ek-file__icon"><i class="fa-solid fa-file-pdf"></i></span>
                            <span class="ek-file__info">
                                <span class="ek-file__name">{{ $fileLabel($page->image) }}</span>
                                <span class="ek-file__meta">ملف PDF</span>
                            </span>
                            <span class="ek-file__action"><i class="fa-solid fa-arrow-up-right-from-square"></i> عرض الملف</span>
                        </a>
                    @else
                        <figure class="ek-page__hero">
                            <a href="{{ getImage($page->image) }}" target="_blank" rel="noopener"
                                data-ek-lightbox="{{ getImage($page->image) }}">
                                <img src="{{ getImage($page->image) }}" alt="{{ $page->title }}" loading="lazy">
                                <span class="ek-zoom"><i class="fa-solid fa-magnifying-glass-plus"></i></span>
                            </a>
                        </figure>
                    @endif
                @endif

                {{-- Attachments --}}
                @if (count($pageFiles))
                    <section class="ek-page__files">
                        <h2 class="ek-page__files-title">
                            <i class="fa-solid fa-paperclip"></i> المرفقات
                            <span>{{ count($pageFiles) }}</span>
                        </h2>

                        @if (count($pageImages))
                            <div class="ek-gallery">
                                @foreach ($pageImages as $file)
                                    <a href="{{ getImage($file) }}" target="_blank" rel="noopener" class="ek-gallery__item"
                                        data-ek-lightbox="{{ getImage($file) }}">
                                        <img src="{{ getImage($file) }}" alt="{{ $page->title }}" loading="lazy">
                                        <span class="ek-zoom"><i class="fa-solid fa-magnifying-glass-plus"></i></span>
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        @if (count($pagePdfs))
                            <div class="ek-files">
                                @foreach ($pagePdfs as $file)
                                    <a href="{{ getImage($file) }}" target="_blank" rel="noopener" class="ek-file">
                                        <span class="ek-file__icon"><i class="fa-solid fa-file-pdf"></i></span>
                                        <span class="ek-file__info">
                                            <span class="ek-file__name">{{ $fileLabel($file) }}</span>
                                            <span class="ek-file__meta">ملف PDF</span>
                                        </span>
                                        <span class="ek-file__action"><i class="fa-solid fa-arrow-up-right-from-square"></i> عرض</span>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </section>
                @endif
            </article>
        </div>

        <!-- Lightbox -->
        <div class="ek-lightbox" id="ekLightbox" aria-hidden="true">
            <button type="button" class="ek-lightbox__close" aria-label="إغلاق"><i class="fa-solid fa-xmark"></i></button>
            <button type="button" class="ek-lightbox__nav ek-lightbox__prev" aria-label="السابق"><i class="fa-solid fa-chevron-right"></i></button>
            <img src="" alt="">
            <button type="button" class="ek-lightbox__nav ek-lightbox__next" aria-label="التالي"><i class="fa-solid fa-chevron-left"></i></button>
        </div>
    </main>

    <style>
        .ek-page {
            --pg-teal: #2C5F5D;
            --pg-teal-2: #469e8d;
            --pg-text: #1F3B3A;
            --pg-muted: #6B7C7A;
            --pg-border: #E3ECEB;
            --pg-soft: #F3F8F7;
        }

        .ek-page *,
        .ek-page *::before,
        .ek-page *::after { box-sizing: border-box; }

        .ek-page__wrap { max-width: 1100px; margin: 0 auto; padding: 0 16px 64px; }

        .ek-page__breadcrumb {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 8px;
            margin: 24px 0 10px;
            color: var(--pg-muted);
            font-size: 14px;
        }

        .ek-page__breadcrumb a { color: var(--pg-muted); text-decoration: none; }
        .ek-page__breadcrumb a:hover { color: var(--pg-teal); }
        .ek-page__breadcrumb i { font-size: 10px; opacity: .6; }
        .ek-page__breadcrumb span { color: var(--pg-teal); font-weight: 600; }

        .ek-page__title {
            position: relative;
            margin: 0 0 22px;
            padding-bottom: 12px;
            color: var(--pg-text);
            font-family: 'brando', sans-serif;
            font-size: clamp(26px, 3vw, 38px) !important;
            font-weight: 800;
        }

        .ek-page__title::after {
            content: "";
            position: absolute;
            bottom: 0;
            inset-inline-start: 0;
            width: 64px;
            height: 4px;
            border-radius: 4px;
            background: linear-gradient(90deg, var(--pg-teal-2), #faa440);
        }

        .ek-page__card {
            display: flex;
            flex-direction: column;
            gap: 28px;
            padding: 32px;
            border: 1px solid var(--pg-border);
            border-radius: 24px;
            background: #fff;
            box-shadow: 0 12px 34px rgba(31, 70, 69, .07);
        }

        /* ---------- Rich content from the dashboard editor ---------- */
        .ek-page__content {
            color: #3B5150;
            font-size: 16.5px;
            line-height: 2;
            overflow-wrap: anywhere;
        }

        .ek-page__content > :first-child { margin-top: 0; }
        .ek-page__content > :last-child { margin-bottom: 0; }
        .ek-page__content p { margin: 0 0 12px; }
        .ek-page__content h2, .ek-page__content h3, .ek-page__content h4 { margin: 20px 0 10px; color: var(--pg-text); font-weight: 700; }
        .ek-page__content ul, .ek-page__content ol { margin: 0 0 12px; padding-inline-start: 22px; }
        .ek-page__content a { color: var(--pg-teal-2); font-weight: 600; text-decoration: underline; text-underline-offset: 3px; }
        .ek-page__content img { max-width: 100%; height: auto; border-radius: 14px; }

        .ek-page__content iframe,
        .ek-page__content video,
        .ek-page__content embed {
            display: block;
            width: 100% !important;
            max-width: 100%;
            min-height: 520px;
            margin: 8px 0 12px;
            border: 1px solid var(--pg-border);
            border-radius: 16px;
            background: var(--pg-soft);
        }

        .ek-page__content table { display: block; width: 100%; max-width: 100%; overflow-x: auto; border-collapse: collapse; }
        .ek-page__content td, .ek-page__content th { padding: 8px 12px; border: 1px solid var(--pg-border); }

        /* ---------- Main image ---------- */
        .ek-page__hero { margin: 0; }

        .ek-page__hero a,
        .ek-gallery__item {
            position: relative;
            display: block;
            overflow: hidden;
            border-radius: 18px;
            background: var(--pg-soft);
            cursor: zoom-in;
        }

        .ek-page__hero img {
            display: block;
            width: 100%;
            height: auto;
            max-height: calc(100vh - var(--ek-nav-h, 81px) - 120px);
            object-fit: contain;
            margin: 0 auto;
        }

        .ek-zoom {
            position: absolute;
            top: 12px;
            inset-inline-end: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .92);
            color: var(--pg-teal);
            font-size: 16px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, .15);
            opacity: 0;
            transform: scale(.85);
            transition: opacity .2s ease, transform .2s ease;
        }

        .ek-page__hero a:hover .ek-zoom,
        .ek-gallery__item:hover .ek-zoom { opacity: 1; transform: scale(1); }

        /* ---------- Attachments ---------- */
        .ek-page__files { padding-top: 24px; border-top: 1px dashed var(--pg-border); }

        .ek-page__files-title {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0 0 16px;
            color: var(--pg-text);
            font-size: 19px !important;
            font-weight: 700;
        }

        .ek-page__files-title i { color: var(--pg-teal-2); }

        .ek-page__files-title span {
            min-width: 26px;
            height: 26px;
            padding: 0 8px;
            border-radius: 999px;
            background: var(--pg-soft);
            color: var(--pg-teal);
            font-size: 13px;
            line-height: 26px;
            text-align: center;
        }

        .ek-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 14px;
        }

        .ek-gallery + .ek-files { margin-top: 16px; }

        .ek-gallery__item {
            aspect-ratio: 4 / 3;
            border: 1px solid var(--pg-border);
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .ek-gallery__item:hover { transform: translateY(-3px); box-shadow: 0 12px 26px rgba(31, 70, 69, .14); }

        .ek-gallery__item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .3s ease;
        }

        .ek-gallery__item:hover img { transform: scale(1.04); }

        .ek-files {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 12px;
        }

        .ek-file {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
            padding: 14px 16px;
            border: 1px solid var(--pg-border);
            border-radius: 16px;
            background: #fff;
            color: var(--pg-text);
            text-decoration: none;
            transition: border-color .2s ease, box-shadow .2s ease, transform .15s ease;
        }

        .ek-file:hover {
            border-color: var(--pg-teal-2);
            color: var(--pg-text);
            box-shadow: 0 10px 22px rgba(31, 70, 69, .1);
            transform: translateY(-2px);
        }

        .ek-file__icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: none;
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: #FDECEC;
            color: #D64545;
            font-size: 22px;
        }

        .ek-file__icon i,
        .ek-zoom i,
        .ek-file__action i,
        .ek-lightbox button i { font-size: inherit !important; }

        .ek-file__info { display: flex; flex-direction: column; gap: 2px; flex: 1; min-width: 0; }

        .ek-file__name {
            overflow: hidden;
            font-size: 15px;
            font-weight: 700;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .ek-file__meta { color: var(--pg-muted); font-size: 12.5px; }

        .ek-file__action {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            flex: none;
            padding: 8px 12px;
            border-radius: 10px;
            background: var(--pg-soft);
            color: var(--pg-teal);
            font-size: 13px;
            font-weight: 700;
            white-space: nowrap;
        }

        .ek-file--main { padding: 18px 20px; }
        .ek-file--main .ek-file__icon { width: 56px; height: 56px; font-size: 26px; }
        .ek-file--main .ek-file__name { font-size: 17px; }

        /* ---------- Lightbox ---------- */
        .ek-lightbox {
            position: fixed;
            inset: 0;
            z-index: 2000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 56px 64px;
            background: rgba(10, 22, 21, .88);
            opacity: 0;
            visibility: hidden;
            transition: opacity .25s ease, visibility .25s;
        }

        .ek-lightbox.is-open { opacity: 1; visibility: visible; }

        .ek-lightbox img {
            max-width: 100%;
            max-height: 100%;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .4);
            object-fit: contain;
        }

        .ek-lightbox button {
            position: absolute;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 46px;
            height: 46px;
            border: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, .14);
            color: #fff;
            font-size: 18px;
            cursor: pointer;
            transition: background-color .2s ease;
        }

        .ek-lightbox button:hover { background: rgba(255, 255, 255, .28); }
        .ek-lightbox__close { top: 14px; inset-inline-end: 14px; }
        .ek-lightbox__prev { inset-inline-start: 12px; top: 50%; margin-top: -23px; }
        .ek-lightbox__next { inset-inline-end: 12px; top: 50%; margin-top: -23px; }
        .ek-lightbox.is-single .ek-lightbox__nav { display: none; }

        /* ---------- Responsive ---------- */
        @media (max-width: 767.98px) {
            .ek-page__wrap { padding: 0 12px 40px; }
            .ek-page__breadcrumb { margin: 18px 0 8px; font-size: 13px; }
            .ek-page__title { margin-bottom: 16px; }
            .ek-page__card { gap: 22px; padding: 18px; border-radius: 18px; }
            .ek-page__content { font-size: 15.5px; line-height: 1.9; }
            .ek-page__content iframe, .ek-page__content video, .ek-page__content embed { min-height: 460px; }
            .ek-page__hero img { max-height: 70vh; }
            .ek-zoom { opacity: 1; transform: none; width: 34px; height: 34px; font-size: 14px; }
            .ek-gallery { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 10px; }
            .ek-files { grid-template-columns: minmax(0, 1fr); }
            .ek-file__action { padding: 8px 10px; }
            .ek-lightbox { padding: 64px 12px; }
            .ek-lightbox__prev, .ek-lightbox__next { top: auto; bottom: 14px; margin: 0; }
        }
    </style>

    <script>
        (function () {
            var box = document.getElementById('ekLightbox');
            if (!box) return;
            var img = box.querySelector('img');
            var items = [].slice.call(document.querySelectorAll('.ek-page [data-ek-lightbox]'));
            var current = 0;

            function show(i) {
                current = (i + items.length) % items.length;
                img.src = items[current].getAttribute('data-ek-lightbox');
                box.classList.toggle('is-single', items.length < 2);
                box.classList.add('is-open');
                box.setAttribute('aria-hidden', 'false');
                document.documentElement.style.overflow = 'hidden';
            }

            function close() {
                box.classList.remove('is-open');
                box.setAttribute('aria-hidden', 'true');
                document.documentElement.style.overflow = '';
            }

            items.forEach(function (a, i) {
                a.addEventListener('click', function (e) {
                    e.preventDefault();
                    show(i);
                });
            });

            box.querySelector('.ek-lightbox__close').addEventListener('click', close);
            box.querySelector('.ek-lightbox__prev').addEventListener('click', function () { show(current - 1); });
            box.querySelector('.ek-lightbox__next').addEventListener('click', function () { show(current + 1); });
            box.addEventListener('click', function (e) { if (e.target === box) close(); });

            document.addEventListener('keydown', function (e) {
                if (!box.classList.contains('is-open')) return;
                if (e.key === 'Escape') close();
                if (e.key === 'ArrowLeft') show(current + 1);
                if (e.key === 'ArrowRight') show(current - 1);
            });
        })();
    </script>
@endsection
