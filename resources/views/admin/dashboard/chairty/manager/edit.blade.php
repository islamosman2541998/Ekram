@extends('admin.app')

@section('title', trans('manager.edit_manager'))
@section('title_page', trans('manager.managers'))
@section('title_route', route('admin.charity.managers.index') )
@section('button_page')
<a href="{{ route('admin.charity.managers.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection

@section('style')
@livewireStyles
<link rel="stylesheet" href="{{ asset('tell/intlTelInput.css') }}" />
<style>
    .iti { width: 100%; }
    .iti-mobile .iti__country-list { width: 90%; }
    .iti__country-name { display: none; }
    .iti__flag-container {
        left: 10px !important;
        right: auto !important;
    }
    .iti__selected-flag {
        left: 0 !important;
        right: auto !important;
    }
    .iti__country-list {
        left: 0 !important;
        right: auto !important;
    }
    .iti input {
        padding-left: 70px !important;
        padding-right: 12px !important;
        text-align: left !important;
        direction: ltr !important;
    }
    .iti__selected-flag {
        position: absolute !important;
        top: 0 !important;
        bottom: 0 !important;
        left: 0 !important;
        right: auto !important;
        width: 60px !important;
        height: 100% !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        border-right: 1px solid #ced4da !important;
    }
    .password-container {
        position: relative;
    }
    .password-eye {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        z-index: 10;
        color: #888;
    }
    .password-eye:hover {
        color: #495057;
    }
    .password-requirements {
        margin-top: 5px;
        font-size: 14px;
    }
    .requirement {
        display: block;
        margin: 2px 0;
        transition: color 0.3s ease;
    }
    .requirement.valid {
        color: #28a745;
    }
    .requirement.invalid {
        color: #dc3545;
    }
</style>
@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.charity.managers.update', $manager->id ) }}" method="post" enctype="multipart/form-data" id="form-submit">
            @csrf
            @method('put')
            <input type="hidden" name="account_id" value="{{ $manager->account->id }}">
            <input type="hidden" name="id" value="{{ $manager->id }}">

            <div class="row d-flex justify-content-center ">
                <div class="col-12 col-md-6 p-3">
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
                                    <livewire:admin.accounts.create :id="$manager->account->id" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 p-3">
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
                                        <div class="col-12">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">{{ trans('refer.name') }}</label>
                                            <div class="col-sm-10">
                                                <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ $manager->name }}">
                                                @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- status ------------------------------------------------------------------------------------- --}}
                                        <div class="col-sm-12 mt-2">
                                            <label class="form-check-label" for="flexSwitchCheckSuccessStatus">@lang('admin.status')</label>
                                            <div class="form-check form-switch form-check-success">
                                                <input class="form-check-input {{ (empty($errors->first('status'))) ?: 'has-error'}}" type="checkbox" role="switch" name="status" {{  $manager->status == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessStatus">
                                                @if ($errors->has('status'))
                                                <span class="missiong-spam">{{ $errors->first('status') }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- password ------------------------------------------------------------------------------------- --}}
                                        <div class="col-12">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">{{ trans('admin.password') }}</label>
                                            <div class="col-sm-10">
                                                <div class="password-container">
                                                    <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" id="password" value="{{ old('password') }}">
                                                    <i class="password-eye fa fa-eye" id="password-eye-icon" onclick="togglePasswordVisibility('password')"></i>
                                                    @error('password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="password-requirements">
                                                    <div class="requirement" id="length-req">At least 8 characters</div>
                                                    <div class="requirement" id="uppercase-req">At least one uppercase letter</div>
                                                    <div class="requirement" id="lowercase-req">At least one lowercase letter</div>
                                                    <div class="requirement" id="number-req">At least one number</div>
                                                    <div class="requirement" id="special-req">At least one special character</div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- confirm password ------------------------------------------------------------------------------------- --}}
                                        <div class="col-12">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">{{ trans('admin.confirm_password') }}</label>
                                            <div class="col-sm-10">
                                                <input class="form-control @error('password_confirmation') is-invalid @enderror" type="password" name="password_confirmation" id="password_confirmation" value="{{ old('password_confirmation') }}">
                                                @error('password_confirmation')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- phone ------------------------------------------------------------------------------------- --}}
                                        <div class="col-12">
                                            <label for="mobile" class="col-sm-12 col-form-label">{{ trans('admin.phone') }}</label>
                                            <div class="col-sm-10">
                                                <input type="tel" class="form-control @error('mobile') is-invalid @enderror" name="mobile" id="mobile" value="{{ $manager->mobile }}" style="direction: ltr;" placeholder="Enter phone number">
                                                <input type="hidden" name="countryData" id="countryData" value="{{ $manager->mobile }}">
                                                <div id="notification-mobile" class="text-danger"></div>
                                                @error('mobile')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="col-md-12">
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
                                            <label id="selectAll" class=" col-sm-6 btn btn-success"> @lang('admin.select_all') </label>
                                        </div>
                                        <div class="col-md-6 text-center">
                                            <label id="selectNone" class=" col-sm-6 btn btn-danger"> @lang('admin.select_none') </label>
                                        </div>
                                    </div>
                                    <ul class="row mt-2 refers">
                                        @forelse ($refers as $refer)
                                        <li class="col-lg-3 col-md-4 col-sm-6">
                                            <input type="checkbox" class="flat" {{ in_array($refer->id, $manager->refers->pluck('id')->toArray()??[]) ? 'checked': ""   }} value="{{ $refer->id }}" name="refers[]">
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
                            <button type="submit" id="submit" class="btn btn-outline-success waves-effect waves-light btn-sm">@lang('button.save')</button>
                            <button type="submit" name="submit" value="update" class="btn btn-outline-success waves-effect waves-light  btn-sm">@lang('button.save_update')</button>
                        </div>
                    </div>

                </div> --}}
        </form>
    </div>
</div>

@endsection

@section('script')
@livewireScripts
<script src="{{ asset('tell/intlTelInput.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const phoneInput = document.querySelector("#mobile");
        if (phoneInput) {
            // Initialize intl-tel-input
            const iti = window.intlTelInput(phoneInput, {
                initialCountry: "sa",
                preferredCountries: ['sa', 'ae', 'kw', 'qa', 'bh', 'om'],
                separateDialCode: true,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
                autoHideDialCode: false,
                nationalMode: false,
                formatOnDisplay: true,
                autoPlaceholder: "aggressive",
                allowDropdown: true
            });

            // Set initial value if exists
            const mobileNumber = "{{ $manager->mobile }}";
            if (mobileNumber) {
                iti.setNumber(mobileNumber);
                document.getElementById('countryData').value = iti.getNumber();
            }

            // Make sure input is editable
            phoneInput.removeAttribute('readonly');
            phoneInput.removeAttribute('disabled');

            // Update hidden field with full number when input changes
            phoneInput.addEventListener('input', function() {
                if (iti.isValidNumber()) {
                    const fullNumber = iti.getNumber(intlTelInputUtils.numberFormat.E164);
                    document.getElementById('countryData').value = fullNumber;
                    document.getElementById('notification-mobile').textContent = "";
                } else {
                    document.getElementById('notification-mobile').textContent = "{{ trans('admin.Invalid_number') }}";
                }
            });

            // Validate on blur
            phoneInput.addEventListener('blur', function() {
                if (phoneInput.value.trim()) {
                    if (!iti.isValidNumber()) {
                        document.getElementById('notification-mobile').textContent = "{{ trans('admin.Invalid_number') }}";
                    } else {
                        document.getElementById('notification-mobile').textContent = "";
                    }
                } else {
                    document.getElementById('notification-mobile').textContent = "";
                }
            });
        }
    });

    // Password visibility toggle
    function togglePasswordVisibility(inputId) {
        const passwordInput = document.getElementById(inputId);
        const icon = document.getElementById('password-eye-icon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    // Password validation
    function validatePassword(password) {
        // At least 8 characters
        const lengthValid = password.length >= 8;
        document.getElementById('length-req').classList.toggle('valid', lengthValid);
        document.getElementById('length-req').classList.toggle('invalid', !lengthValid);
        
        // At least one uppercase letter
        const hasUppercase = /[A-Z]/.test(password);
        document.getElementById('uppercase-req').classList.toggle('valid', hasUppercase);
        document.getElementById('uppercase-req').classList.toggle('invalid', !hasUppercase);
        
        // At least one lowercase letter
        const hasLowercase = /[a-z]/.test(password);
        document.getElementById('lowercase-req').classList.toggle('valid', hasLowercase);
        document.getElementById('lowercase-req').classList.toggle('invalid', !hasLowercase);
        
        // At least one number
        const hasNumber = /\d/.test(password);
        document.getElementById('number-req').classList.toggle('valid', hasNumber);
        document.getElementById('number-req').classList.toggle('invalid', !hasNumber);
        
        // At least one special character
        const hasSpecial = /[!@#$%^&*]/.test(password);
        document.getElementById('special-req').classList.toggle('valid', hasSpecial);
        document.getElementById('special-req').classList.toggle('invalid', !hasSpecial);
        
        // Enable/disable submit button based on validation
        const submitButton = document.querySelector('button[type="submit"]');
        if (lengthValid && hasUppercase && hasLowercase && hasNumber && hasSpecial) {
            submitButton.disabled = false;
        } else {
            submitButton.disabled = true;
        }
    }

    // Validate password on input
    const passwordInput = document.getElementById('password');
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            validatePassword(passwordInput.value);
        });
    }
</script>
@endsection
