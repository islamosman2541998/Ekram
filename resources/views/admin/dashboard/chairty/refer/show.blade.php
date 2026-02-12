@extends('admin.app')

@section('title', trans('refer.show_refer'))
@section('title_page', trans('refer.refers'))
@section('title_route', route('admin.charity.refers.index'))
@section('button_page')
    <a href="{{ route('admin.charity.refers.index') }}"
        class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection


@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row d-flex justify-content-center ">
                <div class="col-md-12 p-3">
                    <div class="accordion mt-4 mb-4 " id="accordionExampleInfo">
                        <div class="accordion-item border rounded ">
                            <h2 class="accordion-header" id="headingInfo">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseInfo" aria-expanded="true" aria-controls="collapseInfo">
                                    {{ trans('refer.info_refer') }}
                                </button>
                            </h2>
                            <div id="collapseInfo" class="accordion-collapse collapse show mt-3"
                                aria-labelledby="headingInfo" data-bs-parent="#accordionExampleInfo">
                                <div class="accordion-body">
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <label for="example-text-input"
                                                class="col-sm-12 col-form-label">{{ trans('refer.name') }}</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" disabled type="text" name="name"
                                                    value="{{ $refer->name }}">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label for="example-slug-input"
                                                class="col-sm-12 col-form-label">{{ trans('refer.slug') }}</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" disabled type="text" name="slug"
                                                    value="{{ $refer->slug }}">
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label for="example-username-input"
                                                class="col-sm-12 col-form-label">{{ trans('refer.username') }}</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" disabled type="text"
                                                    value="{{ $refer->account->user_name }}" name="user_name">
                                            </div>
                                        </div>
                                        {{-- mobile ------------------------------------------------------------------------------------- --}}
                                        <div class="col-6">
                                            <label for="example-mobile-input"
                                                class="col-sm-12 col-form-label">{{ trans('refer.mobile') }}</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" disabled type="tel" name="mobile"
                                                    value="{{ $refer->account->mobile }}">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            {{-- Managers --}}
                                            <div class="mb-3">
                                                <label class="form-label h4 pt-3">المدير</label>
                                                @if ($refer->managers->isNotEmpty())
                                                    {{-- <ul class="list- mb-2">
                                                        @foreach ($refer->managers as $manager)
                                                            <li class="mb-2">
                                                                <strong>{{$refer->manager->first()->name }}</strong>
                                                            </li>
                                                        @endforeach
                                                    </ul> --}}
                                                    <li class="mb-2">
                                                        <strong>{{ $refer->managers->first()->name }}</strong>

                                                    </li>
                                                @else
                                                    <p class="text-muted">لا يوجد Managers تابعين لهذا المسوّق.</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            {{-- Supervisors (group managers parents) --}}
                                            <div class="mb-3">
                                                <label class="form-label  h4 pt-3">المشرف </label>
                                                @if (isset($supervisors) && $supervisors->isNotEmpty())
                                                    <ul class="list- mb-2">
                                                        @foreach ($supervisors as $sup)
                                                            <li class="mb-2">
                                                                <strong>{{ $sup->name }}</strong>

                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <p class="text-muted">لا يوجد مشرفين تابعين لهذا المسوّق.</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>




                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="accordion mt-4 mb-4" id="accordionExampleSetting">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingSetting">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseSetting" aria-expanded="true" aria-controls="collapseSetting">
                                    {{ trans('admin.settings') }}
                                </button>
                            </h2>
                            <div id="collapseSetting" class="accordion-collapse collapse show"
                                aria-labelledby="headingSetting" data-bs-parent="#accordionExampleSetting">
                                <div class="accordion-body">

                                    <div class="row mt-2">
                                        {{-- employee_name ------------------------------------------------------------------------------------- --}}
                                        <div class="col-6">
                                            <label for="example-employee_name-input"
                                                class="col-sm-12 col-form-label">{{ trans('refer.employee_name') }}</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" disabled type="text" name="employee_name"
                                                    value="{{ $refer->employee_name }}">
                                            </div>
                                        </div>
                                        {{-- employee_number ------------------------------------------------------------------------------------- --}}
                                        <div class="col-6">
                                            <label for="example-employee_number-input"
                                                class="col-sm-12 col-form-label">{{ trans('refer.employee_number') }}</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" disabled type="text" name="employee_number"
                                                    value="{{ $refer->employee_number }}">
                                            </div>
                                        </div>

                                        {{-- email ------------------------------------------------------------------------------------- --}}
                                        <div class="col-6">
                                            <label for="example-email-input"
                                                class="col-sm-12 col-form-label">{{ trans('refer.email') }}</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" disabled type="email" name="email"
                                                    value="{{ $refer->account->email }}">
                                            </div>
                                        </div>
                                        {{-- employee_department ------------------------------------------------------------------------------------- --}}
                                        <div class="col-6">
                                            <label for="example-employee_department-input"
                                                class="col-sm-12 col-form-label">{{ trans('refer.employee_department') }}</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" disabled type="text"
                                                    name="employee_department" value="{{ $refer->employee_department }}">
                                            </div>
                                        </div>

                                        {{-- ax_store_name ------------------------------------------------------------------------------------- --}}
                                        <div class="col-6">
                                            <label for="example-ax_store_name-input"
                                                class="col-sm-12 col-form-label">{{ trans('refer.ax_store_name') }}</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" disabled type="text" name="ax_store_name"
                                                    value="{{ $refer->ax_store_name }}">
                                            </div>
                                        </div>
                                        {{-- job ------------------------------------------------------------------------------------- --}}
                                        <div class="col-6">
                                            <label for="example-job-input"
                                                class="col-sm-12 col-form-label">{{ trans('refer.job') }}</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" disabled type="text" name="job"
                                                    value="{{ $refer->job }}">
                                            </div>
                                        </div>

                                        {{-- whatsapp ------------------------------------------------------------------------------------- --}}
                                        <div class="col-6">
                                            <label for="example-whatsapp-input"
                                                class="col-sm-12 col-form-label">{{ trans('refer.whatsapp') }}</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" disabled type="tel" name="whatsapp"
                                                    value="{{ $refer->whatsapp }}">
                                            </div>
                                        </div>

                                        {{-- location ------------------------------------------------------------------------------------- --}}
                                        <div class="col-6">
                                            <label for="example-location-input"
                                                class="col-sm-12 col-form-label">{{ trans('refer.location') }}</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" disabled type="text" name="location"
                                                    value="{{ $refer->location }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        {{-- details ------------------------------------------------------------------------------------- --}}
                                        <div class="col-6 mt-2">
                                            <div class="row mb-3">
                                                <label for="example-details-input" col-form-label>
                                                    @lang('refer.details')</label>
                                                <div class="col-sm-12">
                                                    <textarea name="details" disabled class="form-control" cols="30" rows="10">{{ $refer->details }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="row">

                                                {{-- employee_image ------------------------------------------------------------------------------------- --}}
                                                <div class="col-6">
                                                    <img src="{{ getImageThumb($refer->employee_image) }}" alt=""
                                                        style="width:100%">
                                                </div>
                                                {{-- Status ------------------------------------------------------------------------------------- --}}
                                                <div class="col-sm-6 mt-2">
                                                    <label class="form-check-label"
                                                        for="flexSwitchCheckSuccessStatus">@lang('admin.status')</label>
                                                    @if ($refer->status == 1)
                                                        <span class="badge bg-success">@lang('admin.active')</span>
                                                    @else
                                                        <span class="badge bg-danger">@lang('admin.dis_active')</span>
                                                    @endif
                                                </div>
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
                        <a href="{{ route('admin.charity.refers.index') }}"
                            class="btn btn-outline-primary waves-effect waves-light btn-sm">@lang('button.cancel')</a>
                        <button type="submit" id="submit"
                            class="btn btn-outline-success waves-effect waves-light btn-sm">@lang('button.save')</button>
                        <button type="submit" name="submit" value="update"
                            class="btn btn-outline-success waves-effect waves-light  btn-sm">@lang('button.save_update')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
