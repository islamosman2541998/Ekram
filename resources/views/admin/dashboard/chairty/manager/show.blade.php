@extends('admin.app')

@section('title', trans('manager.show_manager'))
@section('title_page', trans('manager.managers'))
@section('title_route', route('admin.charity.managers.index') )
@section('button_page')
<a href="{{ route('admin.charity.managers.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection



@section('content')

<div class="card">
    <div class="card-body">
            <div class="row d-flex justify-content-center ">
                <div class="col-md-12 p-3">
                    <div class="accordion mt-4 mb-4 " id="accordionExampleInfo">
                        <div class="accordion-item border rounded ">
                            <h2 class="accordion-header" id="headingInfo">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInfo" aria-expanded="true" aria-controls="collapseInfo">
                                    {{ trans('manager.info_manager') }}
                                </button>
                            </h2>
                            <div id="collapseInfo" class="accordion-collapse collapse show mt-3" aria-labelledby="headingInfo" data-bs-parent="#accordionExampleInfo">
                                <div class="accordion-body">
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">{{ trans('refer.name') }}</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" name="name" value="{{ $manager->name }}" disabled>
                                            </div>
                                        </div>
                                        {{-- mobile ------------------------------------------------------------------------------------- --}}
                                        <div class="col-6">
                                            <label for="example-mobile-input" class="col-sm-12 col-form-label">{{ trans('refer.mobile') }}</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="tel" name="mobile" value="{{ $manager->account->mobile }}" disabled>
                                            </div>
                                        </div>
                                        {{-- user_name ------------------------------------------------------------------------------------- --}}
                                        <div class="col-6">
                                            <label for="example-username-input" class="col-sm-12 col-form-label">{{ trans('refer.username') }}</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="username" value="{{ $manager->account->user_name }}" name="user_name" disabled>
                                            </div>
                                        </div>
                                        {{-- email ------------------------------------------------------------------------------------- --}}
                                        <div class="col-6">
                                            <label for="example-email-input" class="col-sm-12 col-form-label">{{ trans('manager.email') }}</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="email" name="email" value="{{ $manager->account->email }}" disabled>
                                            </div>
                                        </div>
                                        {{-- Status ------------------------------------------------------------------------------------- --}}
                                        <div class="col-sm-6 mt-3">
                                            <label class="form-check-label" >@lang('admin.status')</label>
                                                @if($manager->status == 1 )
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

                <div class="col-md-12">
                    <div class="accordion mt-4 mb-4" id="accordionExampleSetting">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingSetting">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSetting" aria-expanded="true" aria-controls="collapseSetting">
                                    المسوقين


                                    
                                </button>
                            </h2>
                            <div id="collapseSetting" class="accordion-collapse collapse show" aria-labelledby="headingSetting" data-bs-parent="#accordionExampleSetting">
                                <div class="accordion-body">
                                 
                                    <ul class="row mt-2 refers">
                                        @forelse ($manager->refers as $refer)
                                            <li class="col-lg-3 col-md-4 col-sm-6">
                                                <span class="badge bg-success"> {{ $refer->name }} </span>
                                            </li>
                                        @empty
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 text-end ">
                        <div>
                            <a href="{{ route('admin.charity.managers.index') }}" class="btn btn-outline-primary waves-effect waves-light btn-sm">@lang('button.cancel')</a>
                        </div>
                    </div>

                </div>
    </div>
</div>

@endsection
