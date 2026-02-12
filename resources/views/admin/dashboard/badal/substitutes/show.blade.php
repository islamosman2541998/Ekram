@extends('admin.app')

@section('title', trans('substitutes.substitutes'))
@section('title_page', trans('substitutes.show_substitute'))
@section('title_route', route('admin.badal.substitutes.index') )
@section('button_page')
<a href="{{ route('admin.badal.substitutes.index') }}" class="btn btn-outline-success btn-sm">@lang('button.cancel')</a>
@endsection

@section('content')
<div class="card">
    <div class="row d-flex justify-content-center ">
        <div class="col-md-6">
            <div class="accordion mt-4 mb-4 " id="accordionExampleInfo">
                <div class="accordion-item border rounded ">
                    <h2 class="accordion-header" id="headingInfo">
                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInfo" aria-expanded="true" aria-controls="collapseInfo">
                            @lang('substitutes.info')
                        </button>
                    </h2>
                    <div id="collapseInfo" class="accordion-collapse collapse show mt-3" aria-labelledby="headingInfo" data-bs-parent="#accordionExampleInfo">
                        <div class="accordion-body">
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">@lang('substitutes.full_name')</label>
                                <div class="col-sm-10">
                                    <input class="form-control @error('full_name') is-invalid @enderror" type="text" disabled name="full_name" value="{{ $substitute->full_name }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="example-text-input" class="col-sm-12 col-form-label"> @lang('substitutes.identity') </label>
                                    <input class="form-control @error('identity') is-invalid @enderror" type="text" disabled name="identity" value="{{ $substitute->identity }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="example-text-input" class="col-sm-12 col-form-label"> @lang('substitutes.nationality') </label>
                                    <input class="form-control @error('nationality') is-invalid @enderror" type="text" disabled name="nationality" value="{{ $substitute->nationality }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <label for="example-email-input" class="col-sm-12 col-form-label"> @lang('users.email') </label>
                                    <input class="form-control @error('email') is-invalid @enderror" type="email" disabled value="{{ $substitute->account->email  }}" name="email">
                                </div>
                                <div class="col-6">
                                    <label for="example-mobile-input" class="col-sm-12 col-form-label"> @lang('substitutes.mobile') </label>
                                    <input class="form-control @error('mobile') is-invalid @enderror" type="mobile" disabled value="{{ $substitute->account->mobile  }}" name="mobile">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="example-mobile-input" class="col-sm-12 col-form-label"> @lang('substitutes.gender') </label>
                                    <select name="gender" class="form-control select2 @error('gender') is-invalid @enderror" disabled>
                                        <option value="" selected disabled></option>
                                        <option value="male" {{ $substitute->gender == 'male' ? 'selected' : '' }}> Male </option>
                                        <option value="female" {{ $substitute->gender == 'female' ? 'selected' : '' }}> Female </option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="example-mobile-input" class="col-sm-12 col-form-label"> @lang('substitutes.languages') </label>
                                    <select name="languages[]" class="form-control select2 @error('languages') is-invalid @enderror" multiple disabled>
                                        @foreach (App\Enums\LanguagesEnum::values() as $type)
                                        <option value="{{ $type }}" {{ in_array($type, json_decode($substitute->languages)  ?? [] )  ? 'selected' : '' }}>
                                            {{ $type}}
                                        </option>
                                        @endforeach
                                    </select>
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
                            @lang('admin.settings')
                        </button>
                    </h2>
                    <div id="collapseSetting" class="accordion-collapse collapse show" aria-labelledby="headingSetting" data-bs-parent="#accordionExampleSetting">
                        <div class="accordion-body">
                            {{-- image ------------------------------------------------------------------------------------- --}}
                            <div class="row mb-3">
                                <div class="col-8">
                                    <a href="{{ getImageThumb($substitute->image) }}" target="_blank">
                                        <img src="{{ getImageThumb($substitute->image) }}" alt="" width="100">
                                    </a>
                                </div>
                            </div>
                            {{-- proportion ------------------------------------------------------------------------------------- --}}
                            <div class="row mb-3">
                                <div class="col-sm-6 mt-3">
                                    <label for="example-proportion-input" col-form-label> @lang('substitutes.proportion') </label>
                                </div>
                                <div class="col-sm-6 mt-3">
                                    <input class="form-control @error('proportion') is-invalid @enderror" type="number" step="any" placeholder="@lang('substitutes.proportion')" id="example-proportion-input" name="proportion" value="{{ $substitute->proportion }}" disabled>
                                </div>
                            </div>
                            {{-- Status ------------------------------------------------------------------------------------- --}}
                            <div class="row mb-3">
                                <div class="col-sm-6 mt-3">
                                    <label class="form-check-label" for="flexSwitchCheckSuccessStatus">@lang('admin.status')</label>
                                </div>
                                <div class="col-sm-6 mt-3">
                                    @if($substitute->status == 1 )
                                    <span class="badge bg-success">@lang("admin.active")</span>
                                    @else
                                    <span class="badge bg-danger">@lang("admin.dis_active")</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div class="row mb-3 text-end ">
        <div>
            <a href="{{ route('admin.badal.substitutes.index') }}" class="btn btn-outline-primary waves-effect waves-light btn-sm">@lang('button.cancel')</a>
        </div>
    </div>

</div>
</div>

@endsection
