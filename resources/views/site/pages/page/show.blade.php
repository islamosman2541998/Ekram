@extends('site.app')

@section('title', @$page->trans->where('locale', $current_lang)->first()->meta_title)
@section('meta_key', @$page->trans->where('locale', $current_lang)->first()->meta_key)
@section('meta_description', @$page->trans->where('locale', $current_lang)->first()->meta_description)


@section('content')




    <main>
        <div class="hawkama-container">
            <div class="hawkama-content">
                <div class="row">

                    <div class="col-md-12 col-lg-12 governance-sections">

                        <div class="governance-section">
                            <h2 class="section-title"> {{ $page->title }}</h2>
                            <p>{!! $page->content !!}</p>
                        </div>
                        <div class="logo-section w-100 text-center">
                            @if ($page->image)
                                @if (str_ends_with($page->image, '.pdf'))
                                    <a href="{{ getImage($page->image) }}" target="_blank" class="btn btn-primary">
                                        <i class="fa fa-file-pdf"></i> {{ basename($page->image) }}
                                    </a>
                                @else
                                    <img src="{{ getImage($page->image) }}" alt="{{ $page->title }}" class="">
                                @endif
                            @endif
                        </div>

                    </div>




                </div>
            </div>
        </div>
    </main>



@endsection
