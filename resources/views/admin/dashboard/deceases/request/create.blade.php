@extends('admin.app')

@section('title', trans('decease.create_decease_request'))
@section('title_page', trans('decease.decease_request'))
@section('title_route', route('admin.deceases.request.index') )
@section('button_page')
<a href="{{ route('admin.deceases.request.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection


@section('content')

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.deceases.request.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    {{-- Start Info User --}}
                    <div class="accordion mt-4 mb-4" id="accordionExample">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingTwo5">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo5" aria-expanded="true" aria-controls="collapseTwo5">
                                    @lang('decease.info')
                                </button>
                            </h2>
                            <div id="collapseTwo5" class="accordion-collapse collapse show mt-3" aria-labelledby="headingTwo5" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <!-- Name input -->
                                            <div class="form-outline mt-2">
                                                <label class="form-label" for="form8Example1">@lang('users.name')</label>
                                                <input type="text" id="form8Example1" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" name="name" />

                                            </div>
                                            <!-- Email input -->
                                            <div class="form-outline mt-2">
                                                <label class="form-label" for="form8Example2">@lang('users.email')
                                                </label>
                                                <input type="email" id="form8Example2" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" name="email" />
                                            </div>
                                            <!-- mobile input -->
                                            <div class="form-outline mt-2">
                                                <label class="form-label" for="mobile">@lang('users.mobile')</label>
                                                <div class="input-group">
                                                    <select class="form-select" id="countryCode" name="country_code" style="max-width: 120px;">
                                                        <option value="+966">🇸🇦 +966</option>
                                                        <option value="+20">🇪🇬 +20</option>
                                                        <option value="+971">🇦🇪 +971</option>
                                                        <option value="+973">🇧🇭 +973</option>
                                                        <option value="+965">🇰🇼 +965</option>
                                                        <option value="+968">🇴🇲 +968</option>
                                                        <option value="+974">🇶🇦 +974</option>
                                                    </select>
                                                    <input type="text" id="mobile" name="mobile" class="form-control @error('mobile') is-invalid @enderror" value="{{ old('mobile') }}" />
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-6 mt-1">
                                            <!-- description input -->
                                            <div class="form-outline">
                                                <label class="form-label" for="form8Example5">@lang('admin.description')</label>
                                                <textarea name="description" id="" rows="8" class="form-control @error('description') is-invalid @enderror"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End Info User --}}

                    {{-- Start Info User --}}
                    <div class="accordion mt-4 mb-4" id="accordionExample">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingTwo4">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo4" aria-expanded="true" aria-controls="collapseTwo5">
                                    @lang('decease.info_decease')
                                </button>
                            </h2>
                            <div id="collapseTwo4" class="accordion-collapse collapse show mt-3" aria-labelledby="headingTwo5" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col">
                                            <!-- Name input -->
                                            <div class="form-outline">
                                                <label class="form-label" for="form8Example1">@lang('decease.deceased_name')</label>
                                                <input type="text" id="form8Example1" class="form-control @error('deceased_name') is-invalid @enderror" value="{{ old('deceased_name') }}" name="deceased_name" />

                                            </div>
                                        </div>
                                        <div class="col">
                                            <!-- Email input -->
                                            <div class="form-outline">
                                                <label class="form-label" for="form8Example2">@lang('decease.relative_relation')
                                                </label>
                                                <input type="text" id="form8Example2" class="form-control @error('relative_relation') is-invalid @enderror" value="{{ old('relative_relation') }}" name="relative_relation" />
                                            </div>
                                        </div>
                                        <div class="col">
                                            <!-- Email input -->
                                            <div class="form-outline">
                                                <label class="form-label" for="form8Example2">@lang('decease.target_price')
                                                </label>
                                                <input type="number" id="form8Example2" class="form-control @error('target_price') is-invalid @enderror" value="{{ old('target_price') }}" name="target_price" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mt-1">
                                            <!-- Email input -->
                                            <div class="form-outline">
                                                <label class="form-label" for="form8Example5">@lang('decease.deceased_image')</label>
                                                <input type="file" id="form8Example5" name="deceased_image" class="form-control @error('deceased_image') is-invalid @enderror" value="{{ old('deceased_image') }}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End Info User --}}
                </div>

                <div class="col-md-4">
                    {{-- ------ Start Appearance settings------ --}}
                    <div class="accordion mt-4 mb-4" id="accordionExample2">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingOne2">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne2" aria-expanded="true" aria-controls="collapseOne2">
                                    {{ trans('tags.Appearance_settings') }}
                                </button>
                            </h2>
                            <div id="collapseOne2" class="accordion-collapse collapse show" aria-labelledby="headingOne2" data-bs-parent="#accordionExample2">
                                <div class="accordion-body">
                                    {{-- project_id ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3 title-section">
                                        <label for="example-text-input" class="col-sm-12 col-form-label">@lang('decease.choose_project')</label>
                                        <div class="col-sm-12">
                                            <select class="form-select select2" name="project_id" aria-label=".form-select-sm example">
                                                <option value="">@lang('decease.choose_project')</option>
                                                @foreach ($charity_projects as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->trans->where('locale', $current_lang)->first()->title }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- image ------------------------------------------------------------------------------------- --}}
                                    <div class="form-outline">
                                        <label class="form-label" for="form8Example5">@lang('users.image')</label>
                                        <input type="file" id="form8Example5" name="image" class="form-control @error('image') is-invalid @enderror" value="{{ old('image') }}" />
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- ------ End Appearance settings------ --}}
            </div>

    </div>

    {{-- Butoooons ------------------------------------------------------------------------- --}}
    <div class="row mb-3 text-end">
        <div>
            <a href="{{ route('admin.deceases.request.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
            <button type="submit" class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">@lang('button.save')</button>
            <button type="submit" name="submit" value="new" id="submit" class="btn btn-outline-success waves-effect waves-light btn-sm">@lang('button.save_new')</button>
        </div>
    </div>
</div>
</form>
</div>
@endsection
@section('style')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ asset('site/js/ckeditor/ckeditor.js') }}"></script>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"/>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-detect user's country
        fetch('https://ipapi.co/json/')
            .then(response => response.json())
            .then(data => {
                const countryCode = data.country_calling_code || '+966'; // Default to KSA if not found
                const select = document.getElementById('countryCode');
                for (let i = 0; i < select.options.length; i++) {
                    if (select.options[i].value === countryCode) {
                        select.selectedIndex = i;
                        break;
                    }
                }
            })
            .catch(error => {
                console.error('Error detecting country:', error);
            });
    });
</script>
@endpush
