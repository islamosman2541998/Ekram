@extends('site.app')

@php
    $translation = $news->trans?->where('locale', app()->getLocale())->first();
@endphp

@section('title', $translation->title ?? '')
@section('meta_title', $translation->meta_title ?? ($translation->title ?? ''))
@section('meta_description', $translation->meta_description ?? ($translation->description ?? ''))
@section('meta_key', $translation->meta_key ?? '')

@section('content')
    <section class="blog-single">
        <div class="container" data-animate="animate__fadeInLeft">
            <div class="col-lg-8 col-md-10 mb-4 cardDiv">
                <div class="news-details-card">

                    <div class="news-details-header">
                        <div class="news-breadcrumb">
                            <a href="{{ url('/') }}">الرئيسية</a>
                            <span class="separator">/</span>
                            <a href="{{ route('site.news.index') }}">الأخبار</a>
                            <span class="separator">/</span>
                            <span>{{ $translation->title ?? '' }}</span>
                        </div>

                        <h1 class="news-details-title">
                            {{ $translation->title ?? '' }}
                        </h1>

                        <div class="news-meta">
                            @if ($news->created_at)
                                <span>
                                    <i class="fa-regular fa-calendar-days"></i>
                                    <span><i
                                            class="fa-regular fa-calendar-days"></i>{{ $news->created_at->format('Y-m-d') }}</span>
                                </span>
                                <span>
                                    <i class="fa-regular fa-clock"></i>
                                    نُشر في {{ $news->created_at->format('Y-m-d') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <figure class="cover">
                        <img src="{{ asset(getImage($news->image)) }}" class="blogImg"
                            alt="{{ $translation->title ?? '' }}">
                    </figure>

                    <article class="content article1">
                        {!! $translation->content ?? '' !!}

                        <a href="{{ route('site.news.index') }}" class="news-back-btn">
                            ⬅ العودة إلى الأخبار
                        </a>
                    </article>
                </div>
            </div>
        </div>
    </section>
@endsection
