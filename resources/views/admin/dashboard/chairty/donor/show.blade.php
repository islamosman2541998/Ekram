@extends('admin.app')

@section('title', trans('donors.show_donors'))
@section('title_page', trans('donors.donors'))
@section('title_route', route('admin.donors.index') )
@section('button_page')
<a href="{{ route('admin.donors.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
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
                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne1" aria-expanded="true" aria-controls="collapseOne1">
                                {{ trans('donors.info_donors') }}
                            </button>
                        </h2>
                        <div id="collapseOne1" class="accordion-collapse collapse show mt-3" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('donors.full_name') }}</label>
                                    <div class="col-sm-10">
                                        <input class="form-control @error('full_name') is-invalid @enderror" disabled type="text" name="full_name" value="{{ $donor->full_name }}">
                                    </div>

                                </div>
                                <div class="row mb-3">
                                    <label for="example-email-input" class="col-sm-2 col-form-label">{{ trans('users.email') }}</label>
                                    <div class="col-sm-10">
                                        <input class="form-control @error('email') is-invalid @enderror" disabled type="email" value="{{  $donor->account->email }}" name="email">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="example-tel-input" class="col-sm-2 col-form-label">{{ trans('users.mobile') }}</label>
                                    <div class="col-sm-10">
                                        <input type="tel" name="mobile" class="form-control @error('mobile') is-invalid @enderror " disabled value="{{ $donor->mobile }}" style="border:none" />
                                        <span id="valid-msg" class="hide" style="color:green"></span>
                                        <span id="error-msg" class="hide" style="color:red"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="accordion mt-4 mb-4" id="accordionExample">
                    <div class="accordion-item border rounded">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                {{ trans('admin.settings') }}
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                {{-- image ------------------------------------------------------------------------------------- --}}
                                <div class="col-3">
                                    <img src="{{ getImageThumb($donor->image) }}" alt="" style="width:100%">
                                </div>
                                {{-- refers ------------------------------------------------------------------------------------- --}}
                                <div class="row my-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.refers') }}</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" disabled type="text" value="{{ $donor->refer?->name }}">
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    {{-- Status ------------------------------------------------------------------------------------- --}}
                                    <div class="col-6 mb-2">
                                        <label for="example-number-input" class="col-md-6"> {{ trans('admin.status') }}</label>
                                        @if($donor->status == 1 )
                                        <span class="badge bg-success">@lang("admin.active")</span>
                                        @else
                                        <span class="badge bg-danger">@lang("admin.dis_active")</span>
                                        @endif
                                    </div>
                                    {{-- mobile_confirmation ------------------------------------------------------------------------------------- --}}
                                    <div class="col-6 mb-3">
                                        <label for="example-number-input" class="col-md-6"> {{ trans('donors.mobile_confirmation') }}</label>
                                        @if($donor->mobile_confirm == 1 )
                                        <span class="badge bg-success">@lang("admin.yes")</span>
                                        @else
                                        <span class="badge bg-danger">@lang("admin.no")</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-11">
                {{-- Address --}}
                <div class="accordion mt-4 mb-4 " id="accordionExample">
                    <div class="accordion-item border rounded ">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne3" aria-expanded="true" aria-controls="collapseOne3">
                                {{ trans('donors.address') }}
                            </button>
                        </h2>
                        <div id="collapseOne3" class="accordion-collapse collapse show mt-3" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="row">
                                    @forelse ($donor->addressDonor as $key => $item)
                                    <div class="items" data-group="addressList">
                                        <input type="hidden" data-type="old_id" value="{{ $item->id }}" name="old_id[]">
                                        <!-- Repeater Content -->
                                        <div class="col-md-12">
                                            <input type="hidden" data-name="id" value="{{ $item->id }}">
                                            <div class="item-content">
                                                <div class="form-group">
                                                    <label for="example-email-input" class="col-sm-2 col-form-label">{{ trans('donors.city') }}</label>
                                                    <div class="col-lg-12">
                                                        <input type="text" class="form-control" data-name="city" value="{{ $item->city }}" disabled>

                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="example-email-input" class="col-sm-2 col-form-label">{{ trans('donors.country') }}</label>
                                                    <div class="col-lg-12">
                                                        <input type="text" class="form-control" data-name="country" value="{{ $item->country }}" disabled>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="example-email-input" class="col-sm-2 col-form-label">{{ trans('donors.address') }}</label>
                                                    <div class="col-lg-12">

                                                        <textarea class="form-control" data-skip-name="false" data-name="address" disabled>{{ $item->country }}</textarea>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    @endforelse

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3 text-end ">
                <div>
                    <a href="{{ route('admin.donors.index') }}" class="btn btn-outline-primary waves-effect waves-light btn-sm">@lang('button.cancel')</a>
                </div>
            </div>

        </div>
    </form>
</div>

@endsection
