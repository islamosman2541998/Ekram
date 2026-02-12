@extends('admin.app')

@section('title', trans('vendor.create_vendor'))
@section('title_page', trans('vendor.vendors'))
@section('title_route', route('admin.eccommerce.vendors.index') )
@section('button_page')
<a href="{{ route('admin.eccommerce.vendors.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3">@lang('button.cancel')</a>
@endsection

@section('style')
@livewireStyles
<link rel="stylesheet" href="{{ asset('tell/intlTelInput.css') }}" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ asset('site/js/ckeditor/ckeditor.js') }}"></script>
@endsection


@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.eccommerce.vendors.store') }}" method="post" enctype="multipart/form-data" id="form-submit">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    {{-- Start Info User --}}
                    <div class="mt-4 mb-4 accordion" id="accordionAccount">
                        <div class="border rounded accordion-item">
                            <h2 class="accordion-header" id="headingAccount">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAccount" aria-expanded="true" aria-controls="collapseAccount">
                                    @lang('vendor.info_vendor')
                                </button>
                            </h2>
                            <div id="collapseAccount" class="mt-3 accordion-collapse collapse show" aria-labelledby="headingAccount" data-bs-parent="#accordionAccount">
                                <div class="accordion-body">
                                    <livewire:admin.accounts.create />
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Start Info User --}}
                    <div class="mt-4 mb-4 accordion" id="accordionInfoStore">
                        <div class="border rounded accordion-item">
                            <h2 class="accordion-header" id="headingInfoStore">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInfoStore" aria-expanded="true" aria-controls="collapseInfoStore">
                                    @lang('vendor.info_vendor')
                                </button>
                            </h2>
                            <div id="collapseInfoStore" class="mt-3 accordion-collapse collapse show" aria-labelledby="headingInfoStore" data-bs-parent="#accordionInfoStore">

                                <div class="accordion-body">

                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <!-- Name input -->
                                            <div class="form-outline">
                                                <label class="form-label" for="form8Example1">@lang('users.name')</label>
                                                <input type="text" id="form8Example1" class="form-control @error('responsible_person') is-invalid @enderror" value="{{ old('responsible_person') }}" name="responsible_person" />
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <!-- Email input -->
                                            <div class="form-outline">
                                                <label class="form-label" for="form8Example5">@lang('users.image')</label>
                                                <input type="file" id="form8Example5" name="logo" class="form-control @error('logo') is-invalid @enderror" value="{{ old('logo') }}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End Store --}}
                    @foreach ($languages as $key => $locale)
                    <div class="mt-4 mb-4 accordion" id="accordionStore">
                        <div class="border rounded accordion-item">
                            <h2 class="accordion-header" id="headingOne{{ $key }}">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne{{ $key }}" aria-expanded="true" aria-controls="collapseOne{{ $key }}">
                                    {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                </button>
                            </h2>
                            <div id="collapseOne{{ $key }}" class="mt-3 accordion-collapse collapse " aria-labelledby="headingOne{{ $key }}" data-bs-parent="#accordionStore">
                                <div class="accordion-body">
                                    {{-- title ------------------------------------------------------------------------------------- --}}
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="{{ $locale }}[title]" value="{{ old($locale . '.title') }}" id="title{{ $key }}">
                                        </div>
                                        @if ($errors->has($locale . '.title'))
                                        <span class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                        @endif
                                    </div>

                                    {{-- Start Slug --}}
                                    <div class="mb-3 row slug-section">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.slug_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                        </label>

                                        <div class="col-sm-10">
                                            <input type="text" id="slug{{ $key }}" name="{{ $locale }}[slug]" value="{{ old($locale . '.slug') }}" class="form-control slug" required>
                                            @if ($errors->has($locale . '.slug'))
                                            <span class="missiong-spam">{{ $errors->first($locale . '.slug') }}</span>
                                            @endif
                                        </div>
                                        @include('admin.layouts.scriptSlug')
                                        {{-- End Slug --}}


                                        {{-- description ------------------------------------------------------------------------------------- --}}
                                        <div class="mt-3 mb-3 row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label"> @lang('admin.description_in')
                                                {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                            </label>
                                            <div class="mb-2 col-sm-10">
                                                <textarea id="description{{ $key }}" name="{{ $locale }}[description]"> {{ old($locale . '.description') }} </textarea>
                                                @if ($errors->has($locale . '.description'))
                                                <span class="missiong-spam">{{ $errors->first($locale . '.description') }}</span>
                                                @endif
                                            </div>

                                            <script type="text/javascript">
                                                CKEDITOR.replace('description{{ $key }}', {
                                                    filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}"
                                                    , filebrowserUploadMethod: 'form'
                                                });

                                            </script>
                                        </div>



                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach


                    <div class="mt-4 mb-4 accordion" id="accordionMeta">
                        <div class="border rounded accordion-item">
                            <h2 class="accordion-header" id="headingMeta{{ $key }}">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMeta{{ $key }}" aria-expanded="true" aria-controls="collapseMeta{{ $key }}">
                                    @lang('admin.meta')
                                </button>
                            </h2>
                            <div id="collapseMeta{{ $key }}" class="mt-3 accordion-collapse collapse " aria-labelledby="headingMeta{{ $key }}" data-bs-parent="#accordionMeta">
                                <div class="accordion-body">

                                    @foreach ($languages as $key => $locale)
                                    {{-- meta_title_ ------------------------------------------------------------------------------------- --}}
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="{{ $locale }}[meta_title]" value="{{ old($locale . '.meta_title') }}" id="title{{ $key }}">
                                        </div>
                                        @if ($errors->has($locale . '.meta_title'))
                                        <span class="missiong-spam">{{ $errors->first($locale . '.meta_title') }}</span>
                                        @endif
                                    </div>

                                    {{-- meta_description_ ------------------------------------------------------------------------------------- --}}
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label"> @lang('admin.meta_description_in')
                                            {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                        </label>
                                        <div class="mb-2 col-sm-10">
                                            <textarea name="{{ $locale }}[meta_description]" class="form-control description"> {{ old($locale . '.meta_description') }} </textarea>
                                            @if ($errors->has($locale . '.meta_description'))
                                            <span class="missiong-spam">{{ $errors->first($locale . '.meta_description') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- meta_key_ ------------------------------------------------------------------------------------- --}}
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label"> @lang('admin.meta_key_in')
                                            {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                        </label>
                                        <div class="mb-2 col-sm-10">
                                            <textarea name="{{ $locale }}[meta_key]" class="form-control description"> {{ old($locale . '.meta_key') }} </textarea>
                                            @if ($errors->has($locale . '.meta_key'))
                                            <span class="missiong-spam">{{ $errors->first($locale . '.meta_key') }}</span>
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
                    {{-- ------ Start Appearance settings------ --}}
                    <div class="mt-4 mb-4 accordion" id="accordionSettings">
                        <div class="border rounded accordion-item">
                            <h2 class="accordion-header" id="headingSettings">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSettings" aria-expanded="true" aria-controls="collapseSettings">
                                    {{ trans('tags.Appearance_settings') }}
                                </button>
                            </h2>
                            <div id="collapseSettings" class="accordion-collapse  " aria-labelledby="headingSettings" data-bs-parent="#accordionSettings">
                                <div class="accordion-body">
                                    {{-- sort ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12">
                                        <div class="mb-3 row">
                                            <label for="example-number-input" col-form-label>
                                                @lang('articles.sort')</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="number" placeholder="@lang('articles.sort')" id="example-number-input" name="sort" value="{{ old('sort') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        {{-- feature ------------------------------------------------------------------------------------- --}}
                                        <div class="col-6">
                                            <label class="col-sm-6 col-form-label" for="available">{{ trans('admin.feature') }}</label>
                                            <div class="col-sm-10">
                                                <div class="form-check form-switch form-check-success">
                                                    <input class="form-check-input" type="checkbox" role="switch" name="feature" {{  request('status') == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessfeature">
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Status ------------------------------------------------------------------------------------- --}}
                                        <div class="col-6">
                                            <label class="col-sm-6 col-form-label" for="available">{{ trans('admin.status') }}</label>
                                            <div class="col-sm-10">
                                                <div class="form-check form-switch form-check-success">
                                                    <input class="form-check-input" type="checkbox" role="switch" name="status" {{  request('status') == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessStatus">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- ------ End Appearance settings------ --}}
                </div>
            </div>

            {{-- Butoooons ------------------------------------------------------------------------- --}}
            <div class="mb-3 row text-end">
                <div>
                    <a href="{{ route('admin.eccommerce.vendors.index') }}" id="chiledBack" class="ml-3 btn btn-outline-primary waves-effect waves-light btn-sm">@lang('button.cancel')</a>
                    <button id="submit" type="submit" class="ml-3 btn btn-outline-success waves-effect waves-light btn-sm">@lang('button.save')</button>
                    <button type="submit" name="submit" value="new" id="submit" class="btn btn-outline-success waves-effect waves-light btn-sm">@lang('button.save_new')</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection



@section('script')
@livewireScripts
<script src="{{ asset('tell/intlTelInput.js') }}"></script>
<script>
    var input = document.querySelector("#phone");
    var validMsg = document.querySelector("#valid-msg");
    var errorMsg = document.querySelector("#error-msg");
    var buttonSbmit = document.getElementById("submit");
    var errorMap = [`{{ trans('admin.Invalid_number') }}`, `{{ trans('admin.Invalid_country_code') }}`
        , `{{ trans('admin.Too_short') }}`, `{{ trans('admin.Too_long') }}`
    ];
    var iti = window.intlTelInput(input, {
        initialCountry: "auto"
        , geoIpLookup: function(callback) {
            $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
                var countryCode = (resp && resp.country) ? resp.country : "";
                callback(countryCode);
            });
        }
        , utilsScript: "{{ asset('tell/utils.js') }}"

    , });
    var reset = function() {
        input.classList.remove("error");
        errorMsg.innerHTML = "";
        errorMsg.classList.add("hide");
        validMsg.classList.add("hide");
    }
    input.addEventListener('blur', function() {
        reset();
        if (input.value.trim()) {
            if (iti.isValidNumber()) {
                validMsg.classList.remove('hide');
                validMsg.innerHTML = `{{ trans('admin.valid') }}`;

                buttonSbmit.removeAttribute("disabled", "");
            } else {
                input.classList.add('error');
                var errorCode = iti.getValidationError();
                errorMsg.innerHTML = errorMap[errorCode];
                errorMsg.classList.remove("hide");
                validMsg.innerHTML = "";
                buttonSbmit.setAttribute("disabled", "true");
            }
        }
    });
    input.addEventListener('change', reset);
    input.addEventListener("keyup", reset);

</script>
@endsection
