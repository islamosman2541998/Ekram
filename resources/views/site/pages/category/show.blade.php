@extends('site.app')

@section('title', @$category->transNow->meta_title)
@section('meta_key', @$category->transNow->meta_key)
@section('meta_description', @$category->transNow->meta_description)

@section('content')

<main>
  <section class="programs-section py-5" dir="rtl">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="fw-bold fs-1 main-font mb-3">
                {{ @$category->trans->first()->title }}
            </h1>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-4">
                <a href="{{ route('site.projectCategories.show', $category->transNow->slug) }}"
                    class="text-decoration-none">
                    <div class="program-card h-100">
                        <div class="program-card-img">
                            @if ($category->background_image)
                                <img src="{{ asset(getImage($category->background_image) ?? 'site/img/icon3.png') }}"
                                    class="img-fluid" alt="{{ @$category->trans->first()->title }}">
                            @endif
                        </div>
                        <div class="program-card-body" style="background-color: #469e8d;">
                            <div class="program_title">
                                <h1 class="program-card-title fw-bold mb-3 main-font">
                                    {{ @$category->trans->first()->title }}
                                </h1>
                                <img src="{{ asset('img/3 (4).png') }}" class="programImg">
                            </div>
                            <div class="programP">
                                <p class="mb-0 desc_P second-font">
                                    {!! @$category->trans->first()->description !!}
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

    <section class="RamdanProjects mt-2">
        <div class="container pb-2 text-center">
            <h2> {!! @$category->trans->first()->description !!} </h2>

            @livewire('site.charity-category.show', ['category' => $category])

        </div>
    </section>

</main>
@endsection
