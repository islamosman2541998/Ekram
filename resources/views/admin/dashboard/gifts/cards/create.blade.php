@extends('admin.app')

@section('title', trans('gifts.create_card'))
@section('title_page', trans('gifts.cards'))
@section('title_route', route('admin.gifts.cards.index') )
@section('button_page')
<a href="{{ route('admin.gifts.cards.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3">@lang('button.cancel')</a>
@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.gifts.cards.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-9">
                    <div class="accordion mt-4 mb-4" id="accordionExampleTitle">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingTitle">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTitle" aria-expanded="true" aria-controls="collapseTitle">
                                    @lang('admin.title')
                                </button>
                            </h2>
                            <div id="collapseTitle" class="accordion-collapse collapse show mt-3" aria-labelledby="headingTitle" data-bs-parent="#accordionExampleTitle">
                                <div class="accordion-body">
                                    {{-- Categories ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label for="example-number-input"> @lang('gifts.category')</label>
                                            <div class="col-sm-12 mt-1">
                                                <select class="form-select form-select-sm select2" name="category_id" required>
                                                    <option value="" selected> {{ trans('categories.select_parent') }}</option>
                                                    @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}> {{ str_repeat('ـــ ', $category->level - 1) }} {{ @$category->trans->where('locale',$current_lang)->first()->title }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @error('parent_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- occasioins ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label for="example-number-input"> @lang('gifts.occasions')</label>
                                            <div class="col-sm-12 mt-1">
                                                <select class="form-select form-select-sm select2" multiple name="occasioins[]">
                                                    @foreach ($occasioins as $occasioin)
                                                    <option value="{{ $occasioin->id }}" {{in_array($occasioin->id,  old('occasioins')??[]) ? 'selected' : '' }}> {{ @$occasioin->trans->where('locale',$current_lang)->first()->title }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @error('parent_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="accordion mt-4 mb-4" id="accordionExampleSetting">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSetting" aria-expanded="true" aria-controls="collapseSetting">
                                    {{ trans('admin.settings') }}
                                </button>
                            </h2>
                            <div id="collapseSetting" class="accordion-collapse collapse show" aria-labelledby="headingSetting" data-bs-parent="#accordionExampleSetting">
                                <div class="accordion-body">

                                    {{-- image ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label for="example-number-input"> @lang('admin.image')</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="file" name="image" required>
                                            </div>
                                        </div>
                                        @if ($errors->has("image"))
                                        <span class="missiong-spam">{{ $errors->first("image") }}</span>
                                        @endif
                                    </div>


                                    {{-- price ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label for="example-number-price"> @lang('admin.price')</label>
                                            <div class="col-12">
                                                <input class="form-control" type="number" name="price" step="_any" value="{{ old('price') }}">
                                            </div>
                                            @error('price')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- sort ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label for="example-number-input"> @lang('categories.sort')</label>
                                            <div class="col-12">
                                                <input class="form-control" type="number" name="sort" value="{{ old('sort') }}">
                                            </div>
                                            @error('sort')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Status ------------------------------------------------------------------------------------- --}}
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="form-check form-switch form-check-success">
                                                <label class="form-check-label" for="flexSwitchCheckSuccessStatus">@lang('admin.status')</label>
                                                <input class="form-check-input" type="checkbox" role="switch" name="status" {{  request('status') == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessStatus">
                                            </div>
                                        </div>
                                        @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Butoooons ------------------------------------------------------------------------- --}}
                <div class="row mb-3 text-end">
                    <div>
                        <a href="{{ route('admin.gifts.cards.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
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
