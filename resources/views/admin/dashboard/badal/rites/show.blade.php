@extends('admin.app')

@section('title', trans('rites.rites'))
@section('title_page', trans('rites.show_rite'))
@section('title_route', route('admin.badal.rites.index') )
@section('button_page')
<a href="{{ route('admin.badal.rites.index') }}" class="btn btn-outline-success btn-sm">@lang('button.cancel')</a>
@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.badal.rites.update',$rites->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
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
                                            <input class="form-control" type="text" name="{{ $locale }}[title]" value="{{ @$rites->trans->where('locale', $locale)->first()->title }}" disabled>
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
                                        @if($rites->image != null)
                                        <img src="{{ getImageThumb($rites->image) }}" alt="" width="100">
                                        @endif
                                    </div>
                                    <div class="row mb-3 title-section">
                                        <div class="col-sm-3">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">@lang('rites.badalProject')</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input class="form-control" name="project_id" value="{{ @$rites->project->trans->where('locale', $locale)->first()->title }}" disabled>
                                        </div>
                                    </div>
                                    {{-- sort ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3 title-section">
                                        <div class="col-sm-3">
                                            <label for="example-number-input" class="col-md-6"> @lang('categories.sort')</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input class="form-control" name="project_id" value="{{ @$rites->sort }}" disabled>
                                        </div>
                                    </div>
                                    {{-- proof ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12 mb-3">
                                        <label for="example-number-input" class="col-md-6"> {{ trans('rites.need_proof') }}</label>
                                        @if($rites->proof == 1 )
                                        <span class="badge bg-success">@lang("admin.yes")</span>
                                        @else
                                        <span class="badge bg-danger">@lang("admin.no")</span>
                                        @endif
                                    </div>
                                    {{-- Status ------------------------------------------------------------------------------------- --}}
                                    <div class="col-12 mb-3">
                                        <label for="example-number-input" class="col-md-6"> {{ trans('admin.status') }}</label>
                                        @if($rites->status == 1 )
                                        <span class="badge bg-success">@lang("admin.active")</span>
                                        @else
                                        <span class="badge bg-danger">@lang("admin.dis_active")</span>
                                        @endif
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
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection


@section('style')

@endsection
