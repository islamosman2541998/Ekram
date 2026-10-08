@extends('site.app')

@section('title', @$project->trans?->where('locale', $current_lang)->first()->title)
@section('meta_key', @$project->trans?->where('locale', $current_lang)->first()->meta_key)
@section('meta_description', @$project->trans?->where('locale', $current_lang)->first()->meta_description)

@section('content')

<main>
    <div class="container  project-page">
        {{-- <div class="project-header">
                <figure class="head-img-container">
                    <img src="\site\img\leave.png" alt="">
                </figure>
                <div class="project-header-content">
                    قال رسول الله ﷺ : ( من فطر صائمًا كان له مثل أجره )
                    <br>
                    وجبة إفطار منك تٌطعم صائمًا و يكتب ثوابها لك ..
                </div>
            </div> --}}

        <nav class="ek-pj-breadcrumb" aria-label="breadcrumb">
            <a href="{{ route('site.home') }}">الرئيسية</a>
            @if ($project->categories?->first())
                <i class="fa-solid fa-chevron-left"></i>
                <a href="{{ route('site.projectCategories.show', @$project->categories?->first()?->transNow?->slug ?? 1) }}">{{ $project->categories?->first()?->transNow?->title ?? '' }}</a>
            @endif
            <i class="fa-solid fa-chevron-left"></i>
            <span>{{ $project->transNow?->title }}</span>
        </nav>

        <style>
            .project-page.container { max-width: 1200px !important; padding: 0 16px; }

            .ek-pj-breadcrumb {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                gap: 8px;
                margin: 32px 0 20px;
                color: #6B7C7A;
                font-size: 14px;
            }

            .ek-pj-breadcrumb a { color: #6B7C7A; text-decoration: none; }
            .ek-pj-breadcrumb a:hover { color: #2C5F5D; }
            .ek-pj-breadcrumb i { font-size: 10px; opacity: .6; }

            .ek-pj-breadcrumb span {
                max-width: 100%;
                overflow: hidden;
                color: #2C5F5D;
                font-weight: 600;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            @media (max-width: 575.98px) {
                .project-page.container { padding: 0 12px; }
                .ek-pj-breadcrumb { margin: 20px 0 14px; font-size: 13px; }
            }
        </style>

        <livewire:site.charity-project.show :project="$project" :amount="$amount" />
    </div>
</main>


<script>
    window.dataLayer = window.dataLayer || [];
    dataLayer.push({
      event: 'view_item',
      ecommerce: {
        items: [{
          item_id: @json($project->id),
          item_name: @json($project->transNow?->title),
          item_category: @json($project->categories?->first()?->transNow?->title),
          price: @json((float) $project->price),
        }]
      }
    });
    </script>
    

@endsection
