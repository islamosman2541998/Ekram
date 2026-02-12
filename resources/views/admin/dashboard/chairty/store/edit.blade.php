@extends('admin.app')
@section('title', trans('store.edit_store'))
@section('title_page', trans('store.edit', ['name' => @$store->trans->where('locale', $current_lang)->first()->title]))
@section('style')
<link rel="stylesheet" href="{{ asset('tell/intlTelInput.css') }}" />
@endsection
@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="row">
            <div class="col-12 m-3">
                <div class="row mb-3 text-end">
                    <div>
                        <a href="{{ route('admin.store.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">

                        <form action="{{ route('admin.store.update', $store->id) }}" method="post" enctype="multipart/form-data" id="form-submit">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-md-8">

                                    {{-- Start Info User --}}
                                    <div class="accordion mt-4 mb-4" id="accordionExample">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingTwo5">
                                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo5" aria-expanded="true" aria-controls="collapseTwo5">
                                                    @lang('store.info_user')
                                                </button>
                                            </h2>
                                            <div id="collapseTwo5" class="accordion-collapse collapse show mt-3" aria-labelledby="headingTwo5" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">

                                                    <div class="row">
                                                        <div class="col">
                                                            <!-- Name input -->
                                                            <div class="form-outline">
                                                                <label class="form-label" for="form8Example1">@lang('users.name')</label>
                                                                <input type="text" id="form8Example1" class="form-control @error('full_name') is-invalid @enderror" value="{{ @$store->full_name }}" name="full_name" />

                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <!-- Email input -->
                                                            <div class="form-outline">
                                                                <label class="form-label" for="form8Example2">@lang('users.email')
                                                                </label>
                                                                <input type="email" id="form8Example2" class="form-control @error('email') is-invalid @enderror" value="{{ @$store->email }}" name="email" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <!-- Name input -->
                                                            <div class="form-outline">
                                                                <label class="form-label" for="form8Example3">@lang('users.mobile')</label>
                                                                <div class="iti form-control">
                                                                    <input type="tel" id="phone" name="mobile" class="form-control @error('mobile') is-invalid @enderror " value="{{ old('mobile') }}" style="border:none" />
                                                                </div>
                                                                <span id="valid-msg" class="hide" style="color:green"></span>
                                                                <span id="error-msg" class="hide" style="color:red"></span>
                                                                @error('mobile')
                                                                <span class="text-danger">{{ $message }}</span>
                                                                @enderror

                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <!-- Name input -->
                                                            <div class="form-outline">
                                                                <label class="form-label" for="form8Example4">@lang('users.whatsapp')</label>
                                                                <input type="text" id="form8Example4" class="form-control @error('whatsapp') is-invalid @enderror" value="{{ @$store->whatsapp }}" name="whatsapp" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 mt-1">
                                                            <!-- Email input -->
                                                            <div class="form-outline">
                                                                <label class="form-label" for="form8Example5">@lang('users.password')</label>
                                                                <input type="text" id="form8Example5" name="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" />

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col">
                                                            <!-- Name input -->
                                                            <div class="form-outline">
                                                                <label class="form-label" for="form8Example3">@lang('store.employee_name')</label>
                                                                <input type="text" id="form8Example3" name="employee_name" class="form-control @error('employee_name') is-invalid @enderror" value="{{ @$store->employee_name }}" />

                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <!-- Name input -->
                                                            <div class="form-outline">
                                                                <label class="form-label" for="form8Example4">@lang('store.employee_number')</label>
                                                                <input type="text" id="form8Example4" class="form-control @error('employee_number') is-invalid @enderror" value="{{ @$store->employee_number }}" name="employee_number" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 mt-1">
                                                            <!-- Email input -->
                                                            <div class="form-outline">
                                                                <label class="form-label" for="form8Example5">@lang('store.employee_image')</label>
                                                                <input type="file" id="form8Example5" name="employee_image" class="form-control @error('employee_image') is-invalid @enderror" value="{{ old('employee_image') }}" />

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-6">
                                                            <!-- Name input -->
                                                            <div class="form-outline">
                                                                <label class="form-label" for="form8Example3">@lang('store.department')</label>
                                                                <input type="text" id="form8Example3" name="department" class="form-control @error('department') is-invalid @enderror" value="{{ @$store->department }}" />

                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <!-- Name input -->
                                                            <div class="form-outline">
                                                                <label class="form-label" for="form8Example4">@lang('store.ax_store_number')</label>
                                                                <input type="text" id="form8Example4" class="form-control @error('ax_store_number') is-invalid @enderror" value="{{ @$store->ax_store_number }}" name="ax_store_number" />
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <!-- Name input -->
                                                            <div class="form-outline">
                                                                <label class="form-label" for="form8Example3">@lang('store.jop')</label>
                                                                <input type="text" id="form8Example3" name="jop" class="form-control @error('jop') is-invalid @enderror" value="{{ @$store->jop }}" />

                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <!-- Name input -->
                                                            <div class="form-outline">
                                                                <label class="form-label" for="form8Example4">@lang('store.location')</label>
                                                                <input type="text" id="form8Example4" class="form-control" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ @$store->location }}" />
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- End Info User --}}




                                    @foreach ($languages as $key => $locale)
                                    <div class="accordion mt-4 mb-4" id="accordionExample">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingOne{{ $key }}">
                                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne{{ $key }}" aria-expanded="true" aria-controls="collapseOne{{ $key }}">
                                                    {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                                </button>
                                            </h2>
                                            <div id="collapseOne{{ $key }}" class="accordion-collapse collapse show mt-3" aria-labelledby="headingOne{{ $key }}" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">



                                                    {{-- title ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control" type="text" name="{{ $locale }}[title]" value="{{ @$store->trans->where('locale', $locale)->first()->title }}" id="title{{ $key }}">
                                                        </div>
                                                        @if ($errors->has($locale . '.title'))
                                                        <span class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                                        @endif
                                                    </div>

                                                    {{-- slug ------------------------------------------------------------------------------------- --}}
                                                    {{-- Start Slug --}}
                                                    <div class="row mb-3 slug-section">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.slug_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                        </label>

                                                        <div class="col-sm-10">
                                                            <input type="text" id="slug{{ $key }}" name="{{ $locale }}[slug]" value="{{ @$store->trans->where('locale', $locale)->first()->slug }}" class="form-control slug" required>
                                                            @if ($errors->has($locale . '.slug'))
                                                            <span class="missiong-spam">{{ $errors->first($locale . '.slug') }}</span>
                                                            @endif
                                                        </div>
                                                        @include('admin.layouts.scriptSlug')
                                                        {{-- End Slug --}}


                                                        {{-- description ------------------------------------------------------------------------------------- --}}
                                                        <div class="row mb-3 mt-3">
                                                            <label for="example-text-input" class="col-sm-2 col-form-label"> @lang('admin.description_in')
                                                                {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                                            </label>
                                                            <div class="col-sm-10 mb-2">
                                                                <textarea id="description{{ $key }}" name="{{ $locale }}[description]"> {{ @$store->trans->where('locale', $locale)->first()->description }} </textarea>
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
                                        @endforeach


                                        <div class="accordion mt-4 mb-4" id="accordionExample">
                                            <div class="accordion-item border rounded">
                                                <h2 class="accordion-header" id="headingTwo{{ $key }}">
                                                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo{{ $key }}" aria-expanded="true" aria-controls="collapseTwo{{ $key }}">
                                                        @lang('admin.meta')
                                                    </button>
                                                </h2>
                                                <div id="collapseTwo{{ $key }}" class="accordion-collapse collapse show mt-3" aria-labelledby="headingTwo{{ $key }}" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">

                                                        @foreach ($languages as $key => $locale)
                                                        {{-- meta_title_ ------------------------------------------------------------------------------------- --}}
                                                        <div class="row mb-3">
                                                            <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                            <div class="col-sm-10">
                                                                <input class="form-control" type="text" name="{{ $locale }}[meta_title]" value="{{ @$store->trans->where('locale', $locale)->first()->meta_title }}" id="title{{ $key }}">
                                                            </div>
                                                            @if ($errors->has($locale . '.meta_title'))
                                                            <span class="missiong-spam">{{ $errors->first($locale . '.meta_title') }}</span>
                                                            @endif
                                                        </div>

                                                        {{-- meta_description_ ------------------------------------------------------------------------------------- --}}
                                                        <div class="row mb-3">
                                                            <label for="example-text-input" class="col-sm-2 col-form-label"> @lang('admin.meta_description_in')
                                                                {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                                            </label>
                                                            <div class="col-sm-10 mb-2">
                                                                <textarea name="{{ $locale }}[meta_description]" class="form-control description"> {{ @$store->trans->where('locale', $locale)->first()->meta_description }}</textarea>
                                                                @if ($errors->has($locale . '.meta_description'))
                                                                <span class="missiong-spam">{{ $errors->first($locale . '.meta_description') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        {{-- meta_key_ ------------------------------------------------------------------------------------- --}}
                                                        <div class="row mb-3">
                                                            <label for="example-text-input" class="col-sm-2 col-form-label"> @lang('admin.meta_key_in')
                                                                {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                                            </label>
                                                            <div class="col-sm-10 mb-2">
                                                                <textarea name="{{ $locale }}[meta_key]" class="form-control description"> {{ @$store->trans->where('locale', $locale)->first()->meta_key }}</textarea>
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


                                </div>

                            </div>
                            <div class="col-md-4">
                                {{-- ------ Start Appearance settings------ --}}
                                <div class="accordion mt-4 mb-4" id="accordionExample2">
                                    <div class="accordion-item border rounded">
                                        <h2 class="accordion-header" id="headingOne2">
                                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne2" aria-expanded="true" aria-controls="collapseOne2">
                                                {{ trans('tags.Appearance_settings') }}
                                            </button>
                                        </h2>
                                        <div id="collapseOne2" class="accordion-collapse collapse show" aria-labelledby="headingOne2" data-bs-parent="#accordionExample2">
                                            <div class="accordion-body">
                                                {{-- image ------------------------------------------------------------------------------------- --}}
                                                @if ($store->employee_image != null)
                                                <label for="example-number-input" col-form-label>
                                                    @lang('store.employee_image')</label>
                                                <img src="{{ getImageThumb($store->employee_image) }}" alt="" style="width:100%">
                                                @endif
                                                @if ($store->background_image != null)
                                                <label for="example-number-input" col-form-label>
                                                    @lang('tags.image_background')</label>
                                                <img src="{{ getImageThumb($store->background_image) }}" alt="" style="width:100%">
                                                @endif
                                                {{-- image Background ------------------------------------------------------------------------------------- --}}
                                                <div class="col-12">
                                                    <div class="row mb-3">
                                                        <label for="example-number-input" col-form-label>
                                                            @lang('tags.image_background')</label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" type="file" placeholder="@lang('admin.image')" id="example-number-input" name="background_image" value="{{ old('background_image') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- Color Background ------------------------------------------------------------------------------------- --}}
                                                <div class="col-12">
                                                    <div class="row mb-3">
                                                        <label for="example-number-input" col-form-label>@lang('tags.color_background')
                                                            :</label>
                                                        <input type="text" name="backgeound_color" value="{{ @$store->background_color }}" class="form-control spectrum with-add-on colorpicker-showinput-intial" id="colorpicker-showinput-intial">
                                                    </div>
                                                </div>

                                                {{-- Status ------------------------------------------------------------------------------------- --}}
                                                <div class="col-12">
                                                    <label class="col-sm-12 col-form-label" for="available">{{ trans('admin.status') }}</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-check form-switch" name="status" type="checkbox" {{ @$store->status == 1 ? 'checked' : '' }} id="switch3" switch="success" value="1">
                                                        <label class="form-label" for="switch3" data-on-label=" @lang('admin.yes') " data-off-label=" @lang('admin.no')"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- ------ End Appearance settings------ --}}
                            </div>

                            {{-- Butoooons ------------------------------------------------------------------------- --}}
                            <div class="row mb-3 text-end">
                                <div>
                                    <a href="{{ route('admin.store.index') }}" id="chiledBack" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                                    <button type="submit" id="submit" class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">@lang('button.save')</button>
                                    <button type="submit" name="submit" value="update" class="btn btn-outline-success waves-effect waves-light  btn-sm">@lang('button.save_update')</button>
                                </div>
                            </div>
                    </div>
                    </form>

                </div>
            </div>
        </div> <!-- end col -->
    </div>
</div> <!-- end row-->

</div> <!-- container-fluid -->

@endsection


@section('script')
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ asset('site/js/ckeditor/ckeditor.js') }}"></script>
@endsection
