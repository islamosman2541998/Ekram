@extends('admin.app')

@section('title', trans('volunteers.show_volunteer'))
@section('title_page', trans('volunteers.volunteers'))
@section('title_route', route('admin.volunteers.index'))
@section('button_page')
    <a href="{{ route('admin.volunteers.index') }}"
        class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('tell/intlTelInput.css') }}" />
@endsection

@section('content')

    <div class="card">

        <div class="row d-flex justify-content-center">
            <div class="col-md-6">

                <div class="accordion mt-4 mb-4" id="accordionExample">
                    <div class="accordion-item border rounded">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne1" aria-expanded="true" aria-controls="collapseOne1">
                                <span class=" text-primary "> {{ $volunteer->name }}</span>
                            </button>
                        </h2>
                        <div id="collapseOne1" class="accordion-collapse collapse show mt-3" aria-labelledby="headingOne"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">

                                <div class="row mb-3">
                                    <label for="example-text-input"
                                        class="col-sm-3 col-form-label">{{ trans('volunteers.user_name') }}</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" disabled type="text" name="user_name"
                                            value="{{ $volunteer->account->user_name }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="example-tel-input"
                                        class="col-sm-3 col-form-label">{{ trans('volunteers.mobile') }}</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" disabled type="tel"
                                            value="{{ $volunteer->account->mobile }}" name="mobile">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="example-email-input"
                                        class="col-sm-3 col-form-label">{{ trans('volunteers.email') }}</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" disabled type="email"
                                            value="{{ $volunteer->account->email }}" name="email">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- Start Info User --}}
                <div class="mt-4 mb-4 accordion" id="accordionRewards">
                    <div class="border rounded accordion-item">
                        <h2 class="accordion-header" id="headingRewards">
                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseRewards" aria-expanded="true" aria-controls="collapseRewards">
                                @lang('volunteers.evaluation')
                            </button>
                        </h2>
                        <div id="collapseRewards" class="mt-3 accordion-collapse collapse show"
                            aria-labelledby="headingRewards" data-bs-parent="#accordionRewards">
                            <div class="accordion-body">

                                {{-- medal ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">{{ trans('volunteers.medal') }}</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="number" value="{{ $volunteer->medal }}"
                                            name="medal" disabled>
                                    </div>
                                </div>
                                {{-- working_hours ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">{{ trans('volunteers.working_hours') }}</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="number" value="{{ $volunteer->working_hours }}"
                                            name="working_hours" disabled>
                                    </div>
                                </div>
                                {{-- effective ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">{{ trans('volunteers.effective_rate') }} %
                                    </label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="number" value="{{ $volunteer->effective }}"
                                            name="effective" disabled>
                                    </div>
                                </div>
                                {{-- activity ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">{{ trans('volunteers.activity') }} </label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" value="{{ $volunteer->activity }}"
                                            name="activity" disabled>
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
                            <button class="accordion-button fw-medium " type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                {{ trans('admin.settings') }}
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="row mb-3">
                                    <label for="example-text-input"
                                        class="col-sm-3 col-form-label">{{ trans('volunteers.name') }}</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" disabled type="text" name="name"
                                            value="{{ $volunteer->name }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">{{ trans('volunteers.identity') }}</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" disabled type="text"
                                            value="{{ $volunteer->identity }}" name="identity">

                                    </div>
                                </div>

                                {{-- Type ------------------------------------------------------------------------------------- --}}
                                <div class="row">
                                    <div class="col-md-3">
                                        <label> @lang('volunteers.type') </label>
                                    </div>
                                    <div class="col-md-9">
                                        <select name="type" class="form-control" id="type" disabled>
                                            <option value="" disabled> </option>
                                            <option value="volunteer"
                                                {{ $volunteer->type == 'volunteer' ? 'selected' : '' }}>@lang('volunteers.individual')
                                            </option>
                                            <option value="team" {{ $volunteer->type == 'team' ? 'selected' : '' }}>
                                                @lang('volunteers.team') </option>
                                        </select>
                                    </div>
                                </div>
                                {{-- nationality ------------------------------------------------------------------------------------- --}}
                                <div class="row my-3">
                                    <label class="col-md-3 col-form-label">{{ trans('volunteers.nationality') }}</label>
                                    <div class="col-md-9">
                                        <input class="form-control" disabled type="text"
                                            value="{{ $volunteer->nationality }}" name="nationality">
                                        @error('nationality')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- date_of_birth ------------------------------------------------------------------------------------- --}}
                                <div class="row my-3">
                                    <label class="col-md-3 col-form-label">{{ trans('volunteers.date_of_birth') }}</label>
                                    <div class="col-md-9">
                                        <input class="form-control" disabled type="text"
                                            value="{{ $volunteer->date_of_birth }}" name="date_of_birth">
                                    </div>
                                </div>

                                {{-- educational_qualification ------------------------------------------------------------------------------------- --}}
                                <div class="row my-3">
                                    <label
                                        class="col-md-3 col-form-label">{{ trans('volunteers.educational_qualification') }}</label>
                                    <div class="col-md-9">
                                        <input class="form-control" disabled type="text"
                                            value="{{ $volunteer->educational_qualification }}"
                                            name="educational_qualification">
                                    </div>
                                </div>

                                {{-- preferred_fields ------------------------------------------------------------------------------------- --}}
                                <div class="row my-3">
                                    <label
                                        class="col-md-3 col-form-label">{{ trans('volunteers.preferred_fields') }}</label>
                                    <div class="col-md-9">
                                        <input class="form-control" disabled type="text"
                                            value="{{ implode(', ', json_decode($volunteer->preferred_fields ?? '[]')) }}"
                                            name="preferred_fields">
                                    </div>
                                </div>

                                {{-- preferred_times ------------------------------------------------------------------------------------- --}}
                                <div class="row my-3">
                                    <label
                                        class="col-md-3 col-form-label">{{ trans('volunteers.preferred_times') }}</label>
                                    <div class="col-md-9">
                                        <input class="form-control" disabled type="text"
                                            value="{{ implode(', ', json_decode($volunteer->preferred_times ?? '[]')) }}"
                                            name="preferred_times">
                                    </div>
                                </div>

                                {{-- goal ------------------------------------------------------------------------------------- --}}
                                <div class="row my-3">
                                    <label class="col-md-3 col-form-label">{{ trans('volunteers.goal') }}</label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" disabled name="goal">{{ $volunteer->goal }}</textarea>
                                    </div>
                                </div>


                                <div id="team-container" class="d-none">
                                    <hr>
                                    {{-- team_name ------------------------------------------------------------------------------------- --}}
                                    {{-- <div class="row mt-3">
                                    <label class="col-sm-3 col-form-label">{{ trans('volunteers.team_name') }}</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" disabled type="text" value="{{ $volunteer->team_name }}" name="team_name">
                                        @error('team_name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row my-3">
                                    <label class="col-sm-3 col-form-label">{{ trans('volunteers.team_name') }}</label>
                                    <div class="col-sm-3 my-3">
                                        @if ($volunteer->team_logo != null)
                                        <img src="{{ getImageThumb($volunteer->team_logo) }}" alt="" style="width:100%">
                                        @endif
                                    </div>
                                    <hr> --}}
                                </div>
                                <div class="row">
                                    <div class="col-12  mb-3">
                                        @if ($volunteer->image != null)
                                            <a href="{{ getImage($volunteer->image) }}">
                                                <img src="{{ getImageThumb($volunteer->image) }}" alt=""
                                                    class="rounded" width="150px">
                                            </a>
                                        @endif
                                    </div>

                                    <div class="col-12 col-lg-6 mb-3">
                                        <label class="col-sm-12 col-form-label" for="available">@lang('volunteers.gender') : <span
                                                class="text-primary h5">
                                                {{ @$volunteer->gender == 1 ? trans('volunteers.female') : trans('volunteers.male') }}</span>
                                        </label>
                                    </div>
                                </div>
                                {{-- Status ------------------------------------------------------------------------------------- --}}
                                <div class="col-12">
                                    <label class="col-form-label" for="available">{{ trans('admin.status') }} :
                                        @if ($volunteer->status == 1)
                                            <p class="badge  bg-success h3" style="font-size:20px">@lang('admin.active')</p>
                                        @else
                                            <p class="badge  bg-danger h3" style="font-size:20px">@lang('admin.dis_active')</p>
                                        @endif
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3 text-end">
            <div>
                <a href="{{ route('admin.volunteers.index') }}"
                    class="btn btn-outline-primary waves-effect waves-light  btn-sm">@lang('button.cancel')</a>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('script')
    <script>
        const selectElement = document.getElementById('type');
        const teamDiv = document.getElementById('team-container');

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
    </script>

@endsection
