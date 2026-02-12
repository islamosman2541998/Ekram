@extends('admin.app')

@section('title', trans('gifts.show_category'))
@section('title_page', trans('gifts.categories'))
@section('title_route', route('admin.gifts.categories.index') )
@section('button_page')
<a href="{{ route('admin.gifts.categories.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3">@lang('button.cancel')</a>
@endsection


@section('content')
<div class="card">
    <div class="card-body">


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
                                @foreach ($languages as $key => $locale)
                                    {{-- title ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.title_in') . trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                        <div class="col-sm-10">
                                            <input type="text" id="title{{ $key }}" name="{{ $locale }}[title]" disabled value="{{ @$item->trans->where('locale',$locale)->first()->title}}" class="form-control" required>

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

             
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

                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="example-number-input" class="col-md-6"> @lang('categories.parent')</label>
                                        <span class="text-primary col-md-6">{{ @$item->parent?  @$item->parent->trans->where('locale',$current_lang)->first()->title :""  }}</span>
                                    </div>
                                </div>

                                {{-- sort ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="example-number-input" class="col-md-6"> @lang('categories.sort')</label>
                                        <span class="col-md-6">{{ @$item->sort  }}</span>
                                    </div>
                                </div>

                                {{-- Status ------------------------------------------------------------------------------------- --}}
                                <div class="col-12">
                                    <label class="col-sm-6 col-form-label" for="available">{{ trans('admin.status') }}</label>
                                    @if($item->status == 1 )
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
        </div>

        {{-- Butoooons ------------------------------------------------------------------------- --}}
        <div class="row mb-3 text-end">
            <div>
                <a href="{{ route('admin.gifts.categories.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3">@lang('button.cancel')</a>
            </div>
        </div>

    </div>
</div>

@endsection



@section('style')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ asset('site/js/ckeditor/ckeditor.js') }}"></script>
@endsection
