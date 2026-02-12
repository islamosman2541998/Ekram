@extends('admin.app')

@section('title', trans('volunteers.edit_volunteers'))
@section('title_page', trans('volunteers.volunteers'))
@section('title_route', route('admin.volunteers.index') )
@section('button_page')
<a href="{{ route('admin.volunteers.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('tell/intlTelInput.css') }}" />
@endsection


@section('content')
<div class="card">
    <form action="{{ route('admin.volunteers.update', $volunteer->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="account_id" value="{{ $volunteer->account->id }}">
        <input type="hidden" name="id" value="{{ $volunteer->id }}">
        <div class="row d-flex justify-content-center">
            <div class="col-md-6">
                {{-- Start Info User --}}
                <div class="mt-4 mb-4 accordion" id="accordionAccount">
                    <div class="border rounded accordion-item">
                        <h2 class="accordion-header" id="headingAccount">
                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAccount" aria-expanded="true" aria-controls="collapseAccount">
                                @lang('volunteers.volunteers')
                            </button>
                        </h2>
                        <div id="collapseAccount" class="mt-3 accordion-collapse collapse show" aria-labelledby="headingAccount" data-bs-parent="#accordionAccount">
                            <div class="accordion-body">
                                <livewire:admin.accounts.create :id="$volunteer->account->id" />
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Start Info User --}}
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
                                            <option value="1" @if(old('medal')=="1" ) selected @endif> gold </option>
                                            <option value="2" @if(old('medal')=="2" ) selected @endif> sliver </option>
                                            <option value="3" @if(old('medal')=="3" ) selected @endif> Bronze Medal </option>
                                        </select>
                                        {{-- <input class="form-control" type="number" value="{{ old('medal')}}" name="medal"> --}}
                                    </div>
                                </div>
                                {{-- working_hours ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">{{ trans('volunteers.working_hours') }}</label>
                                    <div class="col-sm-9">
                                        <input class="form-control @error('working_hours') is-invalid @enderror" type="number" value="{{ $volunteer->working_hours }}" name="working_hours">
                                        @error('working_hours')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- effective ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">{{ trans('volunteers.effective_rate') }} % </label>
                                    <div class="col-sm-9">
                                        <input class="form-control @error('effective') is-invalid @enderror" type="number" value="{{ $volunteer->effective }}" name="effective">
                                        @error('effective')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- activity ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">{{ trans('volunteers.activity') }} </label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" value="{{ $volunteer->activity }}" name="activity">
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
                            <button class="accordion-button fw-medium " type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                {{ trans('admin.settings') }}
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-3 col-form-label">{{ trans('volunteers.name') }}</label>
                                    <div class="col-sm-9">
                                        <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ $volunteer->name }}">
                                        @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">{{ trans('volunteers.identity') }}</label>
                                    <div class="col-sm-9">
                                        <input class="form-control @error('identity') is-invalid @enderror" type="text" value="{{ $volunteer->identity }}" name="identity">
                                        @error('identity')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Type ------------------------------------------------------------------------------------- --}}
                                <div class="row">
                                    <div class="col-md-3">
                                        <label> @lang('volunteers.type') </label>
                                    </div>
                                    <div class="col-md-9">
                                        <select name="type" class="form-control" id="type" required>
                                            <option value="" disabled> </option>
                                            <option value="volunteer" {{  $volunteer->type  == "volunteer" ? 'selected' : '' }}>@lang('volunteers.individual') </option>
                                            <option value="team" {{ $volunteer->type  == "team" ? 'selected' : '' }}> @lang('volunteers.team') </option>
                                        </select>
                                    </div>
                                </div>


                                {{-- team_name ------------------------------------------------------------------------------------- --}}
                                {{-- team logo ------------------------------------------------------------------------------------- --}}
                                {{-- <div id="team-container" class="d-none">
                                    <hr>

                                    <div class="row mt-3">
                                        <label class="col-sm-3 col-form-label">{{ trans('volunteers.team_name') }}</label>
                                <div class="col-sm-9">
                                    <input class="form-control @error('team_name') is-invalid @enderror" type="text" value="{{ $volunteer->team_name }}" name="team_name">
                                    @error('team_name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-3 mt-3">
                                @if ($volunteer->team_logo != null)
                                <img src="{{ getImageThumb($volunteer->team_logo) }}" alt="" style="width:100%">
                                @endif
                            </div>
                            <div class="col-12 mt-3">
                                <div class="row mb-3">
                                    <labe> @lang('volunteers.team_logo')</label>
                                        <div class="col-sm-12">
                                            <input class="form-control team-inputs" type="file" placeholder="@lang('volunteers.team_logo')" name="team_logo" value="{{ old('team_logo') }}">
                                        </div>
                                </div>
                            </div>
                            <hr>
                        </div> --}}

                        <div class="row my-3">
                            <div class="col-md-3">
                                <label for="example-number-input" col-form-label> @lang('admin.image')</label>
                            </div>
                            <div class="col-12 col-lg-6 mb-3">
                                {{-- image ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <div class="col-sm-12">
                                            <input class="form-control" type="file" placeholder="@lang('admin.image')" id="example-number-input" name="image" value="{{ old('image') }}">
                                        </div>
                                    </div>
                            </div>
                            <div class="col-12 col-lg-3 mb-3">
                                    @if ($volunteer->image != null)
                                    <img src="{{ getImageThumb($volunteer->image) }}" class="rounded" alt="" style="width:100%">
                                    @endif
                            </div>
                            
                        </div>




                        {{-- nationality ------------------------------------------------------------------------------------- --}}
                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label">{{ trans('volunteers.nationality') }}</label>
                            <div class="col-md-9">
                                <input class="form-control @error('nationality') is-invalid @enderror" type="text" value="{{ $volunteer->nationality }}" name="nationality">
                                @error('nationality')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        {{-- Gender ------------------------------------------------------------------------------------- --}}
                        <div class="col-12">
                            <label class="col-sm-12 col-form-label" for="available">@lang('volunteers.gender') :</label>
                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-md-3">
                                        <input type="radio" id="gender1" name="gender" value="1" {{ @$volunteer->gender == 1 ? 'checked' : '' }}>
                                        <label for="gender1">@lang('volunteers.female')</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="radio" id="gender2" name="gender" value="2" {{ @$volunteer->gender == 2 ? 'checked' : '' }}>
                                        <label for="gender2">@lang('volunteers.male')</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- status ------------------------------------------------------------------------------------- --}}
                        <div class="col-sm-12 mt-3">
                            <label class="form-check-label" for="flexSwitchCheckSuccessStatus">@lang('admin.status')</label>
                            <div class="form-check form-switch form-check-success">
                                <input class="form-check-input {{ (empty($errors->first('status'))) ?: 'has-error'}}" type="checkbox" role="switch" name="status" {{  $volunteer->status == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessStatus">
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
<div class="row mb-3 text-end">
    <div>
        <a href="{{ route('admin.volunteers.index') }}" class="btn btn-outline-primary waves-effect waves-light  btn-sm">@lang('button.cancel')</a>
        <button type="submit" id="submit" class="btn btn-outline-success waves-effect waves-light  btn-sm">@lang('button.save')</button>
        <button type="submit" name="submit" value="update" class="btn btn-outline-success waves-effect waves-light  btn-sm">@lang('button.save_update')</button>
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

    teamDiv.classList.remove('d-none');
    const selectedValue = selectElement.value;

    if (selectedValue === 'team') {
        teamDiv.classList.remove('d-none');
    } else {
        teamDiv.classList.add('d-none');
        const teamInputs = document.querySelectorAll('.team-inputs');
        teamInputs.forEach(teamInput => {
            teamInput.removeAttribute('required');
        });
    }

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
<!--tinymce js-->
<script src="{{ asset('admin/assets/libs/tinymce/tinymce.min.js') }}"></script>

<!-- init js -->
<script src="{{ asset('admin/assets/js/pages/form-editor.init.js') }}"></script>

@endsection
