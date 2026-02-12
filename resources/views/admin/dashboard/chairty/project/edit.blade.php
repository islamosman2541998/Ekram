@extends('admin.app')

@section('title', trans('charityProject.charity_edit'))
@section('title_page', trans('charityProject.charity'))
@section('title_route', route('admin.charity.projects.index'))
@section('button_page')
    <a href="{{ route('admin.charity.projects.index') }}"
        class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection

@section('content')

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.charity.projects.update', $project->id) }}" method="post"
                enctype="multipart/form-data" id="form-submit">
                @csrf
                @method('put')
                <div class="row">
                    <div class="col-md-8">
                        {{-- title - slug - description --------------------------------------------------------------------------------------- --}}
                        @foreach ($languages as $key => $locale)
                            <div class="mt-4 mb-4 accordion" id="accordionExampleNames{{ $key }}">
                                <div class="border rounded accordion-item">
                                    <h2 class="accordion-header" id="headingNames{{ $key }}">
                                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne{{ $key }}" aria-expanded="true"
                                            aria-controls="collapseOne{{ $key }}">
                                            {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                        </button>
                                    </h2>
                                    <div id="collapseOne{{ $key }}" class="mt-3 accordion-collapse collapse show"
                                        aria-labelledby="headingNames{{ $key }}"
                                        data-bs-parent="#accordionExampleNames{{ $key }}">
                                        <div class="accordion-body">
                                            {{-- title -------------------------------------------------------------------------------------   --}}
                                            <div class="mb-3 row">
                                                <label for="example-text-input"
                                                    class="col-sm-12 col-form-label">{{ trans('admin.title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text"
                                                        name="{{ $locale }}[title]"
                                                        value="{{ @$project->trans->where('locale', $locale)->first()->title }}"
                                                        id="title{{ $key }}">
                                                    @if ($errors->has($locale . '.title'))
                                                        <span
                                                            class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            {{-- slug ------------------------------------------------------------------------------------- --}}
                                            <div class="mb-3 row slug-section">
                                                <label for="example-text-input"
                                                    class="col-sm-12 col-form-label">{{ trans('admin.slug_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                </label>
                                                <div class="col-sm-12">
                                                    <input type="text" id="slug{{ $key }}"
                                                        name="{{ $locale }}[slug]"
                                                        value="{{ @$project->trans->where('locale', $locale)->first()->slug }}"
                                                        class="form-control slug" required>
                                                    @if ($errors->has($locale . '.slug'))
                                                        <span
                                                            class="missiong-spam">{{ $errors->first($locale . '.slug') }}</span>
                                                    @endif
                                                </div>
                                                @include('admin.layouts.scriptSlug')
                                                {{-- End Slug ------------------------------------------------------------------------------  --}}
                                                <div class="mt-3 row">
                                                    <label for="example-text-input" class="col-sm-12 col-form-label">
                                                        {{ trans('admin.description_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                    </label>
                                                    <div class="mb-2 col-sm-12">
                                                        <textarea id="description{{ $key }}" name="{{ $locale }}[description]" class="m-auto form-control "
                                                            style="margin-top: 10px"> {{ @$project->trans->where('locale', $locale)->first()->description }} </textarea>
                                                        @if ($errors->has($locale . '.description'))
                                                            <span
                                                                class="missiong-spam">{{ $errors->first($locale . '.description') }}</span>
                                                        @endif
                                                    </div>

                                                    <script type="text/javascript">
                                                        CKEDITOR.replace('description{{ $key }}', {
                                                            filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
                                                            filebrowserUploadMethod: 'form'
                                                        });
                                                    </script>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        {{-- Meta  ------------------------------------------------------------------------------------------------------------- --}}
                        <div class="mt-4 mb-4 accordion" id="accordionExampleMeta{{ $key }}">
                            <div class="border rounded accordion-item">
                                <h2 class="accordion-header" id="headingMeta{{ $key }}">
                                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo{{ $key }}" aria-expanded="true"
                                        aria-controls="collapseTwo{{ $key }}">
                                        @lang('admin.meta')
                                    </button>
                                </h2>
                                <div id="collapseTwo{{ $key }}" class="mt-3 accordion-collapse collapse"
                                    aria-labelledby="headingMeta{{ $key }}"
                                    data-bs-parent="#accordionExampleMeta{{ $key }}">
                                    <div class="accordion-body">

                                        @foreach ($languages as $key => $locale)
                                            {{-- meta_title_  ------------------------------------------------------------------------------------- --}}
                                            <div class="mb-3 row">
                                                <label for="example-text-input"
                                                    class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="text"
                                                        name="{{ $locale }}[meta_title]"
                                                        value="{{ @$project->trans->where('locale', $locale)->first()->meta_title }}"
                                                        id="title{{ $key }}">
                                                </div>
                                                @if ($errors->has($locale . '.meta_title'))
                                                    <span
                                                        class="missiong-spam">{{ $errors->first($locale . '.meta_title') }}</span>
                                                @endif
                                            </div>

                                            {{-- meta_description_  ------------------------------------------------------------------------------------- --}}
                                            <div class="mb-3 row">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">
                                                    {{ trans('admin.meta_description_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                </label>
                                                <div class="mb-2 col-sm-10">
                                                    <textarea name="{{ $locale }}[meta_description]" class="form-control description"> {{ @$project->trans->where('locale', $locale)->first()->meta_description }} </textarea>
                                                    @if ($errors->has($locale . '.meta_description'))
                                                        <span
                                                            class="missiong-spam">{{ $errors->first($locale . '.meta_description') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- meta_key_ ------------------------------------------------------------------------------------- --}}
                                            <div class="mb-3 row">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">
                                                    {{ trans('admin.meta_key_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                </label>
                                                <div class="mb-2 col-sm-10">
                                                    <textarea name="{{ $locale }}[meta_key]" class="form-control description"> {{ @$project->trans->where('locale', $locale)->first()->meta_key }} </textarea>
                                                    @if ($errors->has($locale . '.meta_key'))
                                                        <span
                                                            class="missiong-spam">{{ $errors->first($locale . '.meta_key') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <hr>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-4">
                        {{-- Setting ---------------------------------------------------------------------------------------------------------- --}}
                        <div class="mt-4 mb-4 accordion" id="accordionExampleSetting">
                            <div class="border rounded accordion-item">
                                <h2 class="accordion-header" id="headingSetting">
                                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        {{ trans('admin.settings') }}
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show"
                                    aria-labelledby="headingSetting" data-bs-parent="#accordionExampleSetting">
                                    <div class="accordion-body">
                                        {{-- Monthly deduction  ------------------------------------------------------------------------------------- --}}
                                        <div class="mt-3 d-flex ">
                                            <div class="form-check form-switch form-check-success">
                                                <input
                                                    class="form-check-input {{ empty($errors->first('recurring')) ?: 'has-error' }}"
                                                    type="checkbox" role="switch" name="recurring"
                                                    {{ $project->recurring ? 'checked' : '' }} id="recurring">
                                                @if ($errors->has('recurring'))
                                                    <span class="missiong-spam">{{ $errors->first('recurring') }}</span>
                                                @endif
                                            </div>
                                            <label class="form-check-label fw-bold"
                                                for="recurring">@lang('Monthly deduction project')</label>
                                        </div>
                                        {{-- number   ------------------------------------------------------------------------------------- --}}
                                        <div class="row mb-3">
                                            <label for="example-number-input" class="col-sm-12 col-form-label" l>
                                                @lang('charityProject.number') </label>
                                            <div class="col-sm-12">
                                                <input
                                                    class="form-control {{ empty($errors->first('number')) ?: 'has-error' }}"
                                                    type="text" id="example-number-input" name="number"
                                                    value="{{ $project->number }}">
                                                @if ($errors->has('number'))
                                                    <span class="missiong-spam">{{ $errors->first('number') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        {{-- beneficiary ------------------------------------------------------------------------------------- --}}
                                        <div class="row mb-3">
                                            <label class="col-sm-12 col-form-label" for="available">@lang('charityProject.beneficiary')
                                            </label>
                                            <div class="col-sm-12">
                                                <input
                                                    class="form-control {{ empty($errors->first('beneficiary')) ?: 'has-error' }}"
                                                    name="beneficiary" type="text"
                                                    value="{{ $project->beneficiary }}">
                                                @if ($errors->has('beneficiary'))
                                                    <span class="missiong-spam">{{ $errors->first('beneficiary') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        {{-- Location Type ------------------------------------------------------------------------------------- --}}
                                        <div class="mb-3 row title-section">
                                            <label for="example-text-input"
                                                class="col-sm-12 col-form-label">@lang('charityProject.type')</label>
                                            <div class="col-sm-12">
                                                <select
                                                    class="form-select form-select-sm select2 {{ empty($errors->first('location_type')) ?: 'has-error' }}"
                                                    name="location_type" aria-label=".form-select-sm example">
                                                    <option value="" disabled selected>@lang('charityProject.choose_type')</option>
                                                    @foreach (App\Enums\LocationTypeEnum::values() as $type)
                                                        <option value="{{ $type }}"
                                                            {{ $type == ($project->location_type ?? App\Enums\LocationTypeEnum::WEB) ? 'selected' : '' }}>
                                                            {{ $type }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('tags'))
                                                    <span class="missiong-spam">{{ $errors->first('tags') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        {{-- category -------------------------------------------------------------------------------------   --}}
                                        <div class="row mb-3">
                                            <label for="example-text-input"
                                                class="col-sm-12 col-form-label">@lang('charityProject.category')</label>
                                            <div class="col-sm-12">
                                                <select name="categories[]"
                                                    class="form-select  form-select-sm select2 {{ empty($errors->first('categories')) ?: 'has-error' }}"
                                                    multiple>
                                                    @foreach ($categories as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ in_array($item->id, $project->categories->pluck('id')->toArray() ?? []) ? 'selected' : '' }}>
                                                            {{ str_repeat('ـــ ', $item->level - 1) }}
                                                            {{ $item->trans->where('locale', $current_lang)->first()->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @if ($errors->has('categories'))
                                                <span class="missiong-spam">{{ $errors->first('categories') }}</span>
                                            @endif
                                        </div>
                                        {{-- tags ------------------------------------------------------------------------------------- --}}
                                        <div class="row mb-3">
                                            <label for="example-text-input"
                                                class="col-sm-12 col-form-label">@lang('charityProject.tags')</label>
                                            <div class="col-sm-12">
                                                <select
                                                    class="form-select form-select-sm select2 {{ empty($errors->first('tags')) ?: 'has-error' }}"
                                                    multiple name="tags[]" aria-label=".form-select-sm example">
                                                    @forelse ($tags as $key => $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ in_array($item->id, $project->tags->pluck('tag_id')->toArray()) ? 'selected' : '' }}>
                                                            {{ $item->trans->where('locale', $current_lang)->first()->title }}
                                                        </option>
                                                    @empty
                                                    @endforelse
                                                </select>
                                                @if ($errors->has('tags'))
                                                    <span class="missiong-spam">{{ $errors->first('tags') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Setting Post   ------------------------------------------------------------------------------------------------------ --}}
                        <div class="mt-4 mb-4 accordion" id="accordionExamplePost">
                            <div class="border rounded accordion-item">
                                <h2 class="accordion-header" id="headingPost">
                                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#settings_post" aria-expanded="true"
                                        aria-controls="settings_post">
                                        {{ trans('charityProject.settings_post') }}
                                    </button>
                                </h2>
                                <div id="settings_post" class="accordion-collapse collapse "
                                    aria-labelledby="headingPost" data-bs-parent="#accordionExamplePost">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="mb-3 row">
                                                <div class="col-sm-12">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="statistic_status" name="statistic_status"
                                                            {{ old('statistic_status', $project->statistic_status ?? false) ? 'checked' : '' }}
                                                            <label class="form-check-label" for="statistic_status">إظهار
                                                        الإحصائيات على الموقع</label>
                                                        @if ($errors->has('statistic_status'))
                                                            <span
                                                                class="missiong-spam">{{ $errors->first('statistic_status') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                </br>

                                                <div class="form-group">
                                                    <label for="visits_count">عدد الزيارات</label>
                                                    <input type="number" name="visits_count" id="visits_count"
                                                        class="form-control"
                                                        value="{{ old('visits_count', $project->visits_count) }}">

                                                    @error('visits_count')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                </br>

                                                <div class="form-group">
                                                    <label for="donations_count">عدد التبرعات</label>
                                                    <input type="number" name="donations_count" id="donations_count"
                                                        class="form-control"
                                                        value="{{ old('donations_count', $project->donations_count) }}">
                                                    @error('donations_count')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                </br>

                                                <div class="form-group">
                                                    <label for="last_donation_at">آخر تاريخ تبرع</label>
                                                    <input type="datetime-local" name="last_donation_at"
                                                        id="last_donation_at" class="form-control"
                                                        value="{{ old('last_donation_at', $project->last_donation_at ? \Carbon\Carbon::parse($project->last_donation_at)->format('Y-m-d\TH:i') : '') }}">
                                                    @error('last_donation_at')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>






                                            {{-- sort -------------------------------------------------------------------------------------  --}}
                                            <div class="col-12">
                                                <div class="mb-3 row">
                                                    <label for="example-sort-input" class="col-sm-12 col-form-label">
                                                        @lang('charityProject.sort') </label>
                                                    <div class="col-sm-12">
                                                        <input
                                                            class="form-control  {{ empty($errors->first('sort')) ?: 'has-error' }}"
                                                            type="number" id="example-sort-input" name="sort"
                                                            value="{{ $project->sort }}">
                                                        @if ($errors->has('sort'))
                                                            <span
                                                                class="missiong-spam">{{ $errors->first('sort') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3 row">
                                                    <label for="example-number-input" class="col-sm-12 col-form-label">
                                                        @lang('charityProject.most_sell')</label>
                                                    <div class="col-sm-12">
                                                        <select name="most_sell" class="form-control">
                                                            <option {!! $project->most_sell == 0 ? 'selected' : '' !!} value="0">
                                                                @lang('charityProject.no')</option>
                                                            <option {!! $project->most_sell == 1 ? 'selected' : '' !!} value="1">
                                                                @lang('charityProject.yes')</option>
                                                        </select>
                                                        @if ($errors->has('most_sell'))
                                                            <span
                                                                class="missiong-spam">{{ $errors->first('most_sell') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- Start Date   ------------------------------------------------------------------------------------- --}}
                                            <div class="col-12 ">
                                                <div class="mb-3 row">
                                                    <label for="example-start_date-input"
                                                        class="col-sm-12 col-form-label">
                                                        @lang('charityProject.start_date') </label>
                                                    <div class="col-sm-12">
                                                        <input
                                                            class="form-control  {{ empty($errors->first('start_date')) ?: 'has-error' }}"
                                                            type="date" id="example-start_date-input"
                                                            name="start_date" value="{{ $project->start_date }}">
                                                        @if ($errors->has('start_date'))
                                                            <span
                                                                class="missiong-spam">{{ $errors->first('start_date') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- End Date ------------------------------------------------------------------------------------- --}}
                                            <div class="col-12">
                                                <div class="mb-3 row">
                                                    <label for="example-end_date-input" class="col-sm-12 col-form-label">
                                                        @lang('charityProject.end_date') : </label>
                                                    <div class="col-sm-12">
                                                        <input
                                                            class="form-control {{ empty($errors->first('end_date')) ?: 'has-error' }}"
                                                            type="date" id="example-end_date-input" name="end_date"
                                                            value="{{ $project->end_date }}">
                                                        @if ($errors->has('end_date'))
                                                            <span
                                                                class="missiong-spam">{{ $errors->first('end_date') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-auto row ">
                                            {{-- -------------------status------------------------------ --}}
                                            <div class="col-sm-6 mt-3">
                                                <label class="form-check-label"
                                                    for="flexSwitchCheckSuccessStatus">@lang('admin.status')</label>
                                                <div class="form-check form-switch form-check-success">
                                                    <input
                                                        class="form-check-input {{ empty($errors->first('status')) ?: 'has-error' }}"
                                                        type="checkbox" role="switch" name="status"
                                                        {{ $project->status == 1 ? 'checked' : '' }}
                                                        id="flexSwitchCheckSuccessStatus">
                                                    @if ($errors->has('status'))
                                                        <span class="missiong-spam">{{ $errors->first('status') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- ----------------------featuer------------------------ --}}
                                            <div class="col-sm-6 mt-3">
                                                <label class="form-check-label"
                                                    for="flexSwitchCheckSuccessFeatuer">@lang('charityProject.featuer')</label>
                                                <div class="form-check form-switch form-check-success">
                                                    <input
                                                        class="form-check-input {{ empty($errors->first('featuer')) ?: 'has-error' }}"
                                                        type="checkbox" role="switch" name="featuer"
                                                        {{ $project->featuer == 1 ? 'checked' : '' }}
                                                        id="flexSwitchCheckSuccessFeatuer">
                                                    @if ($errors->has('featuer'))
                                                        <span class="missiong-spam">{{ $errors->first('featuer') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            {{-- ----------------------finished------------------------ --}}
                                            <div class="col-sm-6 mt-3">
                                                <label class="form-check-label"
                                                    for="flexSwitchCheckSuccessFinished">@lang('charityProject.finished')</label>
                                                <div class="form-check form-switch form-check-success">
                                                    <input
                                                        class="form-check-input {{ empty($errors->first('finished')) ?: 'has-error' }}"
                                                        type="checkbox" role="switch" name="finished"
                                                        {{ $project->finished == 1 ? 'checked' : '' }}
                                                        id="flexSwitchCheckSuccessFinished">
                                                    @if ($errors->has('finished'))
                                                        <span
                                                            class="missiong-spam">{{ $errors->first('finished') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            {{-- -------------------fast_donation------------------------------ --}}
                                            <div class="col-sm-6 mt-3">
                                                <label class="form-check-label"
                                                    for="flexSwitchCheckSuccessfast_donation">@lang('admin.fast_donation')</label>
                                                <div class="form-check form-switch form-check-success">
                                                    <input
                                                        class="form-check-input {{ empty($errors->first('fast_donation')) ?: 'has-error' }}"
                                                        type="checkbox" role="switch" name="fast_donation"
                                                        {{ $project->fast_donation == 1 ? 'checked' : '' }}
                                                        id="flexSwitchCheckSuccessfast_donation">
                                                    @if ($errors->has('fast_donation'))
                                                        <span
                                                            class="missiong-spam">{{ $errors->first('fast_donation') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- cashier_system --}}
                                            {{-- <div class="col-sm-6 mt-3">
                                                <label class="form-check-label"
                                                    for="flexSwitchCheckCashierSystem">@lang('admin.cashier_system')</label>
                                                <div class="form-check form-switch form-check-success">
                                                    <input
                                                        class="form-check-input {{ empty($errors->first('cashier_system')) ?: 'has-error' }}"
                                                        type="checkbox" role="switch" name="cashier_system"
                                                        {{ $project->cashier_system == 1 ? 'checked' : '' }}
                                                        id="flexSwitchCheckCashierSystem">
                                                    @if ($errors->has('cashier_system'))
                                                        <span
                                                            class="missiong-spam">{{ $errors->first('cashier_system') }}</span>
                                                    @endif
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Payment method  --------------------------------------------------------------------------------------------------- --}}
                        <div class="mt-4 mb-4 accordion" id="accordionExamplePayments">
                            <div class="border rounded accordion-item">
                                <h2 class="accordion-header" id="headingPayments">
                                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#payment_method" aria-expanded="true"
                                        aria-controls="payment_method">
                                        {{ trans('charityProject.payment_method') }}
                                    </button>
                                </h2>
                                <div id="payment_method" class="accordion-collapse collapse show"
                                    aria-labelledby="headingPayments" data-bs-parent="#accordionExamplePayments">
                                    <div class="accordion-body">
                                        {{-- donation_type   ------------------------------------------------------------------------------------- --}}
                                        <div class="mb-3 row title-section">
                                            <label for="example-text-input"
                                                class="col-sm-12 col-form-label">@lang('charityProject.donation_type')</label>
                                            <div class="col-sm-12">
                                                <select class="form-select form-select-sm" name="donation_type"
                                                    aria-label=".form-select-sm example" id="denation-type">
                                                    <option value="">@lang('charityProject.donation_type')</option>
                                                    @foreach (App\Enums\DonationTypeEnum::values() as $key => $value)
                                                        <option value="{{ $value }}"
                                                            {{ $value == @$donation['type'] ? 'selected' : '' }}>
                                                            {{ trans('charityProject.' . $value) }} </option>
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        {{-- ------------------ Start forms donation_type ------------------- --}}
                                        {{-- Start input share Value --}}
                                        <div class="row mb-3  {{ @$donation['type'] == 'share' ? '' : 'd-none' }}"
                                            id="section-share-value">
                                            <div id="ads_section">
                                                @if (@$donation['type'] == 'share')
                                                    @forelse (@$donation['data'] ?? [] as $key => $value)
                                                        <div>
                                                            <div class="row">
                                                                <div class="col-md-5">
                                                                    <div class="mb-3">
                                                                        <label for="example-share_name-input">
                                                                            @lang('charityProject.donation_name_share')</label>
                                                                        <div class="col-sm-12">
                                                                            <input type="" name="share_name[]"
                                                                                class="form-control" required
                                                                                value="{{ $value['name'] }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <div class="mb-3">
                                                                        <label for="example-share_value-input">
                                                                            @lang('charityProject.donation_value_share')</label>
                                                                        <div class="col-sm-12">
                                                                            <input type="number" name="share_value[]"
                                                                                class="form-control" required
                                                                                value="{{ $value['value'] }}"
                                                                                min="0">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <button
                                                                        class="delete_ads btn btn-neutral text-danger btn-sm mt-3"><i
                                                                            class="bx bx-x-circle"></i></button>
                                                                </div>
                                                                <hr>
                                                            </div>
                                                        </div>
                                                    @empty
                                                    @endforelse
                                                    {{-- {{ $donation['data'] }} --}}
                                                @endif
                                            </div>
                                            <button type="button" class="btn btn-success form-control"
                                                id="add_ads_section">
                                                <i class="bx bx-plus-medical fs-5"></i>
                                            </button>
                                        </div>
                                        {{-- End input share Value --}}

                                        {{-- Start input Fixed Value --}}
                                        <div class="col-12 {{ @$donation['type'] == 'fixed' ? '' : 'd-none' }}"
                                            id="section-fixed-value">

                                            <div class="mb-3 row">
                                                <label for="example-fiexd_value-input" class="col-sm-12 col-form-label">
                                                    @lang('charityProject.fiexd_value') </label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="number" id="fixed-value"
                                                        name="fixed_value"
                                                        value="{{ @$donation['type'] == 'fixed' ? @$donation['data'] : '' }}"
                                                        min="0">

                                                </div>
                                            </div>
                                        </div>
                                        {{-- End input Fixed Value --}}

                                        {{-- Start input Deometion Value --}}
                                        <div class="row mb-3 {{ @$donation['type'] == 'unit' ? '' : 'd-none' }}"
                                            id="section-donation-value">
                                            {{-- @$donation['type'] --}}

                                            <div id="donation_section">
                                                @if (@$donation['type'] == 'unit')

                                                    @foreach (@$donation['data'] as $key => $value)
                                                        <div>
                                                            <div class="row">
                                                                <div class="col-md-5">
                                                                    <div class="mb-3">
                                                                        <label for="example-donation_name-input">
                                                                            @lang('charityProject.donation_name')</label>
                                                                        <div class="col-sm-12">
                                                                            <input type="" name="donation_name[]"
                                                                                class="form-control" required
                                                                                value="{{ @$value['name'] }}">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-5">
                                                                    <div class="mb-3">
                                                                        <label for="example-donation_value-input">
                                                                            @lang('charityProject.donation_value')</label>
                                                                        <div class="col-sm-12">
                                                                            {{-- <input type="number" name="donation_value[]" class="form-control"
                                                                    required value="{{ @$value->value }}"> --}}
                                                                            <input type="number" name="donation_value[]"
                                                                                class="form-control" required
                                                                                value="{{ $value['value'] }}"
                                                                                min="0">

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <button
                                                                        class="delete_ads btn btn-neutral text-danger btn-sm mt-3"><i
                                                                            class="bx bx-x-circle"></i></button>
                                                                </div>
                                                                <hr>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <button type="button" class="btn btn-success form-control"
                                                id="add_donation_section">
                                                <i class="bx bx-plus-medical fs-5"></i>
                                            </button>
                                        </div>

                                        {{-- End input Deometion Value --}}
                                        {{-- ------------------ End forms donation_type ------------------- --}}

                                        {{-- target_price  ------------------------------------------------------------------------------------- --}}
                                        <div class="col-12">
                                            <div class="mb-3 row">
                                                <label for="example-target_price-input" class="col-sm-12 col-form-label">
                                                    @lang('charityProject.target_price') </label>
                                                <div class="col-sm-12">
                                                    <input
                                                        class="form-control {{ empty($errors->first('target_price')) ?: 'has-error' }}"
                                                        type="number" id="example-target_price-input"
                                                        name="target_price" value="{{ $project->target_price }}">
                                                    @if ($errors->has('target_price'))
                                                        <span
                                                            class="missiong-spam">{{ $errors->first('target_price') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        {{-- target_unit  ------------------------------------------------------------------------------------- --}}
                                        <div class="col-12">
                                            <label class="col-sm-12 col-form-label" for="available">@lang('charityProject.target_unit')
                                            </label>
                                            <div class="col-sm-12">
                                                <input
                                                    class="form-control  {{ empty($errors->first('target_unit')) ?: 'has-error' }}"
                                                    name="target_unit" type="text"
                                                    value="{{ $project->target_unit }}">
                                                @if ($errors->has('target_unit'))
                                                    <span
                                                        class="missiong-spam">{{ $errors->first('target_unit') }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- unit_price  ------------------------------------------------------------------------------------- --}}
                                        @foreach ($languages as $key => $locale)
                                            <div class="mb-3 row">
                                                <label for="example-text-input"
                                                    class="col-sm-12 col-form-label">{{ trans('charityProject.unit_price_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                <div class="col-sm-12">
                                                    <input
                                                        class="form-control  {{ empty($errors->first('unit_price')) ?: 'has-error' }}"
                                                        type="text" name="{{ $locale }}[unit_price]"
                                                        value="{{ @$project->trans->where('locale', $locale)->first()->unit_price }}"
                                                        id="unit_price{{ $key }}">
                                                </div>
                                                @if ($errors->has($locale . '.unit_price'))
                                                    <span
                                                        class="missiong-spam">{{ $errors->first($locale . '.unit_price') }}</span>
                                                @endif
                                            </div>
                                        @endforeach

                                        {{-- fake_target ------------------------------------------------------------------------------------- --}}
                                        <div class="col-12">
                                            <label class="col-sm-12 col-form-label" for="available"> @lang('charityProject.fake_target')
                                            </label>
                                            <div class="col-sm-12">
                                                <input
                                                    class="form-control {{ empty($errors->first('fake_target')) ?: 'has-error' }}"
                                                    name="fake_target" type="number"
                                                    value="{{ $project->fake_target }}">
                                                @if ($errors->has('fake_target'))
                                                    <span
                                                        class="missiong-spam">{{ $errors->first($locale . '.fake_target') }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- --------------Payment Methoed----------------------------- --}}
                                        @if (Route::is('admin.charity.single-projects.edit'))
                                            <div class="col-12">
                                                <label class="col-sm-12 col-form-label"
                                                    for="available">@lang('charityProject.payment_method')</label>
                                                <div class="col-sm-10">
                                                    <div class="form-check">
                                                        @foreach ($payments as $key => $item)
                                                            <div class="col-md-12">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="{{ $item->id }}"
                                                                    id="flexCheckDefault{{ $key }}"
                                                                    name="payment_method[]"
                                                                    {{ in_array($item->id, $project->payment->pluck('payment_id')->toArray()) ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="flexCheckDefault{{ $key }} ">{{ $item->trans->where('locale', $current_lang)->first()->title }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                @if ($errors->has('payment_method'))
                                                    <span
                                                        class="missiong-spam">{{ $errors->first('payment_method') }}</span>
                                                @endif
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ------------images-------------------------------------------------------------------------------------------------  --}}
                        <div class="mt-4 mb-4 accordion" id="accordionExampleImages">
                            <div class="border rounded accordion-item">
                                <h2 class="accordion-header" id="headingImages">
                                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#images_project" aria-expanded="true"
                                        aria-controls="images_project">
                                        {{ trans('charityProject.images_project') }}
                                    </button>
                                </h2>
                                <div id="images_project" class="accordion-collapse collapse show"
                                    aria-labelledby="headingImages" data-bs-parent="#accordionExampleImages">
                                    <div class="accordion-body">
                                        <div class="col-12 mb-3">
                                            {{-- @if ($project->images != null)
                                <div class="row mt-3">
                                    @foreach (hinddelImage($project->images) as $image)
                                    <div class="col-md-6 mb-2">
                                        <a href="{{ getImageFileManger($image) }}" target="_blank"><img src="{{ getImageFileManger($image) }}" alt="Card image" width="150"></a>
                                    </div>
                                    @endforeach
                                </div>
                                @endif --}}
                                            {{-- image -------------------------------------------------------------------------------------  --}}
                                            {{-- <div class="row mt-3">
                                    <label class="control-label" for="imageUpload"> @lang('admin.images')
                                    </label>
                                    <div class="glr-group">
                                        <input id="galery" readonly name="images" class="form-control" type="text" value="{{ $project->images }}">
                                        <a data-toggle="modal" href="javascript:;" data-bs-toggle="modal" data-bs-target="#exampleModal" class="mt-2 ml-3 btn btn-primary waves-effect waves-light btn-sm" type="button">@lang('admin.choose')</a>
                                    </div>
                                    <!-- /.modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="pt-0 mt-0 card-body">
                                                    <iframe width="100%" height="500" src="{{ asset('backend/filemanager/dialog.php') }}?type=2&field_id=galery&relative_url=1" frameborder="0" style="overflow: scroll; overflow-x: hidden; overflow-y: scroll; "></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.modal -->
                                </div> --}}
                                            {{-- <div class="row">
                                    @livewire('files.upload-modal', ['model' => 'charity_projects', 'model_id' => $item->id])
                                </div> --}}
                                        </div>
                                        {{-- cover image   ------------------------------------------------------------------------------------- --}}
                                        <div class="mb-3 row">
                                            <div class="col-12">
                                                @if ($project->cover_image != null)
                                                    <a href="{{ getImage($project->cover_image) }}" target="_blank">
                                                        <img src="{{ asset(getImageThumb($project->cover_image)) }}"
                                                            alt="Card image" width="150"></a>
                                                @endif
                                                <label for="example-cover_image-input" class="col-sm-12 col-form-label">
                                                    @lang('charityProject.cover_image') </label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="file" accept="image/*"
                                                        placeholder="@lang('admin.cover_image')" id="example-cover_image-input"
                                                        name="cover_image" value="{{ old('cover_image') }}">
                                                    <small class="text-danger">المقاس المطلوب: <strong>378px ×
                                                            341px</strong> بكسل</small>
                                                    @error('cover_image')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>


                                        {{-- background_image-------------------------------------------------------------------------------------  --}}
                                        {{-- <div class="col-12">
                                            <div class="mb-3 row">
                                                @if ($project->cover_image != null)
                                                    <a href="{{ getImage($project->background_image) }}"
                            target="_blank"><img src="{{ getImageThumb($project->background_image) }}" alt="Card image" width="150"></a>
                            @endif
                            <label for="example-background_image-input" class="col-sm-12 col-form-label">
                                @lang('charityProject.background_image') </label>
                            <div class="col-sm-12">
                                <input class="form-control" type="file" placeholder="@lang('admin.background_image')" id="example-background_image-input" name="background_image" value="{{ old('background_image') }}">
                            </div>
                        </div>
                    </div> --}}
                                        {{-- background_color-------------------------------------------------------------------------------------   --}}
                                        <div class="col-12">
                                            <div class="mb-3 row">
                                                <label for="example-background_color-input" col-form-label>
                                                    @lang('charityProject.background_color') </label>
                                                <input type="text" name="background_color"
                                                    value="{{ $project->background_color }}" placeholder="#FFFFFF"
                                                    class="form-control spectrum with-add-on colorpicker-showinput-intial"
                                                    id="colorpicker-showinput-intial">
                                            </div>
                                            @if ($errors->has('background_color'))
                                                <span
                                                    class="missiong-spam">{{ $errors->first('background_color') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Butoooons ------------------------------------------------------------------------- --}}
                    <div class="mb-3 row text-end">
                        <div>
                            <a href="{{ route('admin.charity.projects.index') }}" id="chiledBack"
                                class="ml-3 btn btn-outline-primary waves-effect waves-light btn-sm">@lang('button.cancel')</a>
                            <button type="submit"
                                class="ml-3 btn btn-outline-success waves-effect waves-light btn-sm">@lang('button.save')</button>
                            <button type="submit" name="submit" value="update"
                                class="btn btn-outline-success waves-effect waves-light  btn-sm">@lang('button.save_update')</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>

@endsection

@section('style')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('site/js/ckeditor/ckeditor.js') }}"></script>
@endsection

@section('script')
    <script src="{{ asset('backend/js/spectrum.js') }}"></script>
    <script src="{{ asset('backend/js/select2.js') }}"></script>
    <script src="{{ asset('backend/js/form-advanced.js') }}"></script>
    <script type="text/javascript">
        colorPicker.select();
    </script>

    <script>
        $(document).ready(function() {
            // Start Donation Type
            $("#denation-type").change(function() {
                console.log($(this).val());
                if ($(this).val() == "share") {
                    $("#section-share-value").show();
                    $(".d-none").removeClass();
                    $("#section-fixed-value").hide();
                    $("#section-donation-value").hide();
                    $("#section-donation-value .row").html('');

                } else if ($(this).val() == "fixed") {
                    $("#section-fixed-value").show();
                    $(".d-none").removeClass();
                    $("#section-share-value").hide();
                    $("#section-donation-value").hide();
                    $("#section-share-value .row").html('');
                    $("#section-donation-value .row").html('');

                } else if ($(this).val() == "unit") {
                    $("#section-donation-value").show();
                    $(".d-none").removeClass();
                    $("#section-share-value").hide();
                    $("#section-fixed-value").hide();
                    $("#section-share-value .row").html('');
                } else {
                    $("#section-share-value").hide();
                    $("#section-fixed-value").hide();
                    $("#section-donation-value").hide();
                    $("#section-share-value .row").html('');
                    $("#section-donation-value .row").html('');
                }
            });
            // End Donation Type

        });
    </script>
    {{-- form repeat --}}

    {{-- Start Script html share value --}}
    <script>
        $(document).ready(function() {
            $('#add_ads_section').on('click', function() {
                $('#ads_section').append(
                    `
                <div>
                    <div class="row">
                        <div class="col-5">
                            <div class="mb-3">
                                <label for="example-share_name-input"  > @lang('charityProject.donation_name_share')</label>
                                <div class="col-sm-12">
                                    <input type="" name="share_name[]"   class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-5">
                            <div class="mb-3">
                                <label for="example-share_value-input"  > @lang('charityProject.donation_value_share')</label>
                                <div class="col-sm-12">
                                    <input type="number" name="share_value[]"  class="form-control"  required min="0">
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <button type="button" class="delete_ads btn btn-neutral text-danger btn-sm mt-3"><i class="bx bx-x-circle"></i></button>
                        </div>
                    <hr>
                    </div>
                `
                )

            });


            $('#ads_section').on('click', '.delete_ads', function(e) {
                $(this).parent().parent().remove();
            })
        });
    </script>
    {{-- End Script html share value --}}

    {{-- Start Script html deomention value --}}
    <script>
        $(document).ready(function() {
            $('#add_donation_section').on('click', function() {
                $('#donation_section').append(
                    `
                    <div>
                        <div class="row">
                            <div class="col-5">
                                <div class="mb-3 row">
                                    <label for="example-donation_name-input"  > @lang('charityProject.donation_name')</label>
                                    <div class="col-sm-12">
                                        <input type="" name="donation_name[]"   class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-5">
                                <div class="mb-3 row">
                                    <label for="example-donation_value-input"  > @lang('charityProject.donation_value')</label>
                                    <div class="col-sm-12">
                                        <input type="number" name="donation_value[]"  class="form-control"  required  min="0">
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <button type="button" class="delete_ads btn btn-neutral text-danger btn-sm mt-3"><i class="bx bx-x-circle"></i></button>
                            </div>
                        <hr>

                        </div>

                    `
                )

            });


            $('#donation_section').on('click', '.delete_ads', function(e) {
                $(this).parent().parent().remove();
            })
        });
    </script>
    {{-- End Script html deomention value --}}

    {{-- <script>
  document.querySelectorAll('input[type=file][name^="cover_image"]').forEach(input => {
    input.addEventListener('change', () => {
      const file = input.files[0];
      if (! file) return;
      const img = new Image();
      img.onload = () => {
        if (img.width !== 341 || img.height !== 378) {
          alert('يجب أن تكون الصورة بمقاس 341×378 بكسل.');
          input.value = ''; 
        }
      };
      img.src = URL.createObjectURL(file);
    });
  });
</script> --}}

@endsection
