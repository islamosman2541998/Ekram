@extends('admin.app')

@section('title', trans('volunteers.create'))
@section('title_page', trans('volunteers.volunteers'))
@section('title_route', route('admin.volunteers.index'))
@section('button_page')
<a href="{{ route('admin.volunteers.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('tell/intlTelInput.css') }}" />
@livewireStyles
@endsection

@section('content')

<div class="card">
    <form action="{{ route('admin.volunteers.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row d-flex justify-content-center ">
            <div class="col-md-6 ">
                <div class="mt-4 mb-4 accordion" id="accordionAccount">
                    <div class="border rounded accordion-item">
                        <h2 class="accordion-header" id="headingAccount">
                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAccount" aria-expanded="true" aria-controls="collapseAccount">
                                @lang('volunteers.volunteers')
                            </button>
                        </h2>
                        <div id="collapseAccount" class="mt-3 accordion-collapse collapse show" aria-labelledby="headingAccount" data-bs-parent="#accordionAccount">
                            <div class="accordion-body">
                                <livewire:admin.accounts.create />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 mb-4 accordion" id="accordionRewards">
                    <div class="border rounded accordion-item">
                        <h2 class="accordion-header" id="headingRewards">
                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRewards" aria-expanded="true" aria-controls="collapseRewards">
                                @lang('volunteers.evaluation')
                            </button>
                        </h2>
                        <div id="collapseRewards" class="mt-3 accordion-collapse collapse show" aria-labelledby="headingRewards" data-bs-parent="#accordionRewards">
                            <div class="accordion-body">

                                {{-- medal ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">{{ trans('volunteers.medal') }}</label>
                                    <div class="col-sm-9">
                                        <select name="medal" class="form-control">
                                        <option value=""></option>
                                            <option value="1" @if(old('medal') == "1") selected @endif> gold </option>
                                            <option value="2" @if(old('medal') == "2") selected @endif> sliver  </option>
                                            <option value="3" @if(old('medal') == "3") selected @endif> Bronze Medal  </option>
                                        </select>
                                        {{-- <input class="form-control" type="number" value="{{ old('medal')}}" name="medal"> --}}
                                    </div>
                                </div>
                                {{-- working_hours ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">{{ trans('volunteers.working_hours') }}</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="number" value="{{ old('working_hours') }}" name="working_hours">
                                    </div>
                                </div>
                                {{-- effective ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">{{ trans('volunteers.effective_rate') }} % </label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="number" value="{{ old('effective') }}" name="effective">
                                    </div>
                                </div>
                                {{-- activity ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">{{ trans('volunteers.activity') }} </label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" value="{{ old('activity') }}" name="activity">
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

                                {{-- name ------------------------------------------------------------------------------------- --}}
                                <div class="col-12 mt-3">
                                    <div class="row mb-3">
                                        <labe> @lang('volunteers.name')</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" placeholder="@lang('volunteers.name')" name="name" value="{{ old('name') }}">
                                            </div>
                                    </div>
                                </div>

                                {{-- identity ------------------------------------------------------------------------------------- --}}
                                <div class="col-12 mt-3">
                                    <div class="row mb-3">
                                        <labe> @lang('volunteers.identity')</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" placeholder="@lang('volunteers.identity')" name="identity" value="{{ old('identity') }}">
                                            </div>
                                    </div>
                                </div>

                                {{-- Type ------------------------------------------------------------------------------------- --}}
                                <div class="row">
                                    <div class="col-md-2">
                                        <label> @lang('volunteers.type') :</label>
                                    </div>
                                    <div class="col-md-10">
                                        <select name="type" class="form-control" id="type" required>
                                            <option value="" selected disabled> </option>
                                            <option value="volunteer" {{ old('type') == "volunteer" ? 'selected' : '' }}>@lang('volunteers.individual') </option>
                                            <option value="team" {{ old('type') == "team" ? 'selected' : '' }}> @lang('volunteers.team') </option>
                                        </select>
                                    </div>
                                </div>

                                {{-- team_name ------------------------------------------------------------------------------------- --}}
                                {{-- <div id="team-container" class="d-none">
                                    <div class="col-12 mt-4">
                                        <div class="row mb-3">
                                            <labe> @lang('volunteers.team_name')</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control team-inputs" required type="text" placeholder="@lang('volunteers.team_name')" name="team_name" value="{{ old('team_name') }}">
                                                </div>
                                        </div>
                                    </div> --}}
                                    {{-- team logo ------------------------------------------------------------------------------------- --}}
                                    {{-- <div class="col-12 mt-3">
                                        <div class="row mb-3">
                                            <labe> @lang('volunteers.team_logo')</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control team-inputs" type="file" placeholder="@lang('volunteers.team_logo')" name="team_logo" value="{{ old('team_logo') }}">
                                                </div>
                                        </div>
                                    </div>
                                </div> --}}


                                {{-- image ------------------------------------------------------------------------------------- --}}
                                <div class="col-12 mt-3">
                                    <div class="row mb-3">
                                        <label>
                                            @lang('admin.image')</label>
                                        <div class="col-sm-12">
                                            <input class="form-control" type="file" placeholder="@lang('admin.image')" name="image" value="{{ old('image') }}">
                                        </div>
                                    </div>
                                </div>
                                {{-- nationality ------------------------------------------------------------------------------------- --}}
                                <div class="col-12 mt-3">
                                    <div class="row mb-3">
                                        <labe> @lang('volunteers.nationality')</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" placeholder="@lang('volunteers.nationality')" name="nationality" value="{{ old('nationality') }}">
                                            </div>
                                    </div>
                                </div>
                                {{-- Gender ------------------------------------------------------------------------------------- --}}
                                <div class="col-12">
                                    <label class="col-sm-12 col-form-label">@lang('volunteers.gender') :</label>
                                    <div class="col-sm-10">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <input type="radio" id="gender1" name="gender" value="1" {{ old('gender') == 1 ? 'checked' : '' }}>
                                                <label for="gender1">@lang('volunteers.female')</label>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="radio" id="gender2" name="gender" value="2" {{ old('gender') == 2 ? 'checked' : '' }}>
                                                <label for="gender2">@lang('volunteers.male')</label>
                                            </div>
                                        </div>
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
            <div class="row mb-3 text-end ">
                <div>
                    <a href="{{ route('admin.volunteers.index') }}" class="btn btn-outline-primary waves-effect waves-light btn-sm">@lang('button.cancel')</a>
                    <button type="submit" id="submit" class="btn btn-outline-success waves-effect waves-light btn-sm">@lang('button.save')</button>
                    <button type="submit" name="submit" value="new" id="submit" class="btn btn-outline-success waves-effect waves-light btn-sm">@lang('button.save_new')</button>
                </div>
            </div>

        </div>

    </form>
</div>
@endsection

@section('script')

<script>
    const selectElement = document.getElementById('type');
    const teamDiv = document.getElementById('team-container');

    selectElement.addEventListener('change', () => {
        const selectedValue = selectElement.value;

        teamDiv.classList.remove('d-none');

        if (selectedValue === 'team') {
            teamDiv.classList.remove('d-none');
        } else {
            teamDiv.classList.add('d-none');
            const teamInputs = document.querySelectorAll('.team-inputs');
            teamInputs.forEach(teamInput => {
                teamInput.removeAttribute('required');
            });
        }
    });

</script>


<script src="{{ asset('tell/intlTelInput.js') }}"></script>
<script>
    var input = document.querySelector("#phone");
    var validMsg = document.querySelector("#valid-msg");
    var errorMsg = document.querySelector("#error-msg");
    var buttonSbmit = document.getElementById("submit");
    var errorMap = [`{{ trans('admin.Invalid_number') }}`, `{{ trans('admin.Invalid_country_code') }}`, `{{ trans('admin.Too_short') }}`, `{{ trans('admin.Too_long') }}`];
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

<!--tinymce js-->
<script src="{{ asset('admin/assets/libs/tinymce/tinymce.min.js') }}"></script>

<!-- init js -->
<script src="{{ asset('admin/assets/js/pages/form-editor.init.js') }}"></script>

@livewireScripts

@endsection
