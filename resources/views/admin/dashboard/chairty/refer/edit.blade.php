@extends('admin.app')

@section('title', trans('refer.edit_refer'))
@section('title_page', trans('refer.refers'))
@section('title_route', route('admin.charity.refers.index'))
@section('button_page')
    <a href="{{ route('admin.charity.refers.index') }}"
        class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection


@section('style')
    @livewireStyles
    <link rel="stylesheet" href="{{ asset('tell/intlTelInput.css') }}" />
@endsection


@section('content')

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.charity.refers.update', $refer->id) }}" method="post" enctype="multipart/form-data"
                id="form-submit">
                @csrf
                @method('put')
                <input type="hidden" name="account_id" value="{{ $refer->account->id }}">
                <input type="hidden" name="id" value="{{ $refer->id }}">

                <div class="row d-flex justify-content-center ">
                    <div class="col-12 col-md-6 p-3">
                        {{-- Start Info User --}}
                        <div class="mt-4 mb-4 accordion" id="accordionAccount">
                            <div class="border rounded accordion-item">
                                <h2 class="accordion-header" id="headingAccount">
                                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseAccount" aria-expanded="true"
                                        aria-controls="collapseAccount">
                                        @lang('vendor.info_vendor')
                                    </button>
                                </h2>
                                <div id="collapseAccount" class="mt-3 accordion-collapse collapse show"
                                    aria-labelledby="headingAccount" data-bs-parent="#accordionAccount">
                                    <div class="accordion-body">
                                        <livewire:admin.accounts.create :id="$refer->account->id" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 p-3">
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
                                                    <input class="form-control @error('name') is-invalid @enderror"
                                                        type="text" name="name" value="{{ $refer->name }}"
                                                        id="name-slug">
                                                    @error('name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <label for="example-slug-input"
                                                    class="col-sm-12 col-form-label">{{ trans('refer.slug') }}</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control @error('slug') is-invalid @enderror"
                                                        type="text" name="slug" value="{{ $refer->slug }}"
                                                        id="slug">
                                                    @error('slug')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3 pt-3">
                                            <button class="btn btn-outline-secondary btn-sm mb-2" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#managersCollapse"
                                                aria-expanded="false" aria-controls="managersCollapse">
                                                اختار المدير <span class="ms-1">▾</span>
                                            </button>

                                            <div class="collapse" id="managersCollapse">
                                                <div class="card card-body p-2">
                                                    <input type="text" id="managerSearchInput"
                                                        class="form-control form-control-sm mb-2"
                                                        placeholder="ابحث عن مدير...">

                                                    <ul class="list-unstyled mb-0" id="managerList">
                                                        @forelse($managers as $manager)
                                                            <li class="py-1">
                                                                <label class="mb-0 d-flex align-items-center gap-2">
                                                                    <input type="radio" name="manager_id"
                                                                        value="{{ $manager->id }}"
                                                                        {{ (int) old('manager_id', $selectedManager ?? 0) === (int) $manager->id ? 'checked' : '' }}>
                                                                    <span class="ms-1">{{ $manager->name }}</span>

                                                                    @if (!empty($manager->is_group_manager) && $manager->is_group_manager)
                                                                        <span class="badge bg-secondary ms-2">مشرف</span>
                                                                    @endif
                                                                </label>
                                                            </li>
                                                        @empty
                                                            <li>لا يوجد مدراء</li>
                                                        @endforelse
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3 pt-3">
                                            <button class="btn btn-outline-secondary btn-sm mb-2" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#managersCollapse1"
                                                aria-expanded="false" aria-controls="managersCollapse1">
                                                اختار المشرف <span class="ms-1">▾</span>
                                            </button>

                                            <div class="collapse" id="managersCollapse1">
                                                <div class="card card-body p-2">
                                                    <div class="mb-2 d-flex">
                                                        <input id="supervisorSearchInput" type="search"
                                                            class="form-control form-control-sm"
                                                            placeholder="ابحث باسم المشرف..."
                                                            aria-label="Search managers">
                                                        <button id="supervisorSearchClear" type="button"
                                                            class="btn btn-sm btn-outline-secondary ms-2">مسح</button>
                                                    </div>

                                                    <ul class="manager-tree list-unstyled mb-0">
                                                        @foreach ($groupManagersTree as $item)
                                                            @include(
                                                                'admin.dashboard.chairty.refer._manager_node',
                                                                [
                                                                    'item' => $item,
                                                                    'level' => 0,
                                                                    'selectedSupervisor' => old(
                                                                        'supervisor_id',
                                                                        $selectedSupervisor ?? null),
                                                                ]
                                                            )
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-check mt-3">
                                            <input class="form-check-input" type="checkbox" value="1"
                                                id="is_group_manager" name="is_group_manager"
                                                {{ old('is_group_manager', isset($refer) ? $refer->is_group_manager : false) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_group_manager">
                                                {{ __('اجعل هذا المسوّق مشرف لمسوقين ') }}
                                            </label>
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
                                        data-bs-target="#collapseSetting" aria-expanded="true"
                                        aria-controls="collapseSetting">
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
                                                    <input
                                                        class="form-control @error('employee_name') is-invalid @enderror"
                                                        type="text" name="employee_name"
                                                        value="{{ $refer->employee_name }}">
                                                    @error('employee_name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            {{-- employee_number ------------------------------------------------------------------------------------- --}}
                                            <div class="col-6">
                                                <label for="example-employee_number-input"
                                                    class="col-sm-12 col-form-label">{{ trans('refer.employee_number') }}</label>
                                                <div class="col-sm-10">
                                                    <input
                                                        class="form-control @error('employee_number') is-invalid @enderror"
                                                        type="text" name="employee_number"
                                                        value="{{ $refer->employee_number }}">
                                                    @error('employee_number')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- email ------------------------------------------------------------------------------------- --}}
                                            <div class="col-6">
                                                <label for="example-email-input"
                                                    class="col-sm-12 col-form-label">{{ trans('refer.email') }}</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control @error('email') is-invalid @enderror"
                                                        type="email" name="email"
                                                        value="{{ $refer->account->email }}">
                                                    @error('email')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            {{-- employee_department ------------------------------------------------------------------------------------- --}}
                                            <div class="col-6">
                                                <label for="example-employee_department-input"
                                                    class="col-sm-12 col-form-label">{{ trans('refer.employee_department') }}</label>
                                                <div class="col-sm-10">
                                                    <input
                                                        class="form-control @error('employee_department') is-invalid @enderror"
                                                        type="text" name="employee_department"
                                                        value="{{ $refer->employee_department }}">
                                                    @error('employee_department')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- ax_store_name ------------------------------------------------------------------------------------- --}}
                                            <div class="col-6">
                                                <label for="example-ax_store_name-input"
                                                    class="col-sm-12 col-form-label">{{ trans('refer.ax_store_name') }}</label>
                                                <div class="col-sm-10">
                                                    <input
                                                        class="form-control @error('ax_store_name') is-invalid @enderror"
                                                        type="text" name="ax_store_name"
                                                        value="{{ $refer->ax_store_name }}">
                                                    @error('ax_store_name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            {{-- job ------------------------------------------------------------------------------------- --}}
                                            <div class="col-6">
                                                <label for="example-job-input"
                                                    class="col-sm-12 col-form-label">{{ trans('refer.job') }}</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control @error('job') is-invalid @enderror"
                                                        type="text" name="job" value="{{ $refer->job }}">
                                                    @error('job')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- whatsapp ------------------------------------------------------------------------------------- --}}
                                            <div class="col-6">
                                                <label for="example-whatsapp-input"
                                                    class="col-sm-12 col-form-label">{{ trans('refer.whatsapp') }}</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control @error('whatsapp') is-invalid @enderror"
                                                        type="tel" name="whatsapp" value="{{ $refer->whatsapp }}">
                                                    @error('whatsapp')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- location ------------------------------------------------------------------------------------- --}}
                                            <div class="col-6">
                                                <label for="example-location-input"
                                                    class="col-sm-12 col-form-label">{{ trans('refer.location') }}</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control @error('location') is-invalid @enderror"
                                                        type="text" name="location" value="{{ $refer->location }}">
                                                    @error('location')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
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
                                                        <textarea name="details" class="form-control" cols="30" rows="10">{{ $refer->details }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="row">
                                                    {{-- employee_image ------------------------------------------------------------------------------------- --}}
                                                    <div class="col-6">
                                                        <label for="example-employee_image-input"
                                                            class="col-sm-12 col-form-label">{{ trans('refer.employee_image') }}</label>
                                                        <div class="col-sm-10">
                                                            <input
                                                                class="form-control @error('employee_image') is-invalid @enderror"
                                                                type="file" name="employee_image"
                                                                value="{{ $refer->employee_image }}">
                                                            @error('employee_image')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        {{-- employee_image ------------------------------------------------------------------------------------- --}}
                                                        @if ($refer->employee_image != null)
                                                            <img src="{{ getImageThumb($refer->employee_image) }}"
                                                                alt="" style="width:100%">
                                                        @endif
                                                    </div>
                                                    {{-- Status ------------------------------------------------------------------------------------- --}}
                                                    <div class="col-sm-6 mt-2">
                                                        <label class="form-check-label"
                                                            for="flexSwitchCheckSuccessStatus">@lang('admin.status')</label>
                                                        <div class="form-check form-switch form-check-success">
                                                            <input
                                                                class="form-check-input {{ empty($errors->first('status')) ?: 'has-error' }}"
                                                                type="checkbox" role="switch" name="status"
                                                                {{ $refer->status == 1 ? 'checked' : '' }}
                                                                id="flexSwitchCheckSuccessStatus">
                                                            @if ($errors->has('status'))
                                                                <span
                                                                    class="missiong-spam">{{ $errors->first('status') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    {{-- <div class="mb-3">
                                                        <h3 class="form-label">اختر المسوقين التابعين:</h3>
                                                        <div class="row">
                                                            @foreach ($allRefers as $other)
                                                                <div class="col-6 col-md-4">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            name="children[]"
                                                                            id="child_{{ $other->id }}"
                                                                            value="{{ $other->id }}"
                                                                            {{ in_array($other->id, $selectedKids ?? []) ? 'checked' : '' }}>
                                                                        <label class="form-check-label"
                                                                            for="child_{{ $other->id }}">
                                                                            {{ $other->name }}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div> --}}

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
            </form>
        </div>
    </div>

@endsection


@section('script')
    @livewireScripts
    <script src="{{ asset('tell/intlTelInput.js') }}"></script>
    <script>
        var input = document.querySelector("#phone");
        var validMsg = document.querySelector("#valid-msg");
        var errorMsg = document.querySelector("#error-msg");
        var buttonSbmit = document.getElementById("submit");
        var errorMap = [`{{ trans('admin.Invalid_number') }}`, `{{ trans('admin.Invalid_country_code') }}`,
            `{{ trans('admin.Too_short') }}`, `{{ trans('admin.Too_long') }}`
        ];
        var iti = window.intlTelInput(input, {
            initialCountry: "auto",
            geoIpLookup: function(callback) {
                $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
                    var countryCode = (resp && resp.country) ? resp.country : "";
                    callback(countryCode);
                });
            },
            utilsScript: "{{ asset('tell/utils.js') }}"

                ,
        });
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const managerSearch = document.getElementById("managerSearchInput");
            const managerListItems = document.querySelectorAll("#managerList li");

            managerSearch.addEventListener("keyup", function() {
                const filter = managerSearch.value.toLowerCase();
                managerListItems.forEach(li => {
                    const text = li.innerText.toLowerCase();
                    li.style.display = text.includes(filter) ? "" : "none";
                });
            });

            const supervisorSearch = document.getElementById("supervisorSearchInput");
            const clearBtn = document.getElementById("supervisorSearchClear");
            const treeRoot = document.querySelector("#managersCollapse1 .manager-tree");

            function filterTree(query) {
                const q = query.trim().toLowerCase();

                function processLi(li) {
                    const labelSpan = li.querySelector('label span');
                    const text = labelSpan ? labelSpan.textContent.trim().toLowerCase() : '';
                    let childMatches = false;
                    const childLis = Array.from(li.querySelectorAll(':scope > ul > li.manager-node'));
                    childLis.forEach(childLi => {
                        if (processLi(childLi)) childMatches = true;
                    });
                    const selfMatches = q === '' || text.includes(q);
                    const shouldShow = selfMatches || childMatches;
                    li.style.display = shouldShow ? '' : 'none';
                    return shouldShow;
                }
                Array.from(treeRoot.querySelectorAll(':scope > li.manager-node')).forEach(li => processLi(li));
            }

            supervisorSearch.addEventListener("input", () => filterTree(supervisorSearch.value));
            clearBtn.addEventListener("click", () => {
                supervisorSearch.value = '';
                filterTree('');
                supervisorSearch.focus();
            });
            filterTree('');
        });
    </script>

    {{-- <style>
        .manager-tree .manager-node {
            margin-bottom: .4rem;
        }

        .manager-tree .dash {
            color: #999;
            margin: 0 .15rem;
            font-weight: 600;
        }

        .level-indicator {
            margin-left: .5rem;
        }
    </style> --}}
@endsection
