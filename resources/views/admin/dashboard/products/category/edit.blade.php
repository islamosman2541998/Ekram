@extends('admin.app')

@section('title', trans('products.editCategory', ['name' => @$item->translate($locale)->title]))
@section('title_page', trans('products.categories'))

@section('title_route', route('admin.eccommerce.categories.index') )
@section('button_page')
<a href="{{ route('admin.eccommerce.categories.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection




@section('content')
<div class="container-fluid">

    <div class="row">
        <div class="col-12 m-3">
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('admin.eccommerce.categories.update', $item->id) }}" method="post" enctype="multipart/form-data" id="form-submit">
                        @csrf
                        @method('put')
                        <div class="row">

                            <div class="col-md-8">
                                @foreach ($languages as $key => $locale)
                                <div class="accordion mt-4 mb-4" id="accordionExample">
                                    <div class="accordion-item border rounded">
                                        <h2 class="accordion-header" id="headingOne{{ $key }}">
                                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne{{ $key }}" aria-expanded="true" aria-controls="collapseOne{{ $key }}">
                                                {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                            </button>
                                        </h2>
                                        <div id="collapseOne{{ $key }}" class="accordion-collapse collapse show mt-3" aria-labelledby="headingOne{{ $key }}" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                {{-- title ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-control" type="text" name="{{ $locale }}[title]" value="{{ @$item->trans->where('locale', $locale)->first()->title }}" id="title{{ $key }}">
                                                    </div>
                                                    @if ($errors->has($locale . '.title'))
                                                    <span class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                                    @endif
                                                </div>

                                                {{-- slug ------------------------------------------------------------------------------------- --}}
                                                {{-- Start Slug --}}
                                                <div class="row mb-3 slug-section">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.slug_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                    </label>

                                                    <div class="col-sm-10">
                                                        <input type="text" id="slug{{ $key }}" name="{{ $locale }}[slug]" value="{{ @$item->trans->where('locale', $locale)->first()->slug }}" class="form-control slug" required>
                                                        @if ($errors->has($locale . '.slug'))
                                                        <span class="missiong-spam">{{ $errors->first($locale . '.slug') }}</span>
                                                        @endif
                                                    </div>
                                                    @include('admin.layouts.scriptSlug')
                                                    {{-- End Slug --}}


                                                    {{-- description ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label">
                                                            {{ trans('admin.description_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                        </label>
                                                        <div class="col-sm-10 mt-2">
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
                                                    {{-- content ------------------------------------------------------------------------------------- --}}
                                                    {{-- <div class="row mb-3">
                                                            <label for="example-text-input" class="col-sm-2 col-form-label">
                                                                {{ trans('admin.content_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                    </label>
                                                    <div class="col-sm-10 mt-2">
                                                        <textarea id="content{{ $key }}" name="{{ $locale }}[content]"> {{ @$item->trans->where('locale', $locale)->first()->content }}</textarea>
                                                        @if ($errors->has($locale . '.content'))
                                                        <span class="missiong-spam">{{ $errors->first($locale . '.content') }}</span>
                                                        @endif
                                                    </div>

                                                    <script type="text/javascript">
                                                        CKEDITOR.replace('content{{ $key }}', {
                                                            filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}"
                                                            , filebrowserUploadMethod: 'form'
                                                        });

                                                    </script>
                                                </div> --}}


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                            <div class="accordion mt-4 mb-4" id="accordionExampleslug">
                                <div class="accordion-item border rounded">
                                    <h2 class="accordion-header" id="headingTwo{{ $key }}">
                                        <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo{{ $key }}" aria-expanded="true" aria-controls="collapseTwo{{ $key }}">
                                            @lang('admin.meta')
                                        </button>
                                    </h2>
                                    <div id="collapseTwo{{ $key }}" class="accordion-collapse collapse mt-3" aria-labelledby="headingTwo{{ $key }}" data-bs-parent="#accordionExampleslug">
                                        <div class="accordion-body">
                                            @foreach ($languages as $key => $locale)
                                            {{-- meta_title_ ------------------------------------------------------------------------------------- --}}
                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="text" name="{{ $locale }}[meta_title]" value="{{ @$item->trans->where('locale', $locale)->first()->meta_title }}" id="title{{ $key }}">
                                                </div>
                                                @if ($errors->has($locale . '.meta_title'))
                                                <span class="missiong-spam">{{ $errors->first($locale . '.meta_title') }}</span>
                                                @endif
                                            </div>
                                            {{-- meta_description_ ------------------------------------------------------------------------------------- --}}
                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">
                                                    {{ trans('admin.meta_description_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                </label>
                                                <div class="col-sm-10 mb-2">
                                                    <textarea name="{{ $locale }}[meta_description]" class="form-control description"> {{ @$item->trans->where('locale', $locale)->first()->meta_description }} </textarea>
                                                    @if ($errors->has($locale . '.meta_description'))
                                                    <span class="missiong-spam">{{ $errors->first($locale . '.meta_description') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            {{-- meta_key_ ------------------------------------------------------------------------------------- --}}
                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">
                                                    {{ trans('admin.meta_key_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                </label>
                                                <div class="col-sm-10 mb-2">
                                                    <textarea name="{{ $locale }}[meta_key]" class="form-control description"> {{ @$item->trans->where('locale', $locale)->first()->meta_key }} </textarea>
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
                            <div class="accordion mt-4 mb-4" id="accordionExampleSetting">
                                <div class="accordion-item border rounded">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            {{ trans('admin.settings') }}
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExampleSetting">
                                        <div class="accordion-body">

                                            {{-- image ------------------------------------------------------------------------------------- --}}
                                            @if ($item->image != null)
                                            <img src="{{ getImageThumb($item->image) }}" alt="" style="width:100%">
                                            @endif
                                            <div class="col-12">
                                                <div class="row mb-3 my-3">
                                                    <label> @lang('admin.image')</label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control" type="file" name="image">
                                                    </div>
                                                </div>
                                                @if ($errors->has('image'))
                                                <span class="missiong-spam">{{ $errors->first('image') }}</span>
                                                @endif
                                            </div>


                                            {{-- Background Image ------------------------------------------------------------------------------------- --}}
                                            @if ($item->bcakground_image != null)
                                            <img src="{{ getImageThumb($item->bcakground_image) }}" alt="" style="width:100%">
                                            @endif
                                            <div class="col-12">
                                                <div class="row mb-3 my-3">
                                                    <label> @lang('admin.bcakground_image')</label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control" type="file" name="bcakground_image">
                                                    </div>
                                                </div>
                                                @if ($errors->has('bcakground_image'))
                                                <span class="missiong-spam">{{ $errors->first('bcakground_image') }}</span>
                                                @endif
                                            </div>

                                            {{-- Background Color ------------------------------------------------------------------------------------- --}}

                                            <div class="col-12">
                                                <div class="row mb-3">
                                                    <label col-form-label> @lang('admin.background_color')
                                                        :</label>
                                                    <input type="text" name="background_color" value="{{ @$item->background_color }}" placeholder="#FFFFFF" class="form-control spectrum with-add-on colorpicker-showinput-intial" id="colorpicker-showinput-intial">
                                                </div>
                                                @if ($errors->has('background_color'))
                                                <span class="missiong-spam">{{ $errors->first('background_color') }}</span>
                                                @endif
                                            </div>
                                            {{-- parent Category ------------------------------------------------------------------------------------- --}}
                                            <div class="col-12">
                                                <div class="row mb-3">
                                                    <label> @lang('categories.parent')</label>
                                                    <div class="col-sm-12">
                                                        <select class="form-select form-select-sm select2" name="parent_id">
                                                            <option value="" selected>
                                                                {{ trans('categories.select_parent') }}</option>

                                                            @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}" {{ $item->parent_id == $category->id ? 'selected' : '' }}>
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
                                                    <label> @lang('categories.sort')</label>
                                                    <div class="col-12">
                                                        <input class="form-control" type="number" name="sort" value="{{ @$item->sort }}">
                                                    </div>
                                                    @error('sort')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- -------------------status------------------------------ --}}
                                            <div class="col-sm-6 mt-3">
                                                <label class="form-check-label" for="flexSwitchCheckSuccessStatus">@lang('admin.status')</label>
                                                <div class="form-check form-switch form-check-success">
                                                    <input class="form-check-input {{ (empty($errors->first('status'))) ?: 'has-error'}}" type="checkbox" role="switch" name="status" {{  $item->status == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessStatus">
                                                    @error('status')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            {{-- ----------------------featuer------------------------ --}}
                                            <div class="col-sm-6 mt-3">
                                                <label class="form-check-label" for="flexSwitchCheckSuccessFeatuer">@lang('charityProject.featuer')</label>
                                                <div class="form-check form-switch form-check-success">
                                                    <input class="form-check-input {{ (empty($errors->first('feature'))) ?: 'has-error'}}" type="checkbox" role="switch" name="feature" {{  $item->feature == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessFeatuer">
                                                    @if ($errors->has('featuer'))
                                                    <span class="missiong-spam">{{ $errors->first('feature') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        {{-- Butoooons ------------------------------------------------------------------------- --}}
                        <div class="row mb-3 text-end">
                            <div>
                                <a href="{{ route('admin.eccommerce.categories.index') }}" id="chiledBack" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm"">@lang('button.cancel')</a>
                                <button type="submit" class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm"">@lang('button.update')</button>
                                <button type="submit" name="submit" value="update" class="btn btn-outline-success waves-effect waves-light btn-sm">@lang('button.save_update')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div> <!-- end col -->

@endsection


@section('style')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ asset('site/js/ckeditor/ckeditor.js') }}"></script>
@endsection
