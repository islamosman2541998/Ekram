@extends('admin.app')

@section('title', trans('sections.show'))
@section('title_page', trans('sections.sections'))
@section('title_route', route('admin.charity.sections.index') )
@section('button_page')
<a href="{{ route('admin.charity.sections.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3">@lang('button.cancel')</a>
@endsection


@section('content')

<div class="card">
    <div class="card-body">


        <div class="row">
            <div class="col-md-9">
                @foreach ($languages as $key => $locale)
                <div class="accordion mt-4 mb-4" id="accordionExample{{ $key }}">
                    <div class="accordion-item border rounded">
                        <h2 class="accordion-header" id="headingTitle{{ $key }}">
                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTitle{{ $key }}" aria-expanded="true" aria-controls="collapseTitle{{ $key }}">
                                {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                            </button>
                        </h2>
                        <div id="collapseTitle{{ $key }}" class="accordion-collapse collapse show mt-3" aria-labelledby="headingTitle{{ $key }}" data-bs-parent="#accordionExample{{ $key }}">
                            <div class="accordion-body">

                                {{-- title ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" name="{{ $locale }}[title]" value="{{ @$item->trans->where('locale',$locale)->first()->title}}" id="title{{ $key }}" disabled>
                                    </div>
                                </div>

                                {{-- slug ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3 slug-section">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.slug_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                    </label>

                                    <div class="col-sm-10">
                                        <input type="text" id="slug{{ $key }}" name="{{ $locale }}[slug]" value="{{ @$item->trans->where('locale',$locale)->first()->slug}}" class="form-control slug" required disabled>
                                    </div>
                                </div>
                                {{-- End Slug --}}


                                {{-- description ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-12 col-form-label">
                                        {{ trans('admin.description_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                    </label>
                                    <div class="col-sm-12 mt-2">
                                        <p>{!! @$item->trans->where('locale',$locale)->first()->description !!}</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

             
            </div>

            <div class="col-md-3">
                <div class="accordion mt-4 mb-4" id="accordionExampleSetting">
                    <div class="accordion-item border rounded">
                        <h2 class="accordion-header" id="headingSetting">
                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSetting" aria-expanded="true" aria-controls="collapseSetting">
                                {{ trans('admin.settings') }}
                            </button>
                        </h2>
                        <div id="collapseSetting" class="accordion-collapse collapse show" aria-labelledby="headingSetting" data-bs-parent="#accordionExampleSetting">
                            <div class="accordion-body">
                                {{-- parent Category ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="example-number-input" class="col-md-6"> @lang('categories.parent')</label>
                                        <div class="row">
                                            @forelse($item->categories as $key => $category)
                                                <span class="badge bg-primary m-1 col-md-2">{{  @$category->trans->where('locale',$current_lang)->first()->title }} </span>
                                            @empty
                                                ___
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                  

                                {{-- sort ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="example-number-input" class="col-md-6"> @lang('categories.sort')</label>
                                        <span class="col-md-6">{{ @$item->sort  }}</span>
                                    </div>
                                </div>

                                {{-- Status ------------------------------------------------------------------------------------- --}}
                                <div class="col-12 mb-3">
                                    <label for="example-number-input" class="col-md-6"> {{ trans('admin.status') }}</label>
                                    @if($item->status == 1 )
                                    <span class="badge bg-success">@lang("admin.active")</span>
                                    @else
                                    <span class="badge bg-danger">@lang("admin.dis_active")</span>
                                    @endif
                                </div>

                                {{-- feature ------------------------------------------------------------------------------------- --}}
                                <div class="col-12 mb-3">
                                    <label for="example-number-input" class="col-md-6"> {{ trans('admin.feature') }}</label>
                                    @if($item->feature == 1 )
                                    <span class="badge bg-success">@lang("admin.yes")</span>
                                    @else
                                    <span class="badge bg-danger">@lang("admin.no")</span>
                                    @endif
                                </div>

                                {{-- image ------------------------------------------------------------------------------------- --}}
                                <div class="col-12">
                                    <div class="row mb-3">
                                        <div class="col-sm-12">
                                            <a href="{{ getImage( $item->image) }}" target="_blank">
                                                <img src="{{ getImageThumb( $item->image ) }}" alt="" style="width:100%">
                                            </a>
                                        </div>
                                    </div>
                                </div>




                                {{-- Background Image ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="example-number-input"> @lang('admin.background_image')</label>
                                        <div class="col-12 mt-3">
                                            <a href="{{ getImage( $item->background_image) }}" target="_blank">
                                                <img src="{{ getImageThumb( $item->background_image ) }}" alt="" style="width:100%">
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                {{-- Butoooons ------------------------------------------------------------------------- --}}
                <div class="row mb-3 text-end">
                    <div>
                        <a href="{{ route('admin.charity.sections.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3">@lang('button.cancel')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection


    @section('style')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('site/js/ckeditor/ckeditor.js') }}"></script>
    @endsection


@section('script')
    <script src="{{ asset('backend/js/spectrum.js') }}"></script>
    <script src="{{ asset('backend/js/select2.js') }}"></script>
    <script src="{{ asset('backend/js/form-advanced.js') }}"></script>
    <script type="text/javascript">
        colorPicker.select();
    </script>
@endsection