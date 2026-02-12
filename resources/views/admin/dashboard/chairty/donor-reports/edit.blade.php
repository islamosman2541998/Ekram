@extends('admin.app')

@section('title', trans('donors.edit_donors'))
@section('title_page', trans('donors.donors'))
@section('title_route', route('admin.donors.index'))
@section('button_page')
<a href="{{ route('admin.donors.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection


@section('style')
@livewireStyles
<link rel="stylesheet" href="{{ asset('tell/intlTelInput.css') }}" />
@endsection


@section('content')

<div class="card">
    <form action="{{ route('admin.donors.update', $donor->id) }}" method="post" enctype="multipart/form-data">
        @method('put')
        @csrf
        <input type="hidden" name="account_id" value="{{ $donor->account->id }}">
        <input type="hidden" name="id" value="{{ $donor->id }}">

        <div class="row d-flex justify-content-center ">
            <div class="col-md-6">
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
                                <livewire:admin.accounts.create :id="$donor->account->id" :passwordShow="false" />
                            </div>
                        </div>
                    </div>
                </div>


                <div class="accordion mt-4 mb-4 " id="accordionExampleInfo">
                    <div class="accordion-item border rounded ">
                        <h2 class="accordion-header" id="headingInfo">
                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInfo" aria-expanded="true" aria-controls="collapseInfo">
                                {{ trans('donors.info_donors') }}
                            </button>
                        </h2>
                        <div id="collapseInfo" class="accordion-collapse collapse show mt-3" aria-labelledby="headingInfo" data-bs-parent="#accordionExampleInfo">
                            <div class="accordion-body">

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('donors.full_name') }}</label>
                                    <div class="col-sm-10">
                                        <input class="form-control @error('full_name') is-invalid @enderror" type="text" name="full_name" value="{{ $donor->full_name }}">
                                        @error('full_name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="accordion mt-4 mb-4" id="accordionExampleSetting">
                    <div class="accordion-item border rounded">
                        <h2 class="accordion-header" id="headingSetting">
                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSetting" aria-expanded="true" aria-controls="collapseSetting">
                                {{ trans('admin.settings') }}
                            </button>
                        </h2>
                        <div id="collapseSetting" class="accordion-collapse collapse show" aria-labelledby="headingSetting" data-bs-parent="#accordionExampleSetting">
                            <div class="accordion-body">
                                <div class="col-3">
                                    {{-- image ------------------------------------------------------------------------------------- --}}
                                    @if ($donor->image != null)
                                    <img src="{{ getImageThumb($donor->image) }}" alt="" style="width:100%">
                                    @endif
                                </div>
                                {{-- image ------------------------------------------------------------------------------------- --}}
                                <div class="col-12">
                                    <div class="row mb-3">
                                        <label for="example-number-input" col-form-label>
                                            @lang('admin.image')</label>
                                        <div class="col-sm-12">
                                            <input class="form-control" type="file" placeholder="@lang('admin.image')" id="example-number-input" name="image" value="{{ old('image') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    {{-- refers ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12 mt-3">
                                        <label class="form-check-label" for="flexSwitchCheckSuccessrefers">@lang('admin.refers')</label>
                                        <select name="refer_id" class="form-control">
                                            <option value=""> @lang('refer.select_refer') </option>
                                            @forelse ($refers as $refer)
                                            <option value="{{ $refer->id }}" @if($donor->refer_id == $refer->id) selected @endif>
                                                {{ $refer->name }}
                                            </option>
                                            @empty
                                            @endforelse
                                        </select>
                                        @if ($errors->has('refer_id'))
                                        <span class="missiong-spam">{{ $errors->first('refer_id') }}</span>
                                        @endif
                                    </div>
                                    {{-- Status ------------------------------------------------------------------------------------- --}}
                                    <div class="col-sm-6 mt-3">
                                        <label class="form-check-label" for="flexSwitchCheckSuccessStatus">@lang('admin.status')</label>
                                        <div class="form-check form-switch form-check-success">
                                            <input class="form-check-input {{ empty($errors->first('status')) ?: 'has-error' }}" type="checkbox" role="switch" name="status" {{ $donor->status == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessStatus">
                                            @if ($errors->has('status'))
                                            <span class="missiong-spam">{{ $errors->first('status') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- Confirm Mobile --}}
                                    <div class="col-sm-6 mt-3">
                                        <label class="form-check-label" for="flexSwitchCheckSuccessConfirm">@lang('donors.mobile_confirmation')</label>
                                        <div class="form-check form-switch form-check-success">
                                            <input class="form-check-input {{ empty($errors->first('status')) ?: 'has-error' }}" type="checkbox" role="switch" name="mobile_confirm" {{ $donor->mobile_confirm == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessConfirm">
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
            <div class="col-md-11">
                {{-- Address --}}
                <div class="accordion mt-4 mb-4 " id="accordionExampleAddress">
                    <div class="accordion-item border rounded ">
                        <h2 class="accordion-header" id="headingAddress">
                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAddress" aria-expanded="true" aria-controls="collapseAddress">
                                {{ trans('donors.address') }}
                            </button>
                        </h2>
                        <div id="collapseAddress" class="accordion-collapse collapse show mt-3" aria-labelledby="headingAddress" data-bs-parent="#accordionExampleAddress">
                            <div class="accordion-body">
                                <div class="row">
                                    @forelse ($donor->addressDonor as $key => $item)
                                    <div class="old_items" data-group="addressList">
                                        <input type="hidden" data-type="old_id" value="{{ $item->id }}" name="old[id][]">
                                        <!-- Repeater Content -->
                                        <div class="col-md-12">
                                            <input type="hidden" data-name="id" value="{{ $item->id }}">
                                            <div class="item-content">
                                                <div class="form-group">
                                                    <label for="example-email-input" class="col-sm-2 col-form-label">{{ trans('donors.city') }}</label>
                                                    <div class="col-lg-12">
                                                        <input type="text" class="form-control" name="old[city][]" value="{{ $item->city }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="example-email-input" class="col-sm-2 col-form-label">{{ trans('donors.country') }}</label>
                                                    <div class="col-lg-12">
                                                        <input type="text" class="form-control" name="old[country][]" value="{{ $item->country }}">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="example-email-input" class="col-sm-2 col-form-label">{{ trans('donors.address') }}</label>
                                                    <div class="col-lg-12">

                                                        <textarea class="form-control" data-skip-name="false" name="old[address][]">{{ $item->address }}</textarea>
                                                    </div>
                                                </div>
                                                <!-- Repeater Remove Btn -->
                                                <div class="pull-right repeater-remove-btn mt-2">
                                                    <button class="btn btn-danger old_remove-btn" type="button">
                                                        @lang('admin.delete')
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>

                                    </div>
                                    @empty
                                    @endforelse

                                    <div class="repeater-section" style="display: none">
                                        <div class="col-md-12" id="repeater">
                                            <div class="clearfix"></div>
                                            <!-- Repeater Items -->
                                            <div class="items" data-group="addressList">
                                                <!-- Repeater Content -->
                                                <div class="col-md-12">
                                                    <div class="item-content">
                                                        <div class="form-group">
                                                            <label for="example-email-input" class="col-sm-2 col-form-label">{{ trans('donors.city') }}</label>
                                                            <div class="col-lg-12">
                                                                <input type="text" class="form-control req" data-name="city">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="example-email-input" class="col-sm-2 col-form-label">{{ trans('donors.country') }}</label>
                                                            <div class="col-lg-12">
                                                                <input type="text" class="form-control req" data-name="country">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="example-email-input" class="col-sm-2 col-form-label">{{ trans('donors.address') }}</label>
                                                            <div class="col-lg-12">
                                                                <textarea class="form-control req" data-skip-name="false" data-name="address"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Repeater Remove Btn -->
                                                    <div class="pull-right repeater-remove-btn mt-2">
                                                        <button class="btn btn-danger remove-btn" type="button">
                                                            @lang('admin.delete')
                                                        </button>
                                                    </div>
                                                    <hr>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Repeater Heading -->
                                    <div class="repeater-heading mt-3 d-none">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-success form-control pull-right repeater-add-btn " id="buttons" id="donors_address">
                                                <i class="bx bx-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="repeater-show-heading mt-3">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-success form-control pull-right repeater-show-btn " id="buttons" id="donors_address">
                                                <i class="bx bx-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3 text-end ">
                <div>
                    <a href="{{ route('admin.donors.index') }}" class="btn btn-outline-primary waves-effect waves-light btn-sm">@lang('button.cancel')</a>
                    <button type="submit" id="submit" class="btn btn-outline-success waves-effect waves-light btn-sm">@lang('button.save')</button>
                    <button type="submit" name="submit" value="update" class="btn btn-outline-success waves-effect waves-light  btn-sm">@lang('button.save_update')</button>

                </div>
            </div>

        </div>
    </form>
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
