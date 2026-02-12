@extends('admin.app')

@section('title', trans('manager.create_manager'))
@section('title_page', trans('manager.managers'))
@section('title_route', route('admin.charity.managers.index'))
@section('button_page')
<a href="{{ route('admin.charity.managers.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection

@section('style')
@livewireStyles
<link rel="stylesheet" href="{{ asset('tell/intlTelInput.css') }}" />
@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.charity.managers.store') }}" method="post" enctype="multipart/form-data" id="form-submit">
            @csrf
            <div class="row d-flex justify-content-center ">
                <div class="col-md-6 col-12 p-3">
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
                                    <livewire:admin.accounts.create  />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-12 p-3">

                    <div class="accordion mt-4 mb-4 " id="accordionExampleInfo">
                        <div class="accordion-item border rounded ">
                            <h2 class="accordion-header" id="headingInfo">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInfo" aria-expanded="true" aria-controls="collapseInfo">
                                    {{ trans('manager.info_manager') }}
                                </button>
                            </h2>
                            <div id="collapseInfo" class="accordion-collapse collapse show mt-3" aria-labelledby="headingInfo" data-bs-parent="#accordionExampleInfo">
                                <div class="accordion-body">
                                    <div class="row mb-3">
                                        <div class="col-sm-12">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">{{ trans('manager.name') }}</label>
                                            <div class="col-sm-10">
                                                <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name') }}">
                                                @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- status ------------------------------------------------------------------------------------- --}}
                                        <div class="col-sm-12 mt-3">
                                            <label class="form-check-label" for="flexSwitchCheckSuccessStatus">@lang('admin.status')</label>
                                            <div class="form-check form-switch form-check-success">
                                                <input class="form-check-input {{ empty($errors->first('status')) ?: 'has-error' }}" type="checkbox" role="switch" name="status" {{ request('status') == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessStatus">
                                                @if ($errors->has('status'))
                                                <span class="missiong-spam">{{ $errors->first('status') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                                <div class="col-md-12">
                    <div class="accordion mt-4 mb-4" id="accordionExampleSetting">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingSetting">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSetting" aria-expanded="true" aria-controls="collapseSetting">
                                    {{ trans('manager.stores') }}
                                </button>
                            </h2>
                            <div id="collapseSetting" class="accordion-collapse collapse show" aria-labelledby="headingSetting" data-bs-parent="#accordionExampleSetting">
                                <div class="accordion-body">
                                    <div class="row mb-3">
                                        <div class="col-md-6 text-center">
                                            <label id="selectAll" class=" col-sm-6 btn btn-success"> @lang('admin.select_all')
                                            </label>
                                        </div>
                                        <div class="col-md-6 text-center">
                                            <label id="selectNone" class=" col-sm-6 btn btn-danger"> @lang('admin.select_none')
                                            </label>
                                        </div>
                                    </div>
                                    <ul class="row mt-2 refers">
                                        @forelse ($refers as $refer)
                                        <li class="col-lg-3 col-md-4 col-sm-6">
                                            <input type="checkbox" class="flat" {{ in_array($refer->id, old('refers') ?? []) ? 'checked' : '' }} value="{{ $refer->id }}" name="refers[]">
                                            {{ $refer->name }}
                                        </li>
                                        @empty
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 text-end ">
                        <div>
                            <a href="{{ route('admin.charity.managers.index') }}" class="btn btn-outline-primary waves-effect waves-light btn-sm">@lang('button.cancel')</a>
                            <button type="submit" id="submit" class="btn btn-outline-success waves-effect waves-light btn-sm ">@lang('button.save')</button>
                            <button type="submit" name="submit" value="new" id="submit" class="btn btn-outline-success waves-effect waves-light btn-sm">@lang('button.save_new')</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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
    var input = document.querySelector(".phone");
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
