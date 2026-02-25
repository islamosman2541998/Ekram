@extends('admin.app')

@section('title', trans('admin.about'))
@section('title_page', trans('admin.about'))
@section('title_route', route('admin.about.index'))

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('admin.about.update') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="row">
                <div class="col-md-8">

                    @foreach ($languages as $key => $locale)
                    <div class="accordion mt-4 mb-4" id="accordionAbout{{ $key }}">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingAbout{{ $key }}">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAbout{{ $key }}" aria-expanded="true" aria-controls="collapseAbout{{ $key }}">
                                    @lang('admin.about') - {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                </button>
                            </h2>
                            <div id="collapseAbout{{ $key }}" class="accordion-collapse collapse show mt-3" aria-labelledby="headingAbout{{ $key }}" data-bs-parent="#accordionAbout{{ $key }}">
                                <div class="accordion-body">

                                    {{-- title --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-12 col-form-label">{{ trans('admin.title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                        <div class="col-sm-12">
                                            <input class="form-control" type="text" name="{{ $locale }}[title]" value="{{ @$about?->trans->where('locale', $locale)->first()->title }}">
                                        </div>
                                        @if ($errors->has($locale . '.title'))
                                        <span class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                        @endif
                                    </div>

                                    {{-- description --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-12 col-form-label">{{ trans('admin.description_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                        <div class="col-sm-12 mb-2">
                                            <textarea id="description{{ $key }}" name="{{ $locale }}[description]" class="form-control" rows="5">{{ @$about?->trans->where('locale', $locale)->first()->description }}</textarea>
                                            @if ($errors->has($locale . '.description'))
                                            <span class="missiong-spam">{{ $errors->first($locale . '.description') }}</span>
                                            @endif
                                        </div>
                                        <script type="text/javascript">
                                            CKEDITOR.replace('description{{ $key }}', {
                                                filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
                                                filebrowserUploadMethod: 'form'
                                            });
                                        </script>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    @foreach ($languages as $key => $locale)
                    <div class="accordion mt-4 mb-4" id="accordionMission{{ $key }}">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingMission{{ $key }}">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMission{{ $key }}" aria-expanded="true" aria-controls="collapseMission{{ $key }}">
                                    @lang('admin.mission') - {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                </button>
                            </h2>
                            <div id="collapseMission{{ $key }}" class="accordion-collapse collapse mt-3" aria-labelledby="headingMission{{ $key }}" data-bs-parent="#accordionMission{{ $key }}">
                                <div class="accordion-body">

                                    {{-- mission_title --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-12 col-form-label">{{ trans('admin.mission_title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                        <div class="col-sm-12">
                                            <input class="form-control" type="text" name="{{ $locale }}[mission_title]" value="{{ @$about?->trans->where('locale', $locale)->first()->mission_title }}">
                                        </div>
                                        @if ($errors->has($locale . '.mission_title'))
                                        <span class="missiong-spam">{{ $errors->first($locale . '.mission_title') }}</span>
                                        @endif
                                    </div>

                                    {{-- mission_description --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-12 col-form-label">{{ trans('admin.mission_description_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                        <div class="col-sm-12 mb-2">
                                            <textarea id="mission_description{{ $key }}" name="{{ $locale }}[mission_description]" class="form-control" rows="5">{{ @$about?->trans->where('locale', $locale)->first()->mission_description }}</textarea>
                                            @if ($errors->has($locale . '.mission_description'))
                                            <span class="missiong-spam">{{ $errors->first($locale . '.mission_description') }}</span>
                                            @endif
                                        </div>
                                        <script type="text/javascript">
                                            CKEDITOR.replace('mission_description{{ $key }}', {
                                                filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
                                                filebrowserUploadMethod: 'form'
                                            });
                                        </script>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    @foreach ($languages as $key => $locale)
                    <div class="accordion mt-4 mb-4" id="accordionVision{{ $key }}">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingVision{{ $key }}">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseVision{{ $key }}" aria-expanded="true" aria-controls="collapseVision{{ $key }}">
                                    @lang('admin.vision') - {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                </button>
                            </h2>
                            <div id="collapseVision{{ $key }}" class="accordion-collapse collapse mt-3" aria-labelledby="headingVision{{ $key }}" data-bs-parent="#accordionVision{{ $key }}">
                                <div class="accordion-body">

                                    {{-- vision_title --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-12 col-form-label">{{ trans('admin.vision_title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                        <div class="col-sm-12">
                                            <input class="form-control" type="text" name="{{ $locale }}[vision_title]" value="{{ @$about?->trans->where('locale', $locale)->first()->vision_title }}">
                                        </div>
                                        @if ($errors->has($locale . '.vision_title'))
                                        <span class="missiong-spam">{{ $errors->first($locale . '.vision_title') }}</span>
                                        @endif
                                    </div>

                                    {{-- vision_description --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-12 col-form-label">{{ trans('admin.vision_description_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                        <div class="col-sm-12 mb-2">
                                            <textarea id="vision_description{{ $key }}" name="{{ $locale }}[vision_description]" class="form-control" rows="5">{{ @$about?->trans->where('locale', $locale)->first()->vision_description }}</textarea>
                                            @if ($errors->has($locale . '.vision_description'))
                                            <span class="missiong-spam">{{ $errors->first($locale . '.vision_description') }}</span>
                                            @endif
                                        </div>
                                        <script type="text/javascript">
                                            CKEDITOR.replace('vision_description{{ $key }}', {
                                                filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
                                                filebrowserUploadMethod: 'form'
                                            });
                                        </script>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    @foreach ($languages as $key => $locale)
                    <div class="accordion mt-4 mb-4" id="accordionValues{{ $key }}">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingValues{{ $key }}">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseValues{{ $key }}" aria-expanded="true" aria-controls="collapseValues{{ $key }}">
                                    @lang('admin.values') - {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                </button>
                            </h2>
                            <div id="collapseValues{{ $key }}" class="accordion-collapse collapse mt-3" aria-labelledby="headingValues{{ $key }}" data-bs-parent="#accordionValues{{ $key }}">
                                <div class="accordion-body">

                                    {{-- values_title --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-12 col-form-label">{{ trans('admin.values_title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                        <div class="col-sm-12">
                                            <input class="form-control" type="text" name="{{ $locale }}[values_title]" value="{{ @$about?->trans->where('locale', $locale)->first()->values_title }}">
                                        </div>
                                        @if ($errors->has($locale . '.values_title'))
                                        <span class="missiong-spam">{{ $errors->first($locale . '.values_title') }}</span>
                                        @endif
                                    </div>

                                    {{-- values_description --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-12 col-form-label">{{ trans('admin.values_description_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                        <div class="col-sm-12 mb-2">
                                            <textarea id="values_description{{ $key }}" name="{{ $locale }}[values_description]" class="form-control" rows="5">{{ @$about?->trans->where('locale', $locale)->first()->values_description }}</textarea>
                                            @if ($errors->has($locale . '.values_description'))
                                            <span class="missiong-spam">{{ $errors->first($locale . '.values_description') }}</span>
                                            @endif
                                        </div>
                                        <script type="text/javascript">
                                            CKEDITOR.replace('values_description{{ $key }}', {
                                                filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
                                                filebrowserUploadMethod: 'form'
                                            });
                                        </script>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>

                <div class="col-md-4">
                    <div class="accordion mt-4 mb-4" id="accordionImages">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingImages">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseImages" aria-expanded="true" aria-controls="collapseImages">
                                    @lang('admin.images')
                                </button>
                            </h2>
                            <div id="collapseImages" class="accordion-collapse collapse show" aria-labelledby="headingImages" data-bs-parent="#accordionImages">
                                <div class="accordion-body">

                                    <div class="col-12 mb-4">
                                        <label class="col-form-label fw-bold">@lang('admin.about_image')</label>
                                        @if (@$about?->image)
                                        <div class="mb-2">
                                            <a href="{{ getImage($about->image) }}" target="_blank">
                                                <img src="{{ getImageThumb($about->image) }}" alt="" style="width:100%">
                                            </a>
                                        </div>
                                        @endif
                                        <input class="form-control" type="file" name="image">
                                    </div>

                                    <hr>

                                    {{-- <div class="col-12 mb-4">
                                        <label class="col-form-label fw-bold">@lang('admin.mission_image')</label>
                                        @if (@$about?->mission_image)
                                        <div class="mb-2">
                                            <a href="{{ getImage($about->mission_image) }}" target="_blank">
                                                <img src="{{ getImageThumb($about->mission_image) }}" alt="" style="width:100%">
                                            </a>
                                        </div>
                                        @endif
                                        <input class="form-control" type="file" name="mission_image">
                                    </div>

                                    <hr>

                                    <div class="col-12 mb-4">
                                        <label class="col-form-label fw-bold">@lang('admin.vision_image')</label>
                                        @if (@$about?->vision_image)
                                        <div class="mb-2">
                                            <a href="{{ getImage($about->vision_image) }}" target="_blank">
                                                <img src="{{ getImageThumb($about->vision_image) }}" alt="" style="width:100%">
                                            </a>
                                        </div>
                                        @endif
                                        <input class="form-control" type="file" name="vision_image">
                                    </div>

                                    <hr>

                                    <div class="col-12 mb-4">
                                        <label class="col-form-label fw-bold">@lang('admin.values_image')</label>
                                        @if (@$about?->values_image)
                                        <div class="mb-2">
                                            <a href="{{ getImage($about->values_image) }}" target="_blank">
                                                <img src="{{ getImageThumb($about->values_image) }}" alt="" style="width:100%">
                                            </a>
                                        </div>
                                        @endif
                                        <input class="form-control" type="file" name="values_image">
                                    </div> --}}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ==================== أزرار الحفظ ==================== --}}
                <div class="row mb-3 text-end">
                    <div>
                        <button type="submit" class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">
                            <i class="fa fa-save"></i> @lang('button.save')
                        </button>
                    </div>
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