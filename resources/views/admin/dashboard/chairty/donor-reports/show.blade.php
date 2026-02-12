@extends('admin.app')

@section('title', trans('donors.show_donors'))
@section('title_page', trans('donors.donors'))
@section('title_route', route('admin.donors.index'))
@section('button_page')
    <a href="{{ route('admin.donors.index') }}"
        class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection



@section('content')

    <div class="card">
        <form action="{{ route('admin.donors.update', $donor->id) }}" method="post" enctype="multipart/form-data">
            @method('put')
            @csrf
            <div class="row d-flex justify-content-center ">
                <div class="col-md-6">
                    <div class="accordion mt-4 mb-4 " id="accordionExample">
                        <div class="accordion-item border rounded ">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne1" aria-expanded="true" aria-controls="collapseOne1">
                                    {{ trans('donors.info_donors') }}
                                </button>
                            </h2>
                            <div id="collapseOne1" class="accordion-collapse collapse show mt-3"
                                aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">

                                    <div class="row mb-3">
                                        <label for="example-text-input"
                                            class="col-sm-2 col-form-label">{{ trans('donors.full_name') }}</label>
                                        <div class="col-sm-10">
                                            <input class="form-control @error('full_name') is-invalid @enderror" disabled
                                                type="text" name="full_name" value="{{ $donor->full_name }}">
                                        </div>

                                    </div>
                                    <div class="row mb-3">
                                        <label for="example-email-input"
                                            class="col-sm-2 col-form-label">{{ trans('users.email') }}</label>
                                        <div class="col-sm-10">
                                            <input class="form-control @error('email') is-invalid @enderror" disabled
                                                type="email" value="{{ $donor->account->email }}" name="email">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="example-tel-input"
                                            class="col-sm-2 col-form-label">{{ trans('users.mobile') }}</label>
                                        <div class="col-sm-10">
                                            <input type="tel" name="mobile"
                                                class="form-control @error('mobile') is-invalid @enderror " disabled
                                                value="{{ $donor->mobile }}" style="border:none" />
                                            <span id="valid-msg" class="hide" style="color:green"></span>
                                            <span id="error-msg" class="hide" style="color:red"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12" style="margin-right: 612px;">
                    {{-- Address --}}
                    <div class="col-md-6">
                        <div class="accordion mt-4 mb-4 " id="accordionExample">
                            <div class="accordion-item border rounded ">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne1" aria-expanded="true" aria-controls="collapseOne1">
                                        {{ trans('donors.donor_cart') }}
                                    </button>
                                </h2>
                                <div id="collapseOne1" class="accordion-collapse collapse show mt-3"
                                    aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">

                                        <div class="row mb-3">
                                            <label for="example-text-input"
                                                class="col-sm-2 col-form-label">{{ trans('donors.donations') }}</label>
                                            <div class="col-sm-10">
                                                <input
                                                    class="form-control 
                                                @error('full_name') is-invalid @enderror"
                                                    disabled type="text" name="full_name" {{-- value="{{ $donor->full_name }}" --}}>
                                            </div>

                                        </div>
                                        <div class="row mb-3">
                                            <label for="example-email-input"
                                                class="col-sm-2 col-form-label">{{ trans('donors.project') }}</label>
                                            <div class="col-sm-10">
                                                <input
                                                    class="form-control
                                                 {{-- @error('email') is-invalid @enderror" disabled --}}
                                                    {{-- type="email"  --}}
                                                    {{-- value="{{ $donor->account->email }}" --}}
                                                     name="email">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="example-tel-input"
                                                class="col-sm-2 col-form-label">{{ trans('donors.total') }}</label>
                                            <div class="col-sm-10">
                                                <input type="tel" name="mobile"
                                                    class="form-control @error('mobile') is-invalid @enderror " disabled
                                                    {{-- value="{{ $donor->mobile }}"  --}} style="border:none" />
                                                <span id="valid-msg" class="hide" style="color:green"></span>
                                                <span id="error-msg" class="hide" style="color:red"></span>
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
                        <a href="{{ route('admin.donors.index') }}"
                            class="btn btn-outline-primary waves-effect waves-light btn-sm">@lang('button.cancel')</a>
                    </div>
                </div>

            </div>
        </form>
    </div>

@endsection
