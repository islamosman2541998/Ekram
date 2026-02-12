@extends('admin.app')

@section('title', trans('beneficiaries.show'))
@section('title_page', trans('beneficiaries.beneficiaries'))
@section('title_route', route('admin.beneficiaries.index'))
@section('button_page')
<a href="{{ route('admin.beneficiaries.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('tell/intlTelInput.css') }}" />
@endsection

@section('content')
<div class="card">
    <div class="row d-flex justify-content-center">
        <div class="col-md-6">
            <!-- Account Section -->
            <div class="accordion mt-4 mb-4" id="accordionAccount">
                <div class="border rounded accordion-item">
                    <h2 class="accordion-header" id="headingAccount">
                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAccount" aria-expanded="true" aria-controls="collapseAccount">
                            @lang('accounts.account')
                        </button>
                    </h2>
                    <div id="collapseAccount" class="mt-3 accordion-collapse collapse show" aria-labelledby="headingAccount" data-bs-parent="#accordionAccount">
                        <div class="accordion-body">
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">@lang('accounts.user_name')</label>
                                <div class="col-sm-9">
                                    <input class="form-control" disabled value="{{ $beneficiary->account->user_name }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">@lang('beneficiaries.phone')</label>
                                <div class="col-sm-9">
                                    <input class="form-control" disabled value="{{ $beneficiary->account->mobile }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">@lang('beneficiaries.email')</label>
                                <div class="col-sm-9">
                                    <input class="form-control" disabled value="{{ $beneficiary->account->email }}">
                                </div>
                            </div>
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
                                    <input class="form-control" disabled value="{{ $beneficiary->first_name }}">
                                </div>
                            </div>
                            <!-- Middle Name -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.middle_name') }}</label>
                                <div class="col-sm-9">
                                    <input class="form-control" disabled value="{{ $beneficiary->middle_name }}">
                                </div>
                            </div>
                            <!-- Last Name -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.last_name') }}</label>
                                <div class="col-sm-9">
                                    <input class="form-control" disabled value="{{ $beneficiary->last_name }}">
                                </div>
                            </div>
                            <!-- Gender -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.gender') }}</label>
                                <div class="col-sm-9">
                                    <input class="form-control" disabled value="{{ trans('beneficiaries.' . $beneficiary->gender) }}">
                                </div>
                            </div>
                            <!-- Nationality -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.nationality') }}</label>
                                <div class="col-sm-9">
                                    <input class="form-control" disabled value="{{ $beneficiary->nationality }}">
                                </div>
                            </div>
                            <!-- Marital Status -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.marital_status') }}</label>
                                <div class="col-sm-9">
                                    <input class="form-control" disabled value="{{ trans('beneficiaries.' . $beneficiary->marital_status) }}">
                                </div>
                            </div>
                            <!-- Phone -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.phone') }}</label>
                                <div class="col-sm-9">
                                    <input class="form-control" disabled value="{{ $beneficiary->phone }}">
                                </div>
                            </div>
                            <!-- Date of Birth -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.date_of_birth') }}</label>
                                <div class="col-sm-9">
                                    <input class="form-control" disabled value="{{ $beneficiary->date_of_birth }}">
                                </div>
                            </div>
                            <!-- Family Members -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.family_members') }}</label>
                                <div class="col-sm-9">
                                    <input class="form-control" disabled value="{{ $beneficiary->family_members }}">
                                </div>
                            </div>
                            <!-- Education Level -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.education_level') }}</label>
                                <div class="col-sm-9">
                                    <input class="form-control" disabled value="{{ $beneficiary->education_level }}">
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
                                    <input class="form-control" disabled value="{{ $beneficiary->city }}">
                                </div>
                            </div>
                            <!-- District -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.district') }}</label>
                                <div class="col-sm-9">
                                    <input class="form-control" disabled value="{{ $beneficiary->district }}">
                                </div>
                            </div>
                            <!-- ID Number -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.id_number') }}</label>
                                <div class="col-sm-9">
                                    <input class="form-control" disabled value="{{ $beneficiary->id_number }}">
                                </div>
                            </div>
                            <!-- Civil Register -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.civil_register') }}</label>
                                <div class="col-sm-9">
                                    <input class="form-control" disabled value="{{ $beneficiary->civil_register }}">
                                </div>
                            </div>
                            <!-- Email -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.email') }}</label>
                                <div class="col-sm-9">
                                    <input class="form-control" disabled value="{{ $beneficiary->email }}">
                                </div>
                            </div>
                            <!-- Housing Status -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.housing_status') }}</label>
                                <div class="col-sm-9">
                                    <input class="form-control" disabled value="{{ trans('beneficiaries.' . $beneficiary->housing_status) }}">
                                </div>
                            </div>
                            <!-- Job Type -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.job_type') }}</label>
                                <div class="col-sm-9">
                                    <input class="form-control" disabled value="{{ $beneficiary->job_type }}">
                                </div>
                            </div>
                            <!-- Monthly Income -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.monthly_income') }}</label>
                                <div class="col-sm-9">
                                    <input class="form-control" disabled value="{{ $beneficiary->monthly_income }}">
                                </div>
                            </div>
                            <!-- Previous Registration -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.previous_registration') }}</label>
                                <div class="col-sm-9">
                                    <input class="form-control" disabled value="{{ $beneficiary->previous_registration }}">
                                </div>
                            </div>
                            <!-- Chronic Diseases -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.chronic_diseases') }}</label>
                                <div class="col-sm-9">
                                    <input class="form-control" disabled value="{{ $beneficiary->chronic_diseases }}">
                                </div>
                            </div>
                            <!-- Special Needs -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.special_needs') }}</label>
                                <div class="col-sm-9">
                                    <input class="form-control" disabled value="{{ $beneficiary->special_needs }}">
                                </div>
                            </div>
                            <!-- Other Income -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.other_income') }}</label>
                                <div class="col-sm-9">
                                    <input class="form-control" disabled value="{{ $beneficiary->other_income }}">
                                </div>
                            </div>
                            <!-- Additional Notes -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">{{ trans('beneficiaries.additional_notes') }}</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" disabled>{{ $beneficiary->additional_notes }}</textarea>
                                </div>
                            </div>
                            <!-- Status -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">{{ trans('admin.status') }}</label>
                                <div class="col-sm-9">
                                    <input class="form-control" disabled value="{{ $beneficiary->status ? trans('admin.active') : trans('admin.dis_active') }}">
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
            </div>
        </div>
    </div>
</div>
@endsection