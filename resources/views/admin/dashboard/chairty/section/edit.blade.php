@extends('admin.app')

@section('title', trans('sections.edit'))
@section('title_page', trans('sections.sections'))
@section('title_route', route('admin.charity.sections.index') )
@section('button_page')
<a href="{{ route('admin.charity.sections.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3">@lang('button.cancel')</a>
@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.charity.sections.update', $item->id) }}" method="post" id="form-submit" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="row">
                <div class="col-md-9">
                    @foreach ($languages as $key => $locale)
                    <div class="accordion mt-4 mb-4" id="accordionExampleTitle{{ $key }}">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingTitle{{ $key }}">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTitle{{ $key }}" aria-expanded="true" aria-controls="collapseTitle{{ $key }}">
                                    {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                </button>
                            </h2>
                            <div id="collapseTitle{{ $key }}" class="accordion-collapse collapse show mt-3" aria-labelledby="headingTitle{{ $key }}" data-bs-parent="#accordionExampleTitle{{ $key }}">
                                <div class="accordion-body">

                                    {{-- title ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-12 col-form-label">{{ trans('admin.title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                        <div class="col-sm-12">
                                            <input class="form-control" type="text" name="{{ $locale }}[title]" value="{{ @$item->trans->where('locale', $locale)->first()->title }}" id="title{{ $key }}">
                                        </div>
                                        @if ($errors->has($locale . '.title'))
                                        <span class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                        @endif
                                    </div>

                                    {{-- slug ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3 slug-section">
                                        <label for="example-text-input" class="col-sm-12 col-form-label">{{ trans('admin.slug_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                        </label>

                                        <div class="col-sm-12">
                                            <input type="text" id="slug{{ $key }}" name="{{ $locale }}[slug]" value="{{ @$item->trans->where('locale', $locale)->first()->slug }}" class="form-control slug" required>
                                            @if ($errors->has($locale . '.slug'))
                                            <span class="missiong-spam">{{ $errors->first($locale . '.slug') }}</span>
                                            @endif
                                        </div>
                                        @include('admin.layouts.scriptSlug')
                                        {{-- End Slug --}}
                                    </div>

                                    {{-- description ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-12 col-form-label">
                                            {{ trans('admin.description_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                        </label>
                                        <div class="col-sm-12 mt-2">
                                            <textarea id="description{{ $key }}" name="{{ $locale }}[description]"> {{ @$item->trans->where('locale', $locale)->first()->description }} </textarea>
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
                </div>


                <div class="col-md-3">
                    <div class="accordion mt-4 mb-4" id="accordionExampleSetting">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingSetting">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSetting" aria-expanded="true" aria-controls="collapseSetting">
                                    {{ trans('admin.settings') }}
                                </button>
                            </h2>
                            <div id="collapseSetting" class="accordion-collapse collapse show" aria-labelledby="headingSetting" data-bs-parent="#accordionExampleSetting">
                                <div class="accordion-body">
                                    {{-- parent Category ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label for="example-number-input"> @lang('categories.categories')</label>
                                            <div class="col-sm-12">
                                                <select class="form-select form-select-sm select2" multiple name="categories[]">
                                                    @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" {{ in_array($category->id , @$item->categories->pluck('id')->toArray() )? 'selected' : '' }}>
                                                        {{ str_repeat('ـــ ', $category->level - 1) }}
                                                        {{ @$category->trans->where('locale', $current_lang)->first()->title }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @error('parent_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- sort ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label for="example-number-input"> @lang('categories.sort')</label>
                                            <div class="col-12">
                                                <input class="form-control" type="number" name="sort" value="{{ @$item->sort }}">
                                            </div>
                                            @error('sort')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Status ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <div class="col-sm-10">
                                            <div class="form-check form-switch form-check-success">
                                                <label class="form-check-label" for="flexSwitchCheckSuccessStatus">@lang('admin.status')</label>
                                                <input class="form-check-input" type="checkbox" role="switch" name="status" {{  @$item->status == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessStatus">
                                                @error('status')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    {{-- feature ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <div class="col-md-10">
                                            <div class="form-check form-switch form-check-success">
                                                <label class="form-check-label" for="flexSwitchCheckSuccessFeature">@lang('admin.feature')</label>
                                                <input class="form-check-input" type="checkbox" role="switch" name="feature" {{  @$item->feature == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessFeature">
                                                @error('feature')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>


                                    {{-- image ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <a href="{{ asset(getImage($item->image)) }}">
                                        <img src="{{ asset(getImageThumb($item->image) )}}" alt="" style="width:100%">
                                        </a>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label for="example-number-input"> @lang('admin.image')</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="file" name="image">
                                            </div>
                                        </div>
                                        @if ($errors->has('image'))
                                        <span class="missiong-spam">{{ $errors->first('image') }}</span>
                                        @endif
                                    </div>

                                    {{-- Background Image ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <a href="{{ getImage($item->background_image) }}">
                                            <img src="{{ getImageThumb($item->background_image) }}" alt="" style="width:100%">
                                        </a>
                                    </div>
                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label for="example-number-input"> @lang('admin.background_image')</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="file" name="background_image">
                                            </div>
                                        </div>
                                        @if ($errors->has('background_image'))
                                        <span class="missiong-spam">{{ $errors->first('background_image') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Butoooons ------------------------------------------------------------------------- --}}
                <div class="row mb-3 text-end">
                    <div>
                        <a href="{{ route('admin.charity.sections.index') }}" id="chiledBack" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                        <button type="submit" class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">@lang('button.update')</button>
                        <button type="submit" name="submit" value="update" class="btn btn-outline-success waves-effect waves-light  btn-sm">@lang('button.save_update')</button>
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
@endsection