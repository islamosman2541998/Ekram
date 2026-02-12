@extends('admin.app')

@section('title', trans('substitutes.create_substitute'))
@section('title_page', trans('substitutes.substitutes'))
@section('title_route', route('admin.badal.substitutes.index') )
@section('button_page')
<a href="{{ route('admin.badal.substitutes.index') }}" class="btn btn-outline-success btn-sm">@lang('button.cancel')</a>
@endsection

@section('style')
    @livewireStyles
@endsection

@section('content')

<div class="card">
    <form action="{{ route('admin.badal.substitutes.store') }}" method="post" enctype="multipart/form-data" id="form-submit">
        @csrf
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
                                <livewire:admin.accounts.create  />
                            </div>
                        </div>
                    </div>
                </div>
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
                                        <input class="form-control @error('full_name') is-invalid @enderror" type="text" name="full_name" value="{{ old('full_name') }}">
                                        @error('full_name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="example-text-input" class="col-sm-12 col-form-label"> @lang('substitutes.identity') </label>
                                        <input class="form-control @error('identity') is-invalid @enderror" type="text" name="identity" value="{{ old('identity') }}">
                                        @error('identity')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="example-text-input" class="col-sm-12 col-form-label"> @lang('substitutes.nationality') </label>
                                        <input class="form-control @error('nationality') is-invalid @enderror" type="text" name="nationality" value="{{ old('nationality') }}">
                                        @error('nationality')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="example-mobile-input" class="col-sm-12 col-form-label"> @lang('substitutes.gender') </label>
                                        <select name="gender" class="form-control select2 @error('gender') is-invalid @enderror">
                                            <option value="" selected disabled></option>
                                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}> Male </option>
                                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}> Female </option>
                                        </select>
                                        @error('gender')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="example-mobile-input" class="col-sm-12 col-form-label"> @lang('substitutes.languages') </label>
                                        <select name="languages[]" class="form-control select2 @error('languages') is-invalid @enderror" multiple>
                                            @foreach (App\Enums\LanguagesEnum::values() as $type)
                                            <option value="{{ $type }}" {{ in_array($type, old('languages') ?? [] )  ? 'selected' : '' }}>
                                                {{ $type}}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('languages')
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
                                @lang('admin.settings')
                            </button>
                        </h2>
                        <div id="collapseSetting" class="accordion-collapse collapse show" aria-labelledby="headingSetting" data-bs-parent="#accordionExampleSetting">
                            <div class="accordion-body" style="height: 219px;">
                                {{-- image ------------------------------------------------------------------------------------- --}}
                                <div class="col-12">
                                    <div class="row mb-3">
                                        <label for="example-image-input" col-form-label>
                                            @lang('admin.image')</label>
                                        <div class="col-sm-12">
                                            <input class="form-control @error('image') is-invalid @enderror" type="file" placeholder="@lang('admin.image')" id="example-image-input" name="image" value="{{ old('image') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    {{-- proportion ------------------------------------------------------------------------------------- --}}
                                    <div class="col-sm-6 mt-3">
                                        <label for="example-proportion-input" col-form-label>
                                            @lang('substitutes.proportion')
                                        </label>
                                        <div class="col-sm-12">
                                            <input class="form-control @error('proportion') is-invalid @enderror" type="number" step="any" placeholder="@lang('substitutes.proportion')" id="example-proportion-input" name="proportion" value="{{ old('proportion') }}">
                                            @if ($errors->has('proportion'))
                                            <span class="missiong-spam">{{ $errors->first('proportion') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- Status ------------------------------------------------------------------------------------- --}}
                                    <div class="col-sm-6 mt-3">
                                        <label class="form-check-label" for="flexSwitchCheckSuccessStatus">@lang('admin.status')</label>
                                        <div class="form-check form-switch form-check-success">
                                            <input class="form-check-input @error('status') is-invalid @enderror" type="checkbox" role="switch" name="status" {{  old('status') == "on" ? 'checked' : '' }} id="flexSwitchCheckSuccessStatus">
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


            <div class="row mb-3 text-end ">
                <div>
                    <a href="{{ route('admin.badal.substitutes.index') }}" class="btn btn-outline-primary waves-effect waves-light btn-sm">@lang('button.cancel')</a>
                    <button type="submit" id="submit" class="btn btn-outline-success waves-effect waves-light btn-sm ">@lang('button.save')</button>
                    <button type="submit" name="submit" value="new" id="submit" class="btn btn-outline-success waves-effect waves-light btn-sm">@lang('button.save_new')</button>
                </div>
            </div>

        </div>
    </form>
</div>

@endsection





@section('script')
    @livewireScripts
@endsection
