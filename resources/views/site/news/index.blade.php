@extends('site.app')

@section('title', __('site.news'))
@section('meta_title', @$settings['news_meta_title_' . app()->getLocale()])
@section('meta_description', @$settings['news_meta_description_' . app()->getLocale()])
@section('meta_key', @$settings['news_meta_key_' . app()->getLocale()])

@section('content')
    <div class="activities-container">
        <div class="row">

            @foreach ($news as $index => $item)
                @php
                    $translation = $item->trans?->where('locale', app()->getLocale())->first();
                    $title = $translation->title ?? '';
                    $description = $translation->description ?? '';
                    $slug = $translation->slug ?? '';
                    $image = getImage($item->image);
                @endphp

                @if ($index === 0)
                    {{-- First card - Large (col-8) --}}
                    <div class="col-lg-8 col-md-12 mb-4">
                        <div class="activity-card large-card">
                            <div class="activity-img">
                                <img src="{{ asset($image) }}" alt="{{ $title }}">
                            </div>
                            <div class="activity-content">
                                <h3 class="activity-title">{{ $title }}</h3>
                                <p class="activity-desc">{{ Str::limit($description, 200) }}</p>
                                <div class="activity-btn-container"></div>
                                <a href="{{ route('site.news.show', $slug) }}" class="activity-btn">المزيــــــــد</a>
                            </div>
                        </div>
                    </div>
                @else
                    {{-- Rest of cards - Small (col-4) --}}
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="activity-card">
                            <div class="activity-img">
                                <img src="{{ asset($image) }}" alt="{{ $title }}">
                            </div>
                            <div class="activity-content">
                                <h3 class="activity-title">{{ $title }}</h3>
                                <p class="activity-desc">{{ Str::limit($description, 200) }}</p>
                                <a href="{{ route('site.news.show', $slug) }}" class="activity-btn">المزيــــــــد</a>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

        </div>
    </div>
@endsection