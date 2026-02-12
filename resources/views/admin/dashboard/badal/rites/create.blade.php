@extends('admin.app')

@section('title', trans('rites.rites'))
@section('title_page', trans('rites.create_rites'))
@section('title_route', route('admin.badal.rites.index') )
@section('button_page')
    <a href="{{ route('admin.badal.rites.index') }}" class="btn btn-outline-success btn-sm">@lang('button.cancel')</a>
@endsection


@section('content')

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.badal.rites.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="accordion mt-4 mb-4" id="accordionExample">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOneq" aria-expanded="true" aria-controls="collapseOneq">
                                    @lang('admin.name')
                                </button>
                            </h2>
                            <div id="collapseOneq" class="accordion-collapse collapse show mt-3" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    @foreach ($languages as $key => $locale)
                                    {{-- title ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.title_in') . trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="{{ $locale }}[title]" value="{{ old($locale . '.title') }}" id="title{{ $key }}">
                                        </div>
                                        @if ($errors->has($locale . '.title'))
                                        <span class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    {{-- ------ Start Post Settings------ --}}
                    <div class="accordion mt-4 mb-4" id="accordionExample">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    {{ trans('tags.Post_settings') }}
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {{-- image --}}
                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label for="example-cover_image-input" class="col-sm-12 col-form-label">  @lang('rites.image') : </label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="file" placeholder="@lang('admin.cover_image')" id="example-cover_image-input" name="image" value="{{ old('cover_image') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3 title-section">
                                        <label for="example-text-input" class="col-sm-12 col-form-label">@lang('rites.badalProject')</label>
                                        <div class="col-sm-12">
                                            <select class="form-select select2" name="project_id">
                                                <option value="" selected disabled>@lang('rites.project')</option>
                                                @foreach ($badalProject as $item)
                                                    <option value="{{ $item->id }}" {{ old('project_id') == $item->id ? 'selected' : '' }}>
                                                        {{ $item->trans?->where('locale', $current_lang)->first()?->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    {{-- sort ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="example-sort-input" class="col-form-label"> @lang('admin.sort')</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input class="form-control" type="number" id="example-sort-input" name="sort" value="{{ old('sort') }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        {{-- proof ------------------------------------------------------------------------------------- --}}
                                        <div class="col-sm-5 mt-3">
                                            <label class="form-check-label" for="flexSwitchCheckSuccessConfirm">@lang('rites.need_proof')</label>
                                            <div class="form-check form-switch form-check-success">
                                                <input class="form-check-input {{ (empty($errors->first('proof'))) ?: 'has-error'}}" type="checkbox" role="switch" name="proof" {{  request('proof') == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessConfirm">
                                                @if ($errors->has('proof'))
                                                <span class="missiong-spam">{{ $errors->first('proof') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        {{-- Status ------------------------------------------------------------------------------------- --}}
                                        <div class="col-sm-5 mt-3">
                                            <label class="form-check-label" for="flexSwitchCheckSuccessStatus">@lang('admin.status')</label>
                                            <div class="form-check form-switch form-check-success">
                                                <input class="form-check-input {{ (empty($errors->first('status'))) ?: 'has-error'}}" type="checkbox" role="switch" name="status" {{  request('status') == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessStatus">
                                                @if ($errors->has('status'))
                                                <span class="missiong-spam">{{ $errors->first('status') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- ------ End Post Settings------ --}}
                </div>

                {{-- Butoooons ------------------------------------------------------------------------- --}}
                <div class="row mb-3 text-end">
                    <div>
                        <a href="{{ route('admin.badal.rites.index') }}" class="btn btn-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                        <button type="submit" class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">@lang('button.save')</button>
                        <button type="submit" name="submit" value="new" id="submit" class="btn btn-outline-success waves-effect waves-light btn-sm">@lang('button.save_new')</button>
                    </div>
                </div>

            </div>


        </form>

    </div>
</div>

@endsection
