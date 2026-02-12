@extends('admin.app')

@section('title', trans('vendor.show_vendor'))
@section('title_page', trans('vendor.show_vendors'))


@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="row">
            <div class="m-3 col-12">
                <div class="mb-3 row text-end">
                    <div>
                        <a href="{{ route('admin.eccommerce.vendors.index') }}" class="ml-3 btn btn-outline-primary waves-effect waves-light btn-sm">@lang('button.cancel')</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">

                        <form action="{{ route('admin.eccommerce.vendors.update', $vendor->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-md-8">
                                    {{-- Start Info User --}}
                                    <div class="mt-4 mb-4 accordion" id="accordionExample">
                                        <div class="border rounded accordion-item">
                                            <h2 class="accordion-header" id="headingTwo5">
                                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo5" aria-expanded="true" aria-controls="collapseTwo5">
                                                    @lang('vendor.info_vendor')
                                                </button>
                                            </h2>
                                            <div id="collapseTwo5" class="mt-3 accordion-collapse collapse show" aria-labelledby="headingTwo5" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">

                                                    <div class="row">
                                                        <div class="col">
                                                            <!-- Name input -->
                                                            <div class="row">
                                                                <div class="col-12 col-md-6">
                                                                    <label class="form-label" for="form8Example1">@lang('users.name')</label>
                                                                    <input type="text" id="form8Example1" disabled class="form-control @error('responsible_person') is-invalid @enderror" value="{{ @$vendor->responsible_person }}" name="responsible_person" />
                                                                </div>
    
                                                                <div class="col-12 col-md-6">
                                                                    <label class="form-label">@lang('users.mobile')
                                                                    </label>
                                                                    <input type="text" class="form-control @error('mobile') is-invalid @enderror" value="{{ @$vendor->account->mobile }}" name="email" disabled />
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <label class="form-label">@lang('users.user_name')
                                                                    </label>
                                                                    <input type="text" class="form-control" value="{{ @$vendor->account->user_name }}" name="email" disabled />
                                                                </div>
    
                                                                <div class="col-12 col-md-6">
                                                                    <label class="form-label">@lang('users.email')
                                                                    </label>
                                                                    <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ @$vendor->account->email }}" name="email" disabled />
                                                                </div>
                                                            </div>
                                                    

                                                            <!-- logo input -->
                                                            <div class="form-outline">
                                                                <label class="form-label" for="form8Example5">@lang('users.image')</label>
                                                                <input type="file" id="form8Example5" name="logo" class="form-control @error('logo') is-invalid @enderror" value="{{ old('logo') }}" />
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- End Info User --}}

                                    @foreach ($languages as $key => $locale)
                                    <div class="mt-4 mb-4 accordion" id="accordionExample">
                                        <div class="border rounded accordion-item">
                                            <h2 class="accordion-header" id="headingOne{{ $key }}">
                                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne{{ $key }}" aria-expanded="true" aria-controls="collapseOne{{ $key }}">
                                                    {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                                </button>
                                            </h2>
                                            <div id="collapseOne{{ $key }}" class="mt-3 accordion-collapse collapse show" aria-labelledby="headingOne{{ $key }}" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    {{-- title ------------------------------------------------------------------------------------- --}}
                                                    <div class="mb-3 row">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control" type="text" name="{{ $locale }}[title]" value="{{ @$vendor->trans->where('locale', $current_lang)->first()->title }}" disabled id="title{{ $key }}">
                                                        </div>
                                                    </div>

                                                    {{-- slug ------------------------------------------------------------------------------------- --}}
                                                    <div class="mb-3 row slug-section">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.slug_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                        </label>

                                                        <div class="col-sm-10">
                                                            <input type="text" id="slug{{ $key }}" name="{{ $locale }}[slug]" value="{{ @$vendor->trans->where('locale', $current_lang)->first()->slug }}" disabled class="form-control slug" required>
                                                        </div>

                                                        {{-- description ------------------------------------------------------------------------------------- --}}
                                                        <div class="mt-3 mb-3 row">
                                                            <label for="example-text-input" class="col-sm-3 col-form-label"> @lang('admin.description_in')
                                                                {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                                            </label>
                                                            <div class="mb-2 col-sm-12">
                                                                <p>
                                                                    {!! @$vendor->trans->where('locale', $current_lang)->first()->description !!}
                                                                </p>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach

                                    <div class="mt-4 mb-4 accordion" id="accordionExample">
                                        <div class="border rounded accordion-item">
                                            <h2 class="accordion-header" id="headingTwo{{ $key }}">
                                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo{{ $key }}" aria-expanded="true" aria-controls="collapseTwo{{ $key }}">
                                                    @lang('admin.meta')
                                                </button>
                                            </h2>
                                            <div id="collapseTwo{{ $key }}" class="mt-3 accordion-collapse collapse " aria-labelledby="headingTwo{{ $key }}" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    @foreach ($languages as $key => $locale)
                                                    {{-- meta_title_ ------------------------------------------------------------------------------------- --}}
                                                    <div class="mb-3 row">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control" type="text" name="{{ $locale }}[meta_title]" value="{{ @$vendor->trans->where('locale', $current_lang)->first()->meta_title }}" disabled id="title{{ $key }}">
                                                        </div>
                                                    </div>
                                                    {{-- meta_description_ ------------------------------------------------------------------------------------- --}}
                                                    <div class="mb-3 row">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label"> @lang('admin.meta_description_in')
                                                            {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                                        </label>
                                                        <div class="mb-2 col-sm-10">
                                                            <textarea name="{{ $locale }}[meta_description]" class="form-control description" disabled> {{ @$vendor->trans->where('locale', $current_lang)->first()->meta_description }} </textarea>
                                                        </div>
                                                    </div>
                                                    {{-- meta_key_ ------------------------------------------------------------------------------------- --}}
                                                    <div class="mb-3 row">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label"> @lang('admin.meta_key_in')
                                                            {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                                        </label>
                                                        <div class="mb-2 col-sm-10">
                                                            <textarea name="{{ $locale }}[meta_key]" class="form-control description" disabled> {{ @$vendor->trans->where('locale', $current_lang)->first()->meta_key }} </textarea>
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
                                    {{-- ------ Start Appearance settings------ --}}
                                    <div class="mt-4 mb-4 accordion" id="accordionExample2">
                                        <div class="border rounded accordion-item">
                                            <h2 class="accordion-header" id="headingOne2">
                                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne2" aria-expanded="true" aria-controls="collapseOne2">
                                                    {{ trans('tags.Appearance_settings') }}
                                                </button>
                                            </h2>
                                            <div id="collapseOne2" class="accordion-collapse collapse show" aria-labelledby="headingOne2" data-bs-parent="#accordionExample2">
                                                <div class="accordion-body">
                                                    <div class="mb-3 col-sm-3">
                                                        <a href="{{ getImageThumb($vendor->logo) }}">
                                                            <img src="{{ getImageThumb($vendor->logo) }}" alt="" style="width:100%">
                                                        </a>
                                                    </div>
                                                    {{-- sort ------------------------------------------------------------------------------------- --}}

                                                    <div class="row mb-3">
                                                        <div class="col-12">
                                                            <label for="example-number-input" class="col-md-3"> @lang('categories.sort')</label>
                                                            <span class="col-md-6">{{ @$vendor->sort  }}</span>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        {{-- feature ------------------------------------------------------------------------------------- --}}
                                                        <div class="col-6">
                                                            <label for="example-number-input" class="col-md-6"> {{ trans('admin.feature') }}</label>
                                                            @if($vendor->feature == 1 )
                                                            <span class="badge bg-success">@lang("admin.active")</span>
                                                            @else
                                                            <span class="badge bg-danger">@lang("admin.dis_active")</span>
                                                            @endif
                                                        </div>

                                                        {{-- Status ------------------------------------------------------------------------------------- --}}
                                                        <div class="col-6 mb-2">
                                                            <label for="example-number-input" class="col-md-6"> {{ trans('admin.status') }}</label>
                                                            @if($vendor->status == 1 )
                                                            <span class="badge bg-success">@lang("admin.active")</span>
                                                            @else
                                                            <span class="badge bg-danger">@lang("admin.dis_active")</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- ------ End Appearance settings------ --}}
                                </div>

                                {{-- Butoooons ------------------------------------------------------------------------- --}}
                                <div class="mb-3 row text-end">
                                    <div>
                                        <a href="{{ route('admin.eccommerce.vendors.index') }}" class="ml-3 btn btn-outline-primary waves-effect waves-light btn-sm">@lang('button.cancel')</a>
                                        <button type="submit" class="ml-3 btn btn-outline-success waves-effect waves-light btn-sm">@lang('button.save')</button>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
</div> <!-- end row-->


@endsection
