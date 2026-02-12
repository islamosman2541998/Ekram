@extends('admin.app')

@section('title', trans('beneficiaries.create'))
@section('title_page', trans('beneficiaries.beneficiaries'))
@section('title_route', route('admin.beneficiaries.index'))
@section('button_page')
<a href="{{ route('admin.beneficiaries.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('tell/intlTelInput.css') }}" />
@livewireStyles
@endsection

@section('content')
<div class="card">
    <form action="{{ route('admin.beneficiaries.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row d-flex justify-content-center">
            <div class="col-md-6">
                <!-- Account Section -->
                <div class="mt-4 mb-4 accordion" id="accordionAccount">
                    <div class="border rounded accordion-item">
                        <h2 class="accordion-header" id="headingAccount">
                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAccount" aria-expanded="true" aria-controls="collapseAccount">
                                @lang('accounts.account')
                            </button>
                        </h2>
                        <div id="collapseAccount" class="mt-3 accordion-collapse collapse show" aria-labelledby="headingAccount" data-bs-parent="#accordionAccount">
                            <div class="accordion-body">
                                <livewire:admin.accounts.create />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Beneficiary Details -->
                <div class="mt-4 mb-4 accordion" id="accordionDetails">
                    <div class="border rounded accordion-item">
                        <h2 class="accordion-header" id="headingDetails">
                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDetails" aria-expanded="true" aria-controls="collapseDetails">
                                @lang('beneficiaries.details')
                            </button>
                        </h2>
                        <div id="collapseDetails" class="mt-3 accordion-collapse collapse show" aria-labelledby="headingDetails" data-bs-parent="#accordionDetails">
                            <div class="accordion-body">
                                <!-- First Name -->
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.first_name') }}</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" name="first_name" value="{{ old('first_name') }}">
                                    </div>
                                </div>
                                <!-- Middle Name -->
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.middle_name') }}</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" name="middle_name" value="{{ old('middle_name') }}">
                                    </div>
                                </div>
                                <!-- Last Name -->
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.last_name') }}</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" name="last_name" value="{{ old('last_name') }}">
                                    </div>
                                </div>
                                <!-- Gender -->
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.gender') }}</label>
                                    <div class="col-sm-9">
                                        <select name="gender" class="form-control">
                                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>@lang('beneficiaries.male')</option>
                                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>@lang('beneficiaries.female')</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Nationality -->
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.nationality') }}</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" name="nationality" value="{{ old('nationality') }}">
                                    </div>
                                </div>
                                <!-- Marital Status -->
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.marital_status') }}</label>
                                    <div class="col-sm-9">
                                        <select name="marital_status" class="form-control">
                                            <option value="single" {{ old('marital_status') == 'single' ? 'selected' : '' }}>@lang('beneficiaries.single')</option>
                                            <option value="married" {{ old('marital_status') == 'married' ? 'selected' : '' }}>@lang('beneficiaries.married')</option>
                                            <option value="divorced" {{ old('marital_status') == 'divorced' ? 'selected' : '' }}>@lang('beneficiaries.divorced')</option>
                                            <option value="widowed" {{ old('marital_status') == 'widowed' ? 'selected' : '' }}>@lang('beneficiaries.widowed')</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Phone -->
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.phone') }}</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="tel" name="phone" value="{{ old('phone') }}" id="phone">
                                    </div>
                                </div>
                                <!-- Date of Birth -->
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.date_of_birth') }}</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="date" name="date_of_birth" value="{{ old('date_of_birth') }}">
                                    </div>
                                </div>
                                <!-- Family Members -->
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.family_members') }}</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="number" name="family_members" value="{{ old('family_members') }}">
                                    </div>
                                </div>
                                <!-- Education Level -->
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.education_level') }}</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" name="education_level" value="{{ old('education_level') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <!-- Social Status -->
                <div class="accordion mt-4 mb-4" id="accordionSocial">
                    <div class="accordion-item border rounded">
                        <h2 class="accordion-header" id="headingSocial">
                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSocial" aria-expanded="true" aria-controls="collapseSocial">
                                @lang('beneficiaries.social_status')
                            </button>
                        </h2>
                        <div id="collapseSocial" class="accordion-collapse collapse show" aria-labelledby="headingSocial" data-bs-parent="#accordionSocial">
                            <div class="accordion-body">
                                <!-- City -->
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.city') }}</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" name="city" value="{{ old('city') }}">
                                    </div>
                                </div>
                                <!-- District -->
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.district') }}</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" name="district" value="{{ old('district') }}">
                                    </div>
                                </div>
                                <!-- ID Number -->
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.id_number') }}</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" name="id_number" value="{{ old('id_number') }}">
                                    </div>
                                </div>
                                <!-- Civil Register -->
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.civil_register') }}</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" name="civil_register" value="{{ old('civil_register') }}">
                                    </div>
                                </div>
                                <!-- Email -->
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.email') }}</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="email" name="email" value="{{ old('email') }}">
                                    </div>
                                </div>
                                <!-- Housing Status -->
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.housing_status') }}</label>
                                    <div class="col-sm-9">
                                        <select name="housing_status" class="form-control">
                                            <option value="owned" {{ old('housing_status') == 'owned' ? 'selected' : '' }}>@lang('beneficiaries.owned')</option>
                                            <option value="rented" {{ old('housing_status') == 'rented' ? 'selected' : '' }}>@lang('beneficiaries.rented')</option>
                                            <option value="company" {{ old('housing_status') == 'company' ? 'selected' : '' }}>@lang('beneficiaries.company')</option>
                                            <option value="other" {{ old('housing_status') == 'other' ? 'selected' : '' }}>@lang('beneficiaries.other')</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Job Type -->
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.job_type') }}</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" name="job_type" value="{{ old('job_type') }}">
                                    </div>
                                </div>
                                <!-- Monthly Income -->
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.monthly_income') }}</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="number" name="monthly_income" value="{{ old('monthly_income') }}">
                                    </div>
                                </div>
                                <!-- Previous Registration -->
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.previous_registration') }}</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" name="previous_registration" value="{{ old('previous_registration') }}">
                                    </div>
                                </div>
                                <!-- Chronic Diseases -->
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.chronic_diseases') }}</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" name="chronic_diseases" value="{{ old('chronic_diseases') }}">
                                    </div>
                                </div>
                                <!-- Special Needs -->
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.special_needs') }}</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" name="special_needs" value="{{ old('special_needs') }}">
                                    </div>
                                </div>
                                <!-- Other Income -->
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.other_income') }}</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="number" name="other_income" value="{{ old('other_income') }}">
                                    </div>
                                </div>
                                <!-- Additional Notes -->
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.additional_notes') }}</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="additional_notes">{{ old('additional_notes') }}</textarea>
                                    </div>
                                </div>
                                <!-- Status -->
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">{{ trans('admin.status') }}</label>
                                    <div class="col-sm-9">
                                        <div class="form-check form-switch form-check-success">
                                            <input class="form-check-input" type="checkbox" name="status" {{ old('status') ? 'checked' : '' }} id="flexSwitchCheckSuccessStatus">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3 text-end">
                <div>
                    <a href="{{ route('admin.beneficiaries.index') }}" class="btn btn-outline-primary waves-effect waves-light btn-sm">@lang('button.cancel')</a>
                    <button type="submit" id="submit" class="btn btn-outline-success waves-effect waves-light btn-sm">@lang('button.save')</button>
                    <button type="submit" name="submit" value="new" class="btn btn-outline-success waves-effect waves-light btn-sm">@lang('button.save_new')</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('script')
<script src="{{ asset('tell/intlTelInput.js') }}"></script>
<script>
    var input = document.querySelector("#phone");
    var validMsg = document.querySelector("#valid-msg");
    var errorMsg = document.querySelector("#error-msg");
    var buttonSbmit = document.getElementById("submit");
    var errorMap = [`{{ trans('admin.Invalid_number') }}`, `{{ trans('admin.Invalid_country_code') }}`, `{{ trans('admin.Too_short') }}`, `{{ trans('admin.Too_long') }}`];
    var iti = window.intlTelInput(input, {
        initialCountry: "auto",
        geoIpLookup: function(callback) {
            $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
                var countryCode = (resp && resp.country) ? resp.country : "";
                callback(countryCode);
            });
        },
        utilsScript: "{{ asset('tell/utils.js') }}"
    });
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
@livewireScripts
@endsection