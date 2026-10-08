@extends('site.app')

@section('title', @$category->transNow->meta_title)
@section('meta_key', @$category->transNow->meta_key)
@section('meta_description', @$category->transNow->meta_description)

@section('content')

@php
    $catTitle = @$category->trans->first()->title;
    $catDescription = @$category->trans->first()->description;
@endphp

<main class="ek-home ek-catpage">
    <div class="ek-cat-wrap">

        <nav class="ek-cat-breadcrumb" aria-label="breadcrumb">
            <a href="{{ route('site.home') }}">الرئيسية</a>
            <i class="fa-solid fa-chevron-left"></i>
            <a href="{{ route('site.projectCategories.index') }}">البرامج والمبادرات</a>
            <i class="fa-solid fa-chevron-left"></i>
            <span>{{ $catTitle }}</span>
        </nav>

        <!-- Category hero -->
        <section class="ek-cat-hero">
            <div class="ek-cat-hero__body">
                <span class="ek-cat-hero__icon">
                    <img src="{{ asset('img/3 (4).png') }}" alt="">
                </span>
                <h1 class="ek-cat-hero__title">{{ $catTitle }}</h1>
                @if ($catDescription)
                    <div class="ek-cat-hero__desc">{!! $catDescription !!}</div>
                @endif
                <a href="#projects" class="ek-cat-hero__cta">
                    تصفح المشاريع <i class="fa-solid fa-arrow-down"></i>
                </a>
            </div>

            @if ($category->background_image)
                <div class="ek-cat-hero__img">
                    <img src="{{ asset(getImage($category->background_image) ?? 'site/img/icon3.png') }}"
                        alt="{{ $catTitle }}">
                </div>
            @endif
        </section>

        <!-- Projects -->
        <section class="RamdanProjects ek-cat-projects">
            <h2 class="ek-cat-projects__title">
                <span style="color:#469e8d;">مشاريع</span>
                <span style="color:#faa440;">{{ $catTitle }}</span>
            </h2>

            @livewire('site.charity-category.show', ['category' => $category])
        </section>
    </div>
</main>

@include('site.layouts.ek-card-sliders')

<style>
    .ek-catpage {
        --cat-teal: #469e8d;
        --cat-teal-dark: #2C5F5D;
    }

    .ek-cat-wrap {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 16px 64px;
    }

    /* ---------- Breadcrumb ---------- */
    .ek-cat-breadcrumb {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 8px;
        margin: 24px 0 18px;
        color: #6B7C7A;
        font-size: 14px;
    }

    .ek-cat-breadcrumb a { color: #6B7C7A; text-decoration: none; }
    .ek-cat-breadcrumb a:hover { color: var(--cat-teal-dark); }
    .ek-cat-breadcrumb i { font-size: 10px; opacity: .6; }
    .ek-cat-breadcrumb span { color: var(--cat-teal-dark); font-weight: 600; }

    /* ---------- Hero ---------- */
    .ek-cat-hero {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
        overflow: hidden;
        border-radius: 24px;
        background: linear-gradient(135deg, #4fae9c 0%, var(--cat-teal) 45%, #3a8576 100%);
        box-shadow: 0 18px 40px rgba(31, 70, 69, .16);
    }

    .ek-cat-hero__body {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: center;
        gap: 14px;
        padding: 40px;
        color: #fff;
    }

    .ek-cat-hero__icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 64px;
        height: 64px;
        border-radius: 18px;
        background: rgba(255, 255, 255, .16);
    }

    .ek-cat-hero__icon img { width: 40px; height: auto; }

    .ek-cat-hero__title {
        margin: 0;
        color: #fff !important;
        font-family: 'brando', sans-serif;
        font-size: clamp(30px, 3.4vw, 46px) !important;
        font-weight: 800;
        line-height: 1.2;
    }

    .ek-cat-hero__desc,
    .ek-cat-hero__desc * {
        color: #fff !important;
    }

    .ek-cat-hero__desc {
        max-width: 560px;
        font-size: 17px;
        line-height: 1.9;
        opacity: .95;
    }

    .ek-cat-hero__desc p { margin: 0 0 6px; }

    .ek-cat-hero__cta {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        margin-top: 6px;
        padding: 12px 22px;
        border-radius: 999px;
        background: #fff;
        color: var(--cat-teal-dark) !important;
        font-size: 15px;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 10px 22px rgba(0, 0, 0, .12);
        transition: transform .15s ease, box-shadow .2s ease;
    }

    .ek-cat-hero__cta:hover { transform: translateY(-2px); box-shadow: 0 14px 28px rgba(0, 0, 0, .16); }

    .ek-cat-hero__img { position: relative; min-height: 340px; }

    .ek-cat-hero__img img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* ---------- Projects ---------- */
    .ek-catpage .ek-cat-projects {
        margin: 0 !important;
        padding: 48px 0 0 !important;
        scroll-margin-top: calc(var(--ek-nav-h, 81px) + 16px);
    }

    .ek-catpage .ek-cat-projects__title {
        margin: 0 0 28px;
        font-family: 'brando', sans-serif;
        font-size: clamp(26px, 2.4vw, 36px) !important;
        font-weight: 700;
        text-align: center;
    }

    /* the Livewire component brings its own section/container: flatten them */
    .ek-catpage .ek-cat-projects .RamdanProjects { margin: 0 !important; padding: 0 !important; }
    .ek-catpage .ek-cat-projects .container { max-width: none !important; padding: 0 !important; }

    /* flex (not grid) so that 1–2 projects sit centred */
    .ek-catpage #projects {
        --pj-cols: 3;
        --pj-gap: 24px;
        display: flex !important;
        flex-wrap: wrap;
        justify-content: center;
        gap: var(--pj-gap);
        width: 100% !important;
        max-width: none !important;
        margin: 0 !important;
        padding: 0 !important;
        scroll-margin-top: calc(var(--ek-nav-h, 81px) + 16px);
    }

    .ek-catpage #projects > .row { display: contents; }

    .ek-catpage #projects > .row > [class*="col-"] {
        flex: 0 0 calc((100% - (var(--pj-cols) - 1) * var(--pj-gap)) / var(--pj-cols));
        width: auto;
        max-width: none;
        margin: 0 !important;
        padding: 0 !important;
    }

    .ek-catpage #projects > h2 { flex: 1 1 100%; }
    .ek-catpage #projects > .row > [class*="col-"] > div { height: 100%; }

    .ek-catpage #projects .custom-card {
        width: 100% !important;
        max-width: none !important;
        height: 100% !important;
        margin: 0 !important;
        border: 1px solid #E6ECEB !important;
        border-radius: 20px !important;
        background: #fff;
        box-shadow: 0 10px 28px rgba(31, 70, 69, .08);
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .ek-catpage #projects .custom-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 18px 40px rgba(31, 70, 69, .16);
    }

    .ek-catpage #projects .custom-card-header-bg { border-radius: 0 !important; padding: 14px 18px 10px !important; }
    .ek-catpage #projects .custom-card-title { font-size: 17px !important; }
    .ek-catpage #projects .custom-card-img { height: 225px !important; }

    .ek-catpage .infoBox { margin-top: 28px !important; }

    .ek-catpage .button-more {
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        min-width: 160px;
        padding: 12px 34px !important;
        border: 0 !important;
        border-radius: 999px !important;
        background: var(--cat-teal-dark) !important;
        color: #fff !important;
        font-size: 16px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        transition: transform .15s ease, opacity .2s ease;
    }

    .ek-catpage .button-more:hover { transform: translateY(-2px); opacity: .92; }

    /* ---------- Responsive ---------- */
    @media (max-width: 1199.98px) {
        .ek-catpage #projects { --pj-cols: 2; --pj-gap: 20px; }
    }

    @media (max-width: 767.98px) {
        .ek-cat-wrap { padding: 0 12px 40px; }
        .ek-cat-breadcrumb { margin: 18px 0 14px; font-size: 13px; }

        .ek-cat-hero { grid-template-columns: minmax(0, 1fr); border-radius: 20px; }
        .ek-cat-hero__img { order: -1; min-height: 0; aspect-ratio: 16 / 10; }
        .ek-cat-hero__body { gap: 12px; padding: 24px 20px 26px; }
        .ek-cat-hero__icon { width: 52px; height: 52px; border-radius: 14px; }
        .ek-cat-hero__icon img { width: 32px; }
        .ek-cat-hero__desc { font-size: 15.5px; line-height: 1.85; }
        .ek-cat-hero__cta { width: 100%; justify-content: center; }

        .ek-catpage .ek-cat-projects { padding-top: 36px !important; }
        .ek-catpage .ek-cat-projects__title { margin-bottom: 20px; }
        .ek-catpage #projects { --pj-cols: 1; --pj-gap: 18px; }
    }
</style>
@endsection
