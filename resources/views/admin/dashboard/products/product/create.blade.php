@extends('admin.app')


@section('title', trans('products.create_products'))
@section('title_page', trans('products.products'))

@section('title_route', route('admin.eccommerce.products.index') )
@section('button_page')
<a href="{{ route('admin.eccommerce.products.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection

@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="col-12 m-3">
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('admin.eccommerce.products.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                @foreach ($languages as $key => $locale)
                                <div class="accordion mt-4 mb-4" id="accordionExampleTitle">
                                    <div class="accordion-item border rounded">
                                        <h2 class="accordion-header" id="headingTitle{{ $key }}">
                                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTitle{{ $key }}" aria-expanded="true" aria-controls="collapseOne{{ $key }}">
                                                {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                            </button>
                                        </h2>
                                        <div id="collapseTitle{{ $key }}" class="accordion-collapse collapse show mt-3" aria-labelledby="headingTitle{{ $key }}" data-bs-parent="#accordionExampleTitle">
                                            <div class="accordion-body">

                                                {{-- title ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label">{{ trans('admin.title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-control" type="text" name="{{ $locale }}[title]" value="{{ old($locale . '.title') }}" id="title{{ $key }}" required />
                                                    </div>
                                                    @if ($errors->has($locale . '.title'))
                                                    <span class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                                    @endif
                                                </div>

                                                {{-- Start Slug --}}
                                                <div class="row mb-3 slug-section">
                                                    <label class="col-sm-2 col-form-label">{{ trans('admin.slug_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                    </label>

                                                    <div class="col-sm-10">
                                                        <input type="text" id="slug{{ $key }}" name="{{ $locale }}[slug]" value="{{ old($locale . '.slug') }}" class="form-control slug" required>
                                                        @if ($errors->has($locale . '.slug'))
                                                        <span class="missiong-spam">{{ $errors->first($locale . '.slug') }}</span>
                                                        @endif
                                                    </div>
                                                    @include('admin.layouts.scriptSlug')
                                                    {{-- End Slug --}}
                                                </div>

                                                {{-- description ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label">
                                                        {{ trans('admin.description_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                    </label>
                                                    <div class="col-sm-10 mt-2">
                                                        <textarea id="description{{ $key }}" name="{{ $locale }}[description]"> {{ old($locale . '.description') }} </textarea>
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

                                {{-- meta title  --}}
                                <div class="accordion mt-4 mb-4" id="accordionExampleSlug">
                                    <div class="accordion-item border rounded">
                                        <h2 class="accordion-header" id="headingSlug{{ $key }}">
                                            <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSlug{{ $key }}" aria-expanded="true" aria-controls="collapseSlug{{ $key }}">
                                                @lang('admin.meta')
                                            </button>
                                        </h2>
                                        <div id="collapseSlug{{ $key }}" class="accordion-collapse collapse mt-3" aria-labelledby="headingSlug{{ $key }}" data-bs-parent="#accordionExampleSlug">
                                            <div class="accordion-body">

                                                @foreach ($languages as $key => $locale)
                                                {{-- meta_title_ ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-control" type="text" name="{{ $locale }}[meta_title]" value="{{ old($locale . '.meta_title') }}" id="title{{ $key }}">
                                                    </div>
                                                    @if ($errors->has($locale . '.meta_title'))
                                                    <span class="missiong-spam">{{ $errors->first($locale . '.meta_title') }}</span>
                                                    @endif
                                                </div>

                                                {{-- meta_description_ ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label">
                                                        {{ trans('admin.meta_description_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                    </label>
                                                    <div class="col-sm-10 mb-2">
                                                        <textarea name="{{ $locale }}[meta_description]" class="form-control description"> {{ old($locale . '.meta_description') }} </textarea>
                                                        @if ($errors->has($locale . '.meta_description'))
                                                        <span class="missiong-spam">{{ $errors->first($locale . '.meta_description') }}</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                {{-- meta_key_ ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label">
                                                        {{ trans('admin.meta_key_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                    </label>
                                                    <div class="col-sm-10 mb-2">
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
                                {{-- ------ Start Post Settings------ --}}
                                <div class="accordion mt-4 mb-4" id="accordionSetting">
                                    <div class="accordion-item border rounded">
                                        <h2 class="accordion-header" id="headingSetting">
                                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSetting" aria-expanded="true" aria-controls="collapseSetting">
                                                {{ trans('products.settings') }}
                                            </button>
                                        </h2>
                                        <div id="collapseSetting" class="accordion-collapse collapse show" aria-labelledby="headingSetting" data-bs-parent="#accordionSetting">
                                            <div class="accordion-body">
                                                {{-- vendor ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3 title-section">
                                                    <label class="col-sm-12 col-form-label">@lang('charityProject.vendors')</label>
                                                    <div class="col-sm-12">
                                                        <select class="form-select form-select-sm" name="vendor_id" aria-label=".form-select-sm example" required>
                                                            <option value="">@lang('charityProject.vendors')</option>
                                                            @foreach ($vendors as $item)
                                                            <option value="{{ $item->id }}" {{  $item->id == old('vendor_id')? 'selected' : ''  }}> {{ $item->trans->where('locale', $current_lang)->first()->title }} </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>


                                                {{-- category ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3 title-section">
                                                    <label class="col-sm-12 col-form-label">@lang('charityProject.category')</label>
                                                    <div class="col-sm-12">
                                                        <select class="form-select form-select-sm" name="category_id" aria-label=".form-select-sm example" required>
                                                            <option value="">@lang('charityProject.choose_category')</option>
                                                            @foreach ($category as $item)
                                                            <option value="{{ $item->id }}" {{  $item->id == old('category_id')? 'selected' : ''  }}> {{ $item->trans->where('locale', $current_lang)->first()->title }} </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                {{-- sku ------------------------------------------------------------------------------------- --}}
                                                <div class="col-12">
                                                    <div class="row mb-3">
                                                        <label> @lang('products.sku') </label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" type="text" name="sku" value="{{ old('sku') }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- price ------------------------------------------------------------------------------------- --}}
                                                <div class="col-12">
                                                    <div class="row mb-3">
                                                        <label> @lang('products.price')</label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" type="number" step="any" name="price" value="{{ old('price') }}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- price ------------------------------------------------------------------------------------- --}}
                                                <div class="col-12">
                                                    <div class="row mb-3">
                                                        <label> @lang('products.vendor_price')</label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" type="number" step="any" name="vendor_price" value="{{ old('vendor_price') }}" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- sort ------------------------------------------------------------------------------------- --}}
                                                <div class="col-12">
                                                    <div class="row mb-3">
                                                        <label>
                                                            @lang('articles.sort')</label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" type="number" name="sort" value="{{ old('sort') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- status ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3 title-section">
                                                    <label class="col-sm-12 col-form-label">@lang('admin.status')</label>
                                                    <div class="col-sm-12">
                                                        <select class="form-select form-select-sm" name="status" required aria-label=".form-select-status example">
                                                            <option value="">@lang('admin.status')</option>
                                                            @forelse (App\Enums\ProductStatusEnum::values() as $status)
                                                            <option value="{{ $status }}" {{ $status == old('status') ? 'selected' : '' }}> {{ $status }}</option>
                                                            @empty
                                                            @endforelse
                                                        </select>
                                                    </div>
                                                </div>

                                                {{-- feature ------------------------------------------------------------------------------------- --}}
                                                <div class="col-6">
                                                    <label class="col-sm-6 col-form-label" for="available">{{ trans('admin.feature') }}</label>
                                                    <div class="col-sm-10">
                                                        <div class="form-check form-switch form-check-success">
                                                            <input class="form-check-input" type="checkbox" role="switch" name="feature" {{  request('status') == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessfeature">
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- ------ End Post Settings------ --}}
                                {{-- ------------images--------------- --}}
                                <div class="accordion mt-4 mb-4" id="accordionExample">
                                    <div class="accordion-item border rounded">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#images_project" aria-expanded="true" aria-controls="images_project">
                                                {{ trans('charityProject.images_project') }}
                                            </button>
                                        </h2>
                                        <div id="images_project" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">

                                                {{-- images ------------------------------------------------------------------------------------- --}}
                                                <div class="col-12">
                                                    <div class="">
                                                        <label class="control-label" for="imageUpload">@lang('admin.image')
                                                            : </label>
                                                        <div class="glr-group row">
                                                            <input id="galery" readonly name="image" class="form-control" type="text" value="{{ old('images') }}">
                                                            <a data-toggle="modal" href="javascript:;" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-primary waves-effect waves-light ml-3 btn-sm mt-1" type="button">@lang('products.select_images')</a>
                                                        </div>
                                                        <!-- /.modal -->
                                                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-xl">
                                                                <div class="modal-content">

                                                                    <div class="card-body mt-0 pt-0">
                                                                        <iframe width="100%" height="500" src="{{ asset('backend/filemanager/dialog.php') }}?type=2&field_id=galery&relative_url=1" frameborder="0" style="overflow: scroll; overflow-x: hidden; overflow-y: scroll; "></iframe>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- /.modal -->
                                                    </div>
                                                </div>
                                                {{-- cover image ------------------------------------------------------------------------------------- --}}
                                                <div class="col-12">
                                                    <div class="row mb-3">
                                                        <label for="example-number-input" class="col-sm-12 col-form-label">
                                                            @lang('charityProject.cover_image') : </label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" type="file" placeholder="@lang('admin.cover_image')" name="cover_image" value="{{ old('cover_image') }}">
                                                        </div>
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
                                    <a href="{{ route('admin.eccommerce.products.index') }}" class="btn btn-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                                    <button type="submit" class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">@lang('button.save')</button>
                                    <button type="submit" name="submit" value="new" id="submit" class="btn btn-outline-success waves-effect waves-light btn-sm">@lang('button.save_new')</button>
                                </div>
                            </div>

                        </div>


                    </form>

                </div>
            </div>
        </div> <!-- end col -->
    </div>

</div> <!-- container-fluid -->

@endsection


@section('style')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ asset('site/js/ckeditor/ckeditor.js') }}"></script>

@endsection

@section('script')

{{-- Add And Remove Class to Addtime Sial Price  --}}
<script>
    $(document).ready(function() {

        $('#addTime').click(function() {
            $('#dateForm').removeClass("d-none");
            $('#cancel').removeClass("d-none");
            $(this).addClass('d-none');
        });

        $('#cancel').click(function() {
            $('#dateForm').addClass("d-none");
            $('#addTime').removeClass("d-none");
            $(this).addClass('d-none');
        });
    });

</script>



<script>
    $(document).ready(function() {


        $('#cancel_variance').click(function() {
            $('#dateForm_variance').addClass("d-none");
            $('#addTime_variance').removeClass("d-none");
            $(this).addClass('d-none');
        });
    });

</script>
{{-- Get Data Attributes by Ajax To SelectBox  --}}
<script>
    $(document).ready(function() {
        $('#add_ads_section').on('click', function() {
            $('#ads_section').append(
                `
                    <div class="row section">
                        <div class="col-sm-6">
                            <label
                                class="col-sm-12 col-form-label">@lang('attribute.attrbiutesSet')</label>
                            <select class="form-select form-select-sm attribute-set" name="attributes[attributesSet_id][]" id="attrbiutesSet"
                                aria-label=".form-select-sm example">
                                <option value="">@lang('attribute.choose_attrbiutesSet')</option>
                                @foreach ($attribute_set as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->trans->where('locale', $current_lang)->first()->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label
                                class="col-sm-12 col-form-label">@lang('attribute.attributeValue')</label>
                            <select class="form-select form-select-sm attribute-value" name="attributes[attributevalue_id][]" id="attributeValue"
                                aria-label=".form-select-sm example">
                            </select>
                        </div>
                        <div class="col-12">
                                <button class="btn btn-danger delete_ads form-control mt-2"><i class="bx bxs-trash"></i></button>
                        </div>
                        <hr>
                    </div>


                        <script>
                            $(document).ready(function() {
                                $('.attribute-set').on('change', function() {
                                    var attrbiutesSet_id = $(this).val();
                                    if(attrbiutesSet_id  == "") $('.attribute-value').empty();
                                    let valueSelect  = $(this).closest('.section').find('.attribute-value');
                                    console.log(valueSelect);
                                    if (attrbiutesSet_id) {
                                        $.ajax({
                                            url: "{{ URL::to('admin/attribuetss') }}/" + attrbiutesSet_id,
                                            type: "GET",
                                            dataType: "json",
                                            success: function(data) {
                                                valueSelect.empty();
                                                $.each(data, function(key, value) {
                                                    valueSelect.append(
                                                        '<option value="' + key + '">' + value +
                                                        '</option>');
                                                });
                                            },
                                        });
                                    } else {
                                        console.log('AJAX load did not work');
                                    }
                                });
                            });
                    `
            )

        });


        $('#ads_section').on('click', '.delete_ads', function(e) {
            $(this).parent().parent().remove();
        })
    });

</script>

<script>
    $(document).ready(function() {
        $('.attribute-set').on('change', function() {
            var attrbiutesSet_id = $(this).val();
            if (attrbiutesSet_id == "") $('.attribute-value').empty();
            let valueSelect = $(this).closest('.section').find('.attribute-value');
            console.log(valueSelect);
            if (attrbiutesSet_id) {
                $.ajax({
                    url: "{{ URL::to('admin/attribuetss') }}/" + attrbiutesSet_id
                    , type: "GET"
                    , dataType: "json"
                    , success: function(data) {
                        valueSelect.empty();
                        $.each(data, function(key, value) {
                            valueSelect.append(
                                '<option value="' + key + '">' + value +
                                '</option>');
                        });
                    }
                , });
            } else {
                console.log('AJAX load did not work');
            }
        });
    });

</script>


@endsection
