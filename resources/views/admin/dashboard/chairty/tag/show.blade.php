@extends('admin.app')

@section('title', trans('tags.show'))
@section('title_page', trans('tags.tags'))
@section('title_route', route('admin.charity.tag.index') )
@section('button_page')
<a href="{{ route('admin.charity.tag.index') }}" class="btn btn-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection


@section('content')


<div class="card">
    <div class="card-body">

        <form action="{{ route('admin.tag.update',$tag->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="row">
                <div class="col-md-8">
                    @foreach ($languages as $key => $locale)
                    <div class="mt-4 mb-4 accordion" id="accordionExampleTitle{{ $key }}">
                        <div class="border rounded accordion-item">
                            <h2 class="accordion-header" id="headingTitle{{ $key }}">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTitle{{ $key }}" aria-expanded="true" aria-controls="collapseTitle{{ $key }}">
                                    {{ trans('lang.' .Locale::getDisplayName($locale)) }}
                                </button>
                            </h2>
                            <div id="collapseTitle{{ $key }}" class="mt-3 accordion-collapse collapse show" aria-labelledby="headingTitle{{ $key }}" data-bs-parent="#accordionExampleTitle{{ $key }}">
                                <div class="accordion-body">
                                    {{-- title ------------------------------------------------------------------------------------- --}}
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-sm-3 col-form-label">{{ trans('admin.title_in') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="{{ $locale }}[title]" disabled value="{{ $tag->trans->where('locale',$locale)->first()->title }}" id="title{{ $key }}">
                                        </div>
                                    </div>
                                    {{-- slug ------------------------------------------------------------------------------------- --}}
                                    <div class="mb-3 row slug-section">
                                        <label for="example-text-input" class="col-sm-3 col-form-label">{{ trans('admin.slug_in') .  trans('lang.' .Locale::getDisplayName($locale))}}</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="{{ $locale }}[slug]" disabled value="{{ $tag->trans->where('locale',$locale)->first()->slug}}" id="slug{{ $key }}" class="form-control slug" required>
                                        </div>
                                    </div>
                                    {{-- description ------------------------------------------------------------------------------------- --}}
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-sm-12 col-form-label"> @lang('admin.description_in') {{ trans('lang.' .Locale::getDisplayName($locale))}} </label>
                                        <div class="mb-2 col-sm-12">
                                            <p>{!! $tag->trans->where('locale',$locale)->first()->description !!}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="mt-4 mb-4 accordion" id="accordionExampleMeta">
                        <div class="border rounded accordion-item">
                            <h2 class="accordion-header" id="headingMeta{{ $key }}">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMeta{{ $key }}" aria-expanded="true" aria-controls="collapseMeta{{ $key }}">
                                    @lang('admin.meta')
                                </button>
                            </h2>
                            <div id="collapseMeta{{ $key }}" class="mt-3 accordion-collapse collapse" aria-labelledby="headingMeta{{ $key }}" data-bs-parent="#accordionExampleMeta">
                                <div class="accordion-body">

                                    @foreach ($languages as $key => $locale)
                                    {{-- meta_title_ ------------------------------------------------------------------------------------- --}}
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') .  trans('lang.' .Locale::getDisplayName($locale))}}</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="{{ $locale }}[meta_title]" disabled value="{{$tag->trans->where('locale',$locale)->first()->meta_title  }}" id="title{{ $key }}">
                                        </div>
                                        @if($errors->has( $locale . '.meta_title'))
                                        <span class="missiong-spam">{{ $errors->first( $locale . '.meta_title') }}</span>
                                        @endif
                                    </div>
                                    {{-- meta_description_ ------------------------------------------------------------------------------------- --}}
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label"> @lang('admin.meta_description_in') {{ trans('lang.' .Locale::getDisplayName($locale))}} </label>
                                        <div class="mb-2 col-sm-10">
                                            <textarea name="{{ $locale }}[meta_description]" class="form-control description" disabled> {{ $tag->trans->where('locale',$locale)->first()->meta_description }} </textarea>
                                            @if($errors->has( $locale . '.meta_description'))
                                            <span class="missiong-spam">{{ $errors->first( $locale . '.meta_description') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- meta_key_ ------------------------------------------------------------------------------------- --}}
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label"> @lang('admin.meta_key_in') {{ trans('lang.' .Locale::getDisplayName($locale))}} </label>
                                        <div class="mb-2 col-sm-10">
                                            <textarea name="{{ $locale }}[meta_key]" class="form-control description" disabled> {{ $tag->trans->where('locale',$locale)->first()->meta_key }} </textarea>
                                            @if($errors->has( $locale . '.meta_key'))
                                            <span class="missiong-spam">{{ $errors->first( $locale . '.meta_key') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-4">
                    {{-- ------ Start Post Settings------ --}}
                    <div class="mt-4 mb-4 accordion" id="accordionExampleSetting">
                        <div class="border rounded accordion-item">
                            <h2 class="accordion-header" id="headingSetting">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSetting" aria-expanded="true" aria-controls="collapseSetting">
                                    {{ trans('tags.Post_settings') }}
                                </button>
                            </h2>
                            <div id="collapseSetting" class="accordion-collapse collapse show" aria-labelledby="headingSetting" data-bs-parent="#accordionExampleSetting">
                                <div class="accordion-body">
                                    <div class="col-12">
                                        <div class="mb-3 row">
                                            <div class="col-sm-12">
                                                <a href="{{ getImage($tag->image) }}" target="_blank">
                                                    <img src="{{getImageThumb( $tag->image)}}" alt="" style="width:75%">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- image ------------------------------------------------------------------------------------- --}}

                                    {{-- sort ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label for="example-number-input" class="col-md-6"> @lang('categories.sort')</label>
                                            <span class="col-md-6">{{ @$tag->sort  }}</span>
                                        </div>
                                    </div>


                                    {{-- feature ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12 mb-3">
                                        <label for="example-number-input" class="col-md-6"> {{ trans('admin.feature') }}</label>
                                        @if($tag->feature == 1 )
                                        <span class="badge bg-success">@lang("admin.yes")</span>
                                        @else
                                        <span class="badge bg-danger">@lang("admin.no")</span>
                                        @endif
                                    </div>
                                    {{-- Status ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12 mb-3">
                                        <label for="example-number-input" class="col-md-6"> {{ trans('admin.status') }}</label>
                                        @if($tag->status == 1 )
                                        <span class="badge bg-success">@lang("admin.active")</span>
                                        @else
                                        <span class="badge bg-danger">@lang("admin.dis_active")</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- ------ End Post Settings------ --}}

                </div>
            </div>
        </form>
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

