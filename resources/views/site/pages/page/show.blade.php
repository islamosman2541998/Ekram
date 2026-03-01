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
                                    <img src="{{ getImage($page->image) }}" alt="{{ $page->title }}">
                                @endif
                            @endif

                             @if ($page->files)
                            <div class="row mt-4">
                                @foreach ($page->files as $file)
                                    @if (str_ends_with($file, '.pdf'))
                                        <div class="col-md-4 mb-3">
                                            <a href="{{ getImage($file) }}" target="_blank"
                                                class="btn btn-outline-primary w-100">
                                                <i class="fa fa-file-pdf"></i> {{ basename($file) }}
                                            </a>
                                        </div>
                                    @else
                                        <div class="col-md-4 mb-3" style="width:auto;">
                                            <a href="{{ getImage($file) }}" target="_blank">
                                                <img src="{{ getImage($file) }}" alt="" class="img-fluid rounded w-50 h-50"
                                                    style="width:100%; object-fit:cover;">
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                        </div>

                    </div>




                </div>
            </div>
        </div>
    </main>



@endsection
<style>
  @media (min-width: 768px) {
    .col-md-4 {
        flex: 0 0 auto;
        width: auto !important;
    }
}
</style>