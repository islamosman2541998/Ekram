@extends('admin.app')

@section('title', trans('products.show', ['name' => @$product->trans->where('locale',$current_lang)->first()->title]) )))
@section('title_page', trans('products.products') )
@section('title_route', route('admin.eccommerce.products.index') )
@section('button_page')
<a href="{{ route('admin.eccommerce.products.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection




@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="col-12 m-3">
            <div class="row mb-3 text-end">
                <div>
                    <a href="{{ route('admin.eccommerce.products.index') }}" class="btn btn-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.eccommerce.products.update',$product->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col-md-8">
                                @foreach ($languages as $key => $locale)
                                <div class="accordion mt-4 mb-4" id="accordionTitle">
                                    <div class="accordion-item border rounded">
                                        <h2 class="accordion-header" id="headingTitle{{ $key }}">
                                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTitle{{ $key }}" aria-expanded="true" aria-controls="collapseTitle{{ $key }}">
                                                {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                            </button>
                                        </h2>
                                        <div id="collapseTitle{{ $key }}" class="accordion-collapse collapse show mt-3" aria-labelledby="headingTitle{{ $key }}" data-bs-parent="#accordionTitle">
                                            <div class="accordion-body">
                                                {{-- title ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.title_in') .
                                                            trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-control" type="text" disabled name="{{ $locale }}[title]" value="{{ $product->trans->where('locale',$locale)->first()->title }}" id="title{{ $key }}">
                                                    </div>
                                                    @if ($errors->has($locale . '.title'))
                                                    <span class="missiong-spam">{{ $errors->first($locale .
                                                            '.title') }}</span>
                                                    @endif
                                                </div>

                                                {{-- Start Slug --}}
                                                <div class="row mb-3 slug-section">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.slug_in') .
                                                            trans('lang.' . Locale::getDisplayName($locale)) }}
                                                    </label>
                                                    <div class="col-sm-10">
                                                        <input type="text" id="slug{{ $key }}" disabled name="{{ $locale }}[slug]" value="{{  $product->trans->where('locale',$locale)->first()->slug }}" class="form-control slug">
                                                        @if ($errors->has($locale . '.slug'))
                                                        <span class="missiong-spam">{{ $errors->first($locale .
                                                                '.slug') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                @include('admin.layouts.scriptSlug')
                                                {{-- End Slug --}}

                                                {{-- description  -------------------------------------------------------------------------------------  --}}
                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">
                                                        @lang('admin.description_in')
                                                        {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                                    </label>
                                                    <div class="col-sm-10 mb-2">
                                                        <textarea id="description{{ $key }}" name="{{ $locale }}[description]" disabled> {{ $product->trans->where('locale',$locale)->first()->description}} </textarea>
                                                        @if ($errors->has($locale . '.description'))
                                                        <span class="missiong-spam">{{ $errors->first($locale .
                                                                '.description') }}</span>
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

                                <div class="accordion mt-4 mb-4" id="accordionExampleSlug">
                                    <div class="accordion-item border rounded">
                                        <h2 class="accordion-header" id="headingTwoSlug{{ $key }}">
                                            <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo{{ $key }}" aria-expanded="true" aria-controls="collapseTwo{{ $key }}">
                                                @lang('admin.meta')
                                            </button>
                                        </h2>
                                        <div id="collapseTwo{{ $key }}" class="accordion-collapse collapse mt-3" aria-labelledby="headingTwoSlug{{ $key }}" data-bs-parent="#accordionExampleSlug">
                                            <div class="accordion-body">
                                                @foreach ($languages as $key => $locale)
                                                {{-- meta_title_ ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-control" type="text" name="{{ $locale }}[meta_title]" value="{{ @$product->trans->where('locale', $locale)->first()->meta_title }}" id="title{{ $key }}" disabled>
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
                                                        <textarea name="{{ $locale }}[meta_description]" class="form-control description" disabled> {{ @$product->trans->where('locale', $locale)->first()->meta_description }} </textarea>
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
                                                        <textarea name="{{ $locale }}[meta_key]" class="form-control description" disabled> {{ @$product->trans->where('locale', $locale)->first()->meta_key }} </textarea>
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
                                {{-- ------ Start Post Settings------ --}}
                                <div class="accordion mt-4 mb-4" id="accordionExampleSettings">
                                    <div class="accordion-item border rounded">
                                        <h2 class="accordion-header" id="headingSettings">
                                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSettings" aria-expanded="true" aria-controls="collapseSettings">
                                                {{ trans('products.settings') }}
                                            </button>
                                        </h2>
                                        <div id="collapseSettings" class="accordion-collapse collapse show" aria-labelledby="headingSettings" data-bs-parent="#accordionExampleSettings">
                                            <div class="accordion-body">
                                                {{-- sort  -------------------------------------------------------------------------------------  --}}
                                                <div class="col-12">
                                                    <div class="row mb-3">
                                                        <label> @lang('articles.sort')</label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" type="number" name="sort" disabled value="{{ @$product->sort }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- sku  ------------------------------------------------------------------------------------- --}}
                                                <div class="col-12">
                                                    <div class="row mb-3">
                                                        <label> @lang('products.sku')</label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" type="text" name="sku" disabled value="{{ @$product->sku }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- price    ------------------------------------------------------------------------------------- --}}
                                                <div class="col-12">
                                                    <div class="row mb-3">
                                                        <label> @lang('products.price')</label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" type="text" name="price" disabled value="{{ @$product->price }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- vendor_price    ------------------------------------------------------------------------------------- --}}
                                                <div class="col-12">
                                                    <div class="row mb-3">
                                                        <label> @lang('products.vendor_price')</label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" type="text" name="vendor_price" disabled value="{{ @$product->vendor_price }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- sale_price -------------------------------------------------------------------------------------    --}}
                                                <div class="col-12">
                                                    <div class="row mb-3">
                                                        <label>
                                                            @lang('products.sale_price') <a href="javascript:;" id="addTime">@lang('products.addTime')</a> <a href="javascript:;" id="cancel" class="d-none">@lang('products.cancel')</a></label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" type="text" name="sale_price" disabled value="{{  @$product->sale_price }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- start_at -------------------------------------------------------------------------------------  --}}
                                                <div class="row d-none" id="dateForm">
                                                    <div class="col-12">
                                                        <div class="row mb-3">
                                                            <label>
                                                                @lang('products.start_at')</label>
                                                            <div class="col-sm-12">
                                                                <input class="form-control" type="date" id="example-number-input" name="start_at" disabled value="{{  @$product->start_at}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- end_at  ------------------------------------------------------------------------------------- --}}
                                                    <div class="col-12">
                                                        <div class="row mb-3">
                                                            <label>
                                                                @lang('products.end_at')</label>
                                                            <div class="col-sm-12">
                                                                <input class="form-control" type="date" id="example-number-input" name="end_at" disabled value="{{  @$product->end_at }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                                {{-- ----------------------featuer------------------------ --}}
                                                <div class="row mb-3">

                                                    <div class="col-12">
                                                        <label class="col-md-6"> {{ trans('charityProject.featuer') }}</label>
                                                        @if($product->featuer == 1 )
                                                        <span class="badge bg-success">@lang("admin.yes")</span>
                                                        @else
                                                        <span class="badge bg-danger">@lang("admin.no")</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                {{-- kafara  ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3 title-section">
                                                    <label for="example-text-input" class="col-sm-12 col-form-label">@lang('admin.status')</label>
                                                    <div class="col-sm-12">
                                                        <select class="form-select form-select-sm" name="status" disabled aria-label=".form-select-sm example">
                                                            <option value="">@lang('admin.status')</option>
                                                            @foreach (App\Enums\ProductStatusEnum::values() as $status)
                                                            <option value="{{ $status }}" {{ $status==$product->
                                                                    status ? 'selected' : '' }}>
                                                                {{ $status }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                {{-- category  -------------------------------------------------------------------------------------  --}}
                                                <div class="row mb-3 title-section">
                                                    <label for="example-text-input" class="col-sm-12 col-form-label">@lang('charityProject.category')</label>
                                                    <div class="col-sm-12">
                                                        <select class="form-select form-select-sm" disabled name="category_id" aria-label=".form-select-sm example">
                                                            <option value="">@lang('charityProject.choose_category')
                                                            </option>
                                                            @foreach ($category as $item)
                                                            <option value="{{ $item->id }}" {{ $item->id ==
                                                                    $product->category_id ? 'selected' : '' }}>
                                                                {{ $item->trans->where('locale',
                                                                    $current_lang)->first()->title }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                {{-- category    -------------------------------------------------------------------------------------   --}}
                                                <div class="row mb-3 title-section">
                                                    <label for="example-text-input" class="col-sm-12 col-form-label">@lang('charityProject.vendors')</label>
                                                    <div class="col-sm-12">
                                                        <select class="form-select form-select-sm" name="vendor_id" disabled aria-label=".form-select-sm example">
                                                            <option value="">@lang('charityProject.vendors')
                                                            </option>
                                                            @foreach ($vendors as $item)
                                                            <option value="{{ $item->id }}" {{ $item->id ==
                                                                    $product->vendor_id ? 'selected' : '' }}>
                                                                {{ $item->trans->where('locale',
                                                                    $current_lang)->first()->title }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- ------ End Post Settings------ --}}
                                {{-- ------------images--------------- --}}
                                <div class="accordion mt-4 mb-4" id="accordionSettingImage">
                                    <div class="accordion-item border rounded">
                                        <h2 class="accordion-header" id="headingSettingsImage">
                                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#images_project" aria-expanded="true" aria-controls="images_project">
                                                {{ trans('charityProject.images_project') }}
                                            </button>
                                        </h2>
                                        <div id="images_project" class="accordion-collapse collapse show" aria-labelledby="headingSettingsImage" data-bs-parent="#accordionSettingImage">
                                            <div class="accordion-body">

                                                {{-- images    -------------------------------------------------------------------------------------  --}}
                                                <div class="col-12">
                                                    <label class="control-label" for="imageUpload"> @lang('admin.image') : </label>
                                                    @if ($product->image != null)
                                                    <div class="row">
                                                        @foreach (hinddelImage($product->image) as $image)
                                                        <div class="col-md-6 col-sm-12 d-flex justify-content-center mt-1">
                                                            <a href="{{ asset(pathImage($image)) }}">
                                                                <img src="{{ asset(pathImage($image)) }}" alt="Card image  m-1" width="90%">
                                                            </a>
                                                            {{-- style="width:200px; height:200px;margin:10px;" --}}
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                    @endif

                                                </div>
                                                {{-- cover image  ------------------------------------------------------------------------------------- --}}
                                                <div class="col-12">
                                                    <label class="col-sm-12 col-form-label">
                                                        @lang('charityProject.cover_image') : </label>
                                                    @if ($product->cover_image != null)
                                                    <img src="{{ getImageThumb($product->cover_image) }}" alt="Card image" style="width:200px; height:200px;margin:10px;">
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
                                    <a href="{{ route('admin.eccommerce.products.index') }}" class="btn btn-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                                    <button type="submit" class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">@lang('button.save')</button>
                                </div>
                            </div>

                        </div>


                    </form>

                </div>
            </div>
        </div>
    </div>

</div> 

@endsection


@section('style')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ asset('site/js/ckeditor/ckeditor.js') }}"></script>

@endsection

@section('script')
@livewireScripts
@endsection
