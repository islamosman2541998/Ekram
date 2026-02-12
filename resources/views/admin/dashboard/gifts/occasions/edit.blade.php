@extends('admin.app')

@section('title', trans('gifts.edit_occasion'))
@section('title_page', trans('gifts.occasions'))
@section('title_route', route('admin.gifts.occasions.index') )
@section('button_page')
<a href="{{ route('admin.gifts.occasions.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3">@lang('button.cancel')</a>
@endsection


@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('admin.gifts.occasions.update', $item->id) }}" method="post">
            @csrf
            @method('put')
            <div class="row">
                <div class="col-md-9">
                    <div class="accordion mt-4 mb-4" id="accordionExampleTitle">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingTitle">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTitle" aria-expanded="true" aria-controls="collapseTitle">
                                   @lang('admin.title')

                                </button>
                            </h2>
                            <div id="collapseTitle" class="accordion-collapse collapse show mt-3" aria-labelledby="headingOne" data-bs-parent="#accordionExampleTitle">
                                <div class="accordion-body">
                                    @foreach ($languages as $key => $locale)
                                        {{-- title ------------------------------------------------------------------------------------- --}}
                                        <div class="row mb-3">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">{{ trans('admin.title_in') . trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                            <div class="col-sm-12">
                                                <input type="text" id="title{{ $key }}" name="{{ $locale }}[title]" value="{{ @$item->trans->where('locale',$locale)->first()->title}}" class="form-control" required>
                                                @if($errors->has($locale .'.title'))
                                                <span class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                                @endif
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
                                   

                                    {{-- sort ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label for="example-number-input"> @lang('categories.sort')</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="number" name="sort" value="{{ $item->sort }}">
                                            </div>
                                            @error('sort')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>


                                    {{-- Status ------------------------------------------------------------------------------------- --}}
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-check form-switch form-check-success">
                                                <label class="form-check-label" for="flexSwitchCheckSuccessStatus">@lang('admin.status')</label>
                                                <input class="form-check-input" type="checkbox" role="switch" name="status" {{  $item->status == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessStatus">
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
                </div>

                {{-- Butoooons ------------------------------------------------------------------------- --}}
                <div class="row mb-3 text-end">
                    <div>
                        <a href="{{ route('admin.gifts.occasions.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                        <button type="submit" class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">@lang('button.save')</button>
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
