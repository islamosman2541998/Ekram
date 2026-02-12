@extends('admin.app')

@section('title', trans('charityProject.charity_create'))
@section('title_page', trans('charityProject.charity'))
@section('title_route', route('admin.deceases.projects.index') )
@section('button_page')
<a href="{{ route('admin.deceases.projects.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection


@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.deceases.projects.store') }}" method="post" enctype="multipart/form-data" id="form-submit">
            @csrf
            <div>
                <div class="row">
                    <div class="col-md-8">
                        @foreach ($languages as $key => $locale)
                        <div class="mt-4 mb-4 accordion" id="accordionExampleTitle{{ $key }}">
                            <div class="border rounded accordion-item">
                                <h2 class="accordion-header" id="headingTitles{{ $key }}">
                                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTitle{{ $key }}" aria-expanded="true" aria-controls="collapseOne{{ $key }}">
                                        {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                    </button>
                                </h2>
                                <div id="collapseTitle{{ $key }}" class="mt-3 accordion-collapse collapse show" aria-labelledby="headingTitles{{ $key }}" data-bs-parent="#accordionExampleTitle{{ $key }}">
                                    <div class="accordion-body">
                                        {{-- title ------------------------------------------------------------------------------------- --}}
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">
                                                {{ trans('admin.title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-sm-12">
                                                <input class="form-control {{ (empty($errors->first($locale . '.title'))) ?: 'has-error'  }}" type="text" name="{{ $locale }}[title]" value="{{ old($locale . '.title') }}" id="title{{ $key }}">
                                                @if ($errors->has($locale . '.title'))
                                                <span class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                                @endif
                                            </div>

                                        </div>

                                        {{-- slug ------------------------------------------------------------------------------------- --}}
                                        <div class="mb-3 row slug-section">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">{{
                                                trans('admin.slug_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="text" id="slug{{ $key }}" name="{{ $locale }}[slug]" value="{{ old($locale . '.slug') }}" class="form-control slug {{ (empty($errors->first($locale . '.slug'))) ?: 'has-error'  }}">
                                                @if ($errors->has($locale . '.slug'))
                                                <span class="missiong-spam">{{ $errors->first($locale . '.slug') }}</span>
                                                @endif
                                            </div>
                                            @include('admin.layouts.scriptSlug')
                                            {{-- End Slug ---------------------------------------------------------------------- --}}
                                        </div>

                                        <div class="mt-3 row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">
                                                {{ trans('admin.description_in') . trans('lang.' .
                                                Locale::getDisplayName($locale)) }}
                                            </label>
                                            <div class="mb-2 col-sm-12">
                                                <textarea id="description{{ $key }}" name="{{ $locale }}[description]" class="m-auto form-control {{ (empty($errors->first($locale . '.description'))) ?: 'has-error'  }}" style="margin-top: 10px"> {{ old($locale . '.description') }} </textarea>
                                                @if ($errors->has($locale . '.description'))
                                                <span class="missiong-spam">{{ $errors->first($locale . '.description') }}</span>
                                                @endif
                                            </div>

                                            <script type="text/javascript">
                                                CKEDITOR.replace('description{{ $key }}', {
                                                    filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}"
                                                    , filebrowserUploadMethod: 'form'
                                                });

                                            </script>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="mt-4 mb-4 accordion" id="accordionExampleMeta">
                            <div class="border rounded accordion-item">
                                <h2 class="accordion-header" id="headingMeta{{ $key }}">
                                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMeta{{ $key }}" aria-expanded="true" aria-controls="collapseTwo{{ $key }}">
                                        @lang('admin.meta')
                                    </button>
                                </h2>
                                <div id="collapseMeta{{ $key }}" class="mt-3 accordion-collapse collapse" aria-labelledby="headingMeta{{ $key }}" data-bs-parent="#accordionExampleMeta">
                                    <div class="accordion-body">

                                        @foreach ($languages as $key => $locale)
                                        {{-- meta_title_ ------------------------------------------------------------------------------------- --}}
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">
                                                {{ trans('admin.meta_title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" name="{{ $locale }}[meta_title]" value="{{ old($locale . '.meta_title') }}" id="title{{ $key }}">
                                            </div>
                                            @if ($errors->has($locale . '.meta_title'))
                                            <span class="missiong-spam">{{ $errors->first($locale . '.meta_title') }}</span>
                                            @endif
                                        </div>

                                        {{-- meta_description ------------------------------------------------------------------------------------- --}}
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">
                                                {{ trans('admin.meta_description_in') . trans('lang.' .  Locale::getDisplayName($locale)) }}
                                            </label>
                                            <div class="mb-2 col-sm-10">
                                                <textarea name="{{ $locale }}[meta_description]" class="form-control description"> {{ old($locale . '.meta_description') }} </textarea>
                                                @if ($errors->has($locale . '.meta_description'))
                                                    <span class="missiong-spam">{{ $errors->first($locale . '.meta_description') }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- meta_key_  ------------------------------------------------------------------------------------- --}}
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">
                                                {{ trans('admin.meta_key_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                            </label>
                                            <div class="mb-2 col-sm-10">
                                                <textarea name="{{ $locale }}[meta_key]" class="form-control description"> {{ old($locale . '.meta_key') }} </textarea>
                                                @if ($errors->has($locale . '.meta_key'))
                                                    <span class="missiong-spam">{{ $errors->first($locale . '.meta_key') }}</span>
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
                        {{-- Setting ------------------------------------------------------------------------------ --}}
                        <div class="mt-4 mb-4 accordion" id="accordionExampleSetting">
                            <div class="border rounded accordion-item">
                                <h2 class="accordion-header" id="headingSetting">
                                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSetting" aria-expanded="true" aria-controls="collapseOne">
                                        {{ trans('admin.settings') }}
                                    </button>
                                </h2>
                                <div id="collapseSetting" class="accordion-collapse collapse show" aria-labelledby="headingSetting" data-bs-parent="#accordionExampleSetting">
                                    <div class="accordion-body">
                                        {{-- number  ------------------------------------------------------------------------------------- --}}
                                        <div class="col-12">
                                            <div class="mb-3 row">
                                                <label for="example-number-input" class="col-sm-12 col-form-label">
                                                    @lang('charityProject.number') </label>
                                                <div class="col-sm-12">
                                                    <input class="form-control {{ (empty($errors->first('number'))) ?: 'has-error'  }}" type="text" id="example-number-input" name="number" value="{{ old('number') }}">
                                                    @if ($errors->has('number'))
                                                    <span class="missiong-spam">{{ $errors->first('number') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        {{-- beneficiary ------------------------------------------------------------------------------------- --}}
                                        <div class="col-12">
                                            <label class="col-sm-12 col-form-label" for="available">@lang('charityProject.beneficiary') </label>
                                            <div class="col-sm-12">
                                                <input class="form-control {{ (empty($errors->first('beneficiary'))) ?: 'has-error'  }}" name="beneficiary" type="text" value="{{ old('beneficiary') }}">
                                                @if ($errors->has('beneficiary'))
                                                <span class="missiong-spam">{{ $errors->first('beneficiary') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        {{-- Location Type ------------------------------------------------------------------------------------- --}}
                                        <div class="mb-3 row title-section">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">@lang('charityProject.type')</label>
                                            <div class="col-sm-12">
                                                <select class="form-select form-select-sm select2 {{ (empty($errors->first('location_type'))) ?: 'has-error'  }}" name="location_type" aria-label=".form-select-sm example">
                                                    <option value="" disabled selected>@lang('charityProject.choose_type')</option>
                                                    @foreach (App\Enums\LocationTypeEnum::values() as $type)
                                                    <option value="{{ $type }}" {{ $type == (old('location_type')??App\Enums\LocationTypeEnum::WEB)  ? 'selected' : '' }}>
                                                        {{ $type}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('tags'))
                                                <span class="missiong-spam">{{ $errors->first('tags') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        {{-- category ------------------------------------------------------------------------------------- --}}
                                        <div class="mb-3 row title-section">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">
                                                @lang('charityProject.category')
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-sm-12">
                                                <select class="form-select form-select-sm select2 {{ (empty($errors->first('category_id'))) ?: 'has-error'  }}" name="category_id" aria-label=".form-select-sm example">
                                                    <option value="" selected disabled>@lang('charityProject.choose_category')
                                                    </option>
                                                    @foreach ($categories as $item)
                                                    <option value="{{ $item->id }}" {{ old('category_id')==$item->id ? 'selected' : '' }}>
                                                        {{ $item->trans->where('locale', $current_lang)->first()->title }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @if ($errors->has('category_id'))
                                            <span class="missiong-spam">{{ $errors->first('category_id') }}</span>
                                            @endif
                                        </div>

                                    

                                        {{-- tags ------------------------------------------------------------------------------------- --}}
                                        <div class="mb-3 row title-section">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">@lang('charityProject.tags')</label>
                                            <div class="col-sm-12">
                                                <select class="form-select form-select-sm select2 {{ (empty($errors->first('tags'))) ?: 'has-error'  }}" multiple name="tags[]" aria-label=".form-select-sm example">
                                                    <option value="" disabled>@lang('charityProject.choose_tag')</option>
                                                    @foreach ($tags as $item)
                                                    <option value="{{ $item->id }}" {{ in_array($item->id, old('tags') ?? []) ?
                                                        'selected' : '' }}>
                                                        {{ $item->trans->where('locale', $current_lang)->first()->title }}
                                                    </option>
                                                    @endforeach
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

                        {{-- Setting Post ------------------------------------------------------------------------- --}}
                        <div class="mt-4 mb-4 accordion" id="accordionExamplePublish">
                            <div class="border rounded accordion-item">
                                <h2 class="accordion-header" id="headingPublish">
                                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#settings_post" aria-expanded="true" aria-controls="settings_post">
                                        {{ trans('charityProject.settings_post') }}
                                    </button>
                                </h2>
                                <div id="settings_post" class="accordion-collapse collapse " aria-labelledby="headingPublish" data-bs-parent="#accordionExamplePublish">
                                    <div class="accordion-body">
                                        <div class="row">
                                            {{-- sort  -------------------------------------------------------------------------------------     --}}
                                            <div class="col-12">
                                                <div class="mb-3 row">
                                                    <label for="example-number-input" class="col-sm-12 col-form-label">
                                                        @lang('charityProject.sort')</label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control {{ (empty($errors->first('sort'))) ?: 'has-error'}}" type="number" id="example-number-input" name="sort" value="{{ old('sort') ?? 0 }}">
                                                        @if ($errors->has('sort'))
                                                        <span class="missiong-spam">{{ $errors->first('sort') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Start Date -------------------------------------------------------------------------------------   --}}
                                            <div class="col-12 ">
                                                <div class="mb-3 row">
                                                    <label for="example-start_date-input" class="col-sm-12 col-form-label">
                                                        @lang('charityProject.start_date') </label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control {{ (empty($errors->first('start_date'))) ?: 'has-error'}}" type="date" id="example-start_date-input" name="start_date" value="{{ date('Y-m-d') }}">
                                                        @if ($errors->has('start_date'))
                                                        <span class="missiong-spam">{{ $errors->first('start_date') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- End  Date-------------------------------------------------------------------------------------     --}}
                                            <div class="col-12">
                                                <div class="mb-3 row">
                                                    <label for="example-end_date-input" class="col-sm-12 col-form-label">
                                                        @lang('charityProject.end_date') </label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control {{ (empty($errors->first('end_date'))) ?: 'has-error'}}" type="date" id="example-end_date-input" name="end_date" value="{{ now()->addYears(15)->format('Y-m-d') }}">
                                                        @if ($errors->has('end_date'))
                                                        <span class="missiong-spam">{{ $errors->first('end_date') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-auto row ">
                                            {{-- -------------------status------------------------------ --}}
                                            <div class="col-sm-6 mt-3">
                                                <label class="form-check-label" for="flexSwitchCheckSuccessStatus">@lang('admin.status')</label>
                                                <p>{{ old('status') }}</p>
                                                <div class="form-check form-switch form-check-success">
                                                    <input class="form-check-input {{ (empty($errors->first('status'))) ?: 'has-error'}}" type="checkbox" role="switch" name="status" {{  old('status') == "on" ? 'checked' : '' }} id="flexSwitchCheckSuccessStatus">
                                                    @if ($errors->has('status'))
                                                    <span class="missiong-spam">{{ $errors->first('status') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            {{-- ----------------------featuer------------------------ --}}
                                            <div class="col-sm-6 mt-3">
                                                <label class="form-check-label" for="flexSwitchCheckSuccessFeatuer">@lang('charityProject.featuer')</label>
                                                <div class="form-check form-switch form-check-success">
                                                    <input class="form-check-input {{ (empty($errors->first('featuer'))) ?: 'has-error'}}" type="checkbox" role="switch" name="featuer" {{  old('featuer') == "on" ? 'checked' : '' }} id="flexSwitchCheckSuccessFeatuer">
                                                    @if ($errors->has('featuer'))
                                                    <span class="missiong-spam">{{ $errors->first('featuer') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- ----------------------finished------------------------ --}}
                                            <div class="col-sm-6 mt-3">
                                                <label class="form-check-label" for="flexSwitchCheckSuccessFinished">@lang('charityProject.finished')</label>
                                                <div class="form-check form-switch form-check-success">
                                                    <input class="form-check-input {{ (empty($errors->first('finished'))) ?: 'has-error'}}" type="checkbox" role="switch" name="finished" {{  old('finished') == "on" ? 'checked' : '' }} id="flexSwitchCheckSuccessFinished">
                                                    @if ($errors->has('finished'))
                                                    <span class="missiong-spam">{{ $errors->first('finished') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Payments ------------------------------------------------------------------------------ --}}
                        <div class="mt-4 mb-4 accordion" id="accordionExamplePayments">
                            <div class="border rounded accordion-item">
                                <h2 class="accordion-header" id="headingPayments">
                                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#payment_method" aria-expanded="true" aria-controls="payment_method">
                                        {{ trans('charityProject.payment_method') }}
                                    </button>
                                </h2>
                                <div id="payment_method" class="accordion-collapse collapse show" aria-labelledby="headingPayments" data-bs-parent="#accordionExamplePayments">
                                    <div class="accordion-body">
                                        {{-- donation_type  ------------------------------------------------------------------------------------- --}}
                                        <div class="mb-3 row title-section">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">
                                                @lang('charityProject.donation_type') <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-sm-12">
                                                <select class="form-select form-select-sm" name="donation_type" aria-label=".form-select-sm example" id="denation-type">
                                                    <option value="" selected disabled> @lang('charityProject.donation_type') </option>
                                                    @foreach (App\Enums\DonationTypeEnum::values() as $key => $value)
                                                    <option value="{{ $value }}" {{ $value == old('donation_type') ? 'selected' : '' }}>
                                                        {{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <span class="missiong-spam">{{ $errors->first('donation_type') }}</span>
                                            <span class="missiong-spam">{{ $errors->first('share_name') }}</span>
                                            <span class="missiong-spam">{{ $errors->first('share_value') }}</span>
                                            <span class="missiong-spam">{{ $errors->first('donation_name') }}</span>
                                            <span class="missiong-spam">{{ $errors->first('donation_value') }}</span>
                                            <span class="missiong-spam">{{ $errors->first('fixed_value') }}</span>
                                        </div>
                                        {{-- ------------------ Start forms donation_type ------------------- --}}
                                        {{-- Start input share Value --}}
                                        <div class="row mb-3  {{ old('donation_type') == 'share' ? '' : 'd-none' }}" id="section-share-value">
                                            <div id="ads_section">
                                                @if (@old('donation_type') == 'share' && old('share_name') != null)
                                                @foreach (@old('share_name') as $key => $value)
                                                <div>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="mb-3">
                                                                <label for="example-number-input"> @lang('charityProject.donation_name_share')</label>
                                                                <div class="col-sm-12">
                                                                    <input type="text" name="share_name[]" class="form-control" required value="{{ $value }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="mb-3">
                                                                <label for="example-number-input"> @lang('charityProject.donation_value_share')</label>
                                                                <div class="col-sm-12">
                                                                    <input type="number" name="share_value[]" class="form-control" required value="{{ @old('share_value')[$key] }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <button class="btn btn-danger delete_ads form-control"><i class="fadeIn animated bx bx-x-circle"></i></button>
                                                        </div>
                                                        <hr>
                                                    </div>
                                                </div>
                                                @endforeach
                                                @endif
                                            </div>
                                            <button type="button" class="mt-2 btn btn-success form-control  btn-sm" id="add_ads_section">
                                                <i class="bx bx-plus-medical fs-5"></i>
                                            </button>

                                        </div>
                                        {{-- End input share Value --}}

                                        {{-- Start input Fixed Value --}}
                                        <div class="mb-3 d-none" id="section-fixed-value">
                                            <div class="col-12">
                                                <label for="example-number-input" class="col-sm-12 col-form-label">
                                                    @lang('charityProject.fiexd_value')</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="number" id="fixed-value" name="fixed_value" value="{{ old('fixed_value') }}" min="0">
                                                </div>
                                            </div>
                                        </div>
                                        {{-- End input Fixed Value --}}


                                        {{-- Start input donation Value --}}
                                        <div class="row mb-3 {{ old('donation_type') == 'unit' ? '' : 'd-none' }}" id="section-donation-value">
                                            <div id="donation_section">
                                                @if (old('donation_type') == 'unit' && old('donation_name') != null)
                                                @foreach (old('donation_name') as $key => $value)
                                                <div>
                                                    <div class="ads">
                                                        <div class="col-12">
                                                            <div class="mb-3 row">
                                                                <label for="example-number-input">
                                                                    @lang('charityProject.donation_name')</label>
                                                                <div class="col-sm-12">
                                                                    <input type="text" name="donation_name[]" class="form-control" required value="{{ $value }}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="mb-3 row">
                                                                <label for="example-number-input">
                                                                    @lang('charityProject.donation_value')</label>
                                                                <div class="col-sm-12">
                                                                    <input type="number" name="donation_value[]" class="form-control" required value="{{ @old('donation_value')[$key] }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <button class="btn btn-danger delete_ads form-control"><i class="fadeIn animated bx bx-x-circle"></i></button>
                                                        </div>
                                                        <hr>
                                                    </div>
                                                </div>
                                                @endforeach
                                                @endif
                                            </div>
                                            <button type="button" class="btn btn-success form-control btn-sm" id="add_donation_section">
                                                <i class="bx bx-plus-medical fs-5"></i>
                                            </button>
                                        </div>
                                        {{-- ------------------ End forms donation_type ------------------- --}}

                                        {{-- target_price ------------------------------------------------------------------------------------- --}}
                                        <div class="mb-3 mt-3 row">
                                            <div class="col-12">
                                                <label  class="col-sm-12 col-form-label">
                                                    @lang('charityProject.target_price')</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control {{ (empty($errors->first('target_price'))) ?: 'has-error'}}" type="number"  name="target_price" value="{{ old('target_price') ?? 0 }}">
                                                    @if ($errors->has('target_price'))
                                                    <span class="missiong-spam">{{ $errors->first('target_price') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        {{-- target_unit   ------------------------------------------------------------------------------------- --}}
                                        <div class="col-12">
                                            <label class="col-sm-12 col-form-label" for="available">@lang('charityProject.target_unit')
                                                :</label>
                                            <div class="col-sm-12">
                                                <input class="form-control {{ (empty($errors->first('target_unit'))) ?: 'has-error'}}" name="target_unit" type="text" value="{{ old('target_unit') }}">
                                                @if ($errors->has('target_unit'))
                                                <span class="missiong-spam">{{ $errors->first('target_unit') }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- unit_price  ------------------------------------------------------------------------------------- --}}
                                        @foreach ($languages as $key => $locale)
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">{{
                                                trans('charityProject.unit_price_in') . trans('lang.' .
                                                Locale::getDisplayName($locale)) }}</label>
                                            <div class="col-sm-12">
                                                <input class="form-control {{ (empty($errors->first('unit_price'))) ?: 'has-error'}}" type="text" name="{{ $locale }}[unit_price]" value="{{ old($locale . '.unit_price') }}" id="unit_price{{ $key }}">
                                            </div>
                                            @if ($errors->has('unit_price'))
                                            <span class="missiong-spam">{{ $errors->first($locale . '.unit_price') }}</span>
                                            @endif
                                        </div>
                                        @endforeach

                                        {{-- fake_target------------------------------------------------------------------------------------- --}}
                                        <div class="col-12">
                                            <label class="col-sm-12 col-form-label" for="available">@lang('charityProject.fake_target')</label>
                                            <div class="col-sm-12">
                                                <input class="form-control {{ (empty($errors->first('fake_target'))) ?: 'has-error'}}" name="fake_target" type="number" value="{{ old('fake_target') ?? 0 }}">
                                                @if ($errors->has('fake_target'))
                                                <span class="missiong-spam">{{ $errors->first($locale . '.fake_target') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ------------images------------------------------------------------------------------- --}}
                        <div class="mt-4 mb-4 accordion" id="accordionExampleImages">
                            <div class="border rounded accordion-item">
                                <h2 class="accordion-header" id="headingImages">
                                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#images_project" aria-expanded="true" aria-controls="images_project">
                                        {{ trans('charityProject.images_project') }}
                                    </button>
                                </h2>
                                <div id="images_project" class="accordion-collapse collapse" aria-labelledby="headingImages" data-bs-parent="#accordionExampleImages">
                                    <div class="accordion-body">

                                        <div class="col-12">
                                            <div class="">
                                                <label class="control-label" for="imageUpload">@lang('admin.images') </label>
                                                <div class="glr-group row">
                                                    <input id="galery" readonly name="images" class="form-control" type="text" value="{{ old('images') }}">
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
                                            </div>
                                        </div>
                                        {{-- cover image    ------------------------------------------------------------------------------------- --}}
                                        <div class="col-12">
                                            <div class="mb-3 row">
                                                <label for="example-cover_image-input" class="col-sm-12 col-form-label">
                                                    @lang('charityProject.cover_image') </label>
                                                <div class="col-sm-12">
                                                    <input class="form-control {{ (empty($errors->first('cover_image'))) ?: 'has-error'}}" type="file" placeholder="@lang('admin.cover_image')" id="example-cover_image-input" name="cover_image" value="{{ old('cover_image') }}">
                                                </div>
                                            </div>
                                        </div>
                                        {{-- background_image-------------------------------------------------------------------------------------   --}}
                                        <div class="col-12">
                                            <div class="mb-3 row">
                                                <label for="example-background_image-input" class="col-sm-12 col-form-label">
                                                    @lang('charityProject.background_image') </label>
                                                <div class="col-sm-12">
                                                    <input class="form-control {{ (empty($errors->first('background_image'))) ?: 'has-error'}}" type="file" placeholder="@lang('admin.background_image')" id="example-background_image-input" name="background_image" value="{{ old('background_image') }}">
                                                </div>
                                            </div>
                                        </div>
                                        {{-- background_color------------------------------------------------------------------------------------- --}}
                                        <div class="col-12">
                                            <div class="mb-3 row">
                                                <label for="example-number-input" col-form-label>
                                                    @lang('charityProject.background_color') </label>
                                                <input type="text" name="background_color" value="{{ old('background_color') }}" placeholder="#FFFFFF" class="form-control spectrum with-add-on colorpicker-showinput-intial" id="colorpicker-showinput-intial">
                                            </div>
                                            @if ($errors->has('background_color'))
                                            <span class="missiong-spam">{{ $errors->first('background_color') }}</span>
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
                        <a href="{{ route('admin.deceases.projects.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm" id="chiledBack">@lang('button.cancel')</a>
                        <button type="submit" class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">@lang('button.save')</button>
                        <button type="submit" name="submit" value="new" id="submit" class="btn btn-outline-success waves-effect waves-light btn-sm">@lang('button.save_new')</button>
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
    <script type="text/javascript">
        colorPicker.select();
    </script>

    <script>
        $(document).ready(function() {
            // Start Donation Type
            $("#denation-type").change(function() {
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

            // Donation
            let donationType = $("#denation-type").val()
            if (donationType == "share") {
                $("#section-share-value").show();
                $(".d-none").removeClass();
                $("#section-fixed-value").hide();
                $("#section-donation-value").hide();

            } else if (donationType == "fixed") {
                $("#section-fixed-value").show();
                $(".d-none").removeClass();
                $("#section-share-value").hide();
                $("#section-donation-value").hide();

            } else if (donationType == "unit") {
                $("#section-donation-value").show();
                $(".d-none").removeClass();
                $("#section-share-value").hide();
                $("#section-fixed-value").hide();
            } else {
                $("#section-share-value").hide();
                $("#section-fixed-value").hide();
                $("#section-donation-value").hide();
            }
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
                        <div class="row mt-2">
                            <div class="col-5">
                                <div class="mb-3">
                                    <div class="col-sm-12">
                                    <label for="example-share_name-input"  > @lang('charityProject.donation_name_share')</label>
                                        <input type="" name="share_name[]"   class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-5">
                                <div class="mb-3">
                                    <label for="example-share_value-input"  > @lang('charityProject.donation_value_share')</label>
                                    <div class="col-sm-12">
                                        <input type="number" name="share_value[]" min="0" class="form-control"  required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <button type="button" class="delete_ads btn btn-neutral text-danger btn-sm mt-3"><i class="bx bx-x-circle"></i></button>
                            </div>
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
                                    <div class="mb-3">
                                        <label for="example-donation_name-input"  > @lang('charityProject.donation_name')</label>
                                        <div class="col-sm-12">
                                            <input type="text" name="donation_name[]"   class="form-control" required min="0">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-5">
                                    <div class="mb-3">
                                        <label for="example-donation_value-input"  > @lang('charityProject.donation_value')</label>
                                        <div class="col-sm-12">
                                            <input type="number" name="donation_value[]"  min="0" class="form-control"  required>
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

@endsection