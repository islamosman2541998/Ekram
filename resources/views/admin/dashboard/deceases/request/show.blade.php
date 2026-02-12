@extends('admin.app')

@section('title', trans('decease.show_decease_request'))
@section('title_page', trans('decease.decease_request'))
@section('title_route', route('admin.deceases.request.index') )
@section('button_page')
<a href="{{ route('admin.deceases.request.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection



@section('content')
<div class="card">
    <div class="card-body">
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
                                            <input type="text" id="form8Example1" class="form-control @error('name') is-invalid @enderror" disabled value="{{ $decease->name }}" name="name" />

                                        </div>
                                        <!-- Email input -->
                                        <div class="form-outline mt-2">
                                            <label class="form-label" for="form8Example2">@lang('users.email')
                                            </label>
                                            <input type="email" id="form8Example2" class="form-control @error('email') is-invalid @enderror" disabled value="{{ $decease->email }}" name="email" />
                                        </div>
                                        <!-- mobile input -->
                                        <div class="form-outline mt-2">
                                            <label class="form-label" for="form8Example3">@lang('users.mobile')</label>
                                            <input type="text" id="form8Example3" name="mobile" class="form-control @error('mobile') is-invalid @enderror" disabled value="{{ $decease->mobile }}" />
                                        </div>
                                    </div>
                                    <div class="col-6 mt-1">
                                        <!-- description input -->
                                        <div class="form-outline">
                                            <label class="form-label" for="form8Example5">@lang('admin.description')</label>
                                            <textarea name="description" id="" rows="8" class="form-control @error('description') is-invalid @enderror" disabled readonly>{{ $decease->description }}</textarea>
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
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-7">
                                                <div class="row">
                                                    <!-- Name input -->
                                                    <div class="form-outline">
                                                        <label class="form-label" for="form8Example1">@lang('decease.deceased_name')</label>
                                                        <input type="text" disabled id="form8Example1" class="form-control @error('deceased_name') is-invalid @enderror" value="{{ @$decease->deceased_name }}" name="deceased_name" />

                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <!-- relative_relation input -->
                                                    <div class="form-outline">
                                                        <label class="form-label" for="form8Example2">@lang('decease.relative_relation')
                                                        </label>
                                                        <input type="text" disabled id="form8Example2" class="form-control @error('relative_relation') is-invalid @enderror" value="{{ @$decease->relative_relation  }}" name="relative_relation" />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <!-- target_price input -->
                                                    <div class="form-outline">
                                                        <label class="form-label" for="form8Example2">@lang('decease.target_price')
                                                        </label>
                                                        <input type="number" disabled id="form8Example2" class="form-control @error('target_price') is-invalid @enderror" value="{{ @$decease->target_price  }}" name="target_price" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <a href="{{ getImage($decease->deceased_image) }}" target="_blank">
                                                    <img src="{{ getImageThumb($decease->deceased_image) }}" alt="" style="width:100%">
                                                </a>
                                            </div>

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
                                {{ trans('decease.deceased_image') }}
                            </button>
                        </h2>
                        <div id="collapseOne2" class="accordion-collapse collapse show" aria-labelledby="headingOne2" data-bs-parent="#accordionExample2">
                            <div class="accordion-body">
                                {{-- project_id ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3 title-section">
                                    <label class="col-sm-3 col-form-label">@lang('decease.project')</label>
                                    <div class="col-sm-8 mt-1">
                                        <a href="{{ route('admin.charity.projects.show', $decease->project->id) }}" target="_blank">
                                            <p>{{ @$decease->Project->trans?->where('locale',$current_lang)->first()->title }}</p>
                                        </a>
                                    </div>
                                </div>

                                {{-- <div class="col-md-6 mt-1">
                                    <label class="form-label" for="form8Example5">@lang('users.image')</label>
                                    <a href="{{ getImage($decease->deceased_image) }}" target="_blank">
                                        <img src="{{ getImage($decease->deceased_image) }}" alt="" style="width:100%">
                                    </a>
                                </div> --}}

                            </div>
                        </div>
                    </div>
                </div>
                {{-- ------ End Appearance settings------ --}}
            </div>
            <div class="col-md-12">
                <div>
                    @if ($decease->confirmed == 1)
                    <button class="btn btn-success waves-effect waves-light ml-3 btn-sm" disabled>@lang('decease.confirmed') <i class="bx bxs-check-square"></i> </button>
                    @else
                    <button id="showConfirm" class="btn btn-danger waves-effect waves-light ml-3 btn-sm"><i class="bx bx-no-entry"></i> @lang('decease.approve?') </button>
                    @endif

                </div>
            </div>
            {{-- Show Projects --}}
            <div class="col-md-12">
                <div class="confirmed d-none" id="hiddenConfirm">
                    @include('admin.dashboard.deceases.request.project')
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
<script type="text/javascript">
    colorPicker.select();

</script>

<script>
    

    $(document).ready(function() {

        $("#showConfirm").click(function() {
            // $("#chooseTest").hide();
            $("#hiddenConfirm").removeClass('d-none');
            $(this).attr('disabled', 'disabled');

        });

        // Start Donation Type
        $("#denation-type").change(function() {
            if ($(this).val() == "share") {
                $("#section-share-value").show();
                $(".d-none").removeClass();
                $("#section-fixed-value").hide();
                $("#section-donation-value").hide();
                $("#section-donation-value .row").html('');

            } else if ($(this).val() == "fixed") {
                $("#section-fixed-value").show();
                $(".d-none").removeClass();
                $("#section-share-value").hide();
                $("#section-donation-value").hide();
                $("#section-share-value .row").html('');
                $("#section-donation-value .row").html('');

            } else if ($(this).val() == "unit") {
                $("#section-donation-value").show();
                $(".d-none").removeClass();
                $("#section-share-value").hide();
                $("#section-fixed-value").hide();
                $("#section-share-value .row").html('');
            } else {
                $("#section-share-value").hide();
                $("#section-fixed-value").hide();
                $("#section-donation-value").hide();
                $("#section-share-value .row").html('');
                $("#section-donation-value .row").html('');
            }
        });
        // End Donation Type

    });

</script>
{{-- form repeat --}}

{{-- Start Script html share value --}}
<script>
    $(document).ready(function() {
        $('#add_ads_section').on('click', function() {
            $('#ads_section').append(
                `
              <div>
                  <div class="row">
                      <div class="col-5">
                          <div class="mb-3">
                              <label for="example-share_name-input"  > @lang('charityProject.donation_name_share')</label>
                              <div class="col-sm-12">
                                  <input type="" name="share_name[]"   class="form-control" required>
                              </div>
                          </div>
                      </div>

                      <div class="col-5">
                          <div class="mb-3">
                              <label for="example-share_value-input"  > @lang('charityProject.donation_value_share')</label>
                              <div class="col-sm-12">
                                  <input type="number" name="share_value[]"  class="form-control"  required min="0">
                              </div>
                          </div>
                      </div>
                      <div class="col-2">
                          <button type="button" class="delete_ads btn btn-neutral text-danger btn-sm mt-3"><i class="bx bx-x-circle"></i></button>
                      </div>
                  <hr>
                  </div>
              `
            )

        });


        $('#ads_section').on('click', '.delete_ads', function(e) {
            $(this).parent().parent().remove();
        })
    });

</script>
{{-- End Script html share value --}}

{{-- Start Script html deomention value --}}
<script>
    $(document).ready(function() {
        $('#add_donation_section').on('click', function() {
            $('#donation_section').append(
                `
                  <div>
                      <div class="row">
                          <div class="col-5">
                              <div class="mb-3 row">
                                  <label for="example-donation_name-input"  > @lang('charityProject.donation_name')</label>
                                  <div class="col-sm-12">
                                      <input type="" name="donation_name[]"   class="form-control" required>
                                  </div>
                              </div>
                          </div>

                          <div class="col-5">
                              <div class="mb-3 row">
                                  <label for="example-donation_value-input"  > @lang('charityProject.donation_value')</label>
                                  <div class="col-sm-12">
                                      <input type="number" name="donation_value[]"  class="form-control"  required  min="0">
                                  </div>
                              </div>
                          </div>
                          <div class="col-2">
                              <button type="button" class="delete_ads btn btn-neutral text-danger btn-sm mt-3"><i class="bx bx-x-circle"></i></button>
                          </div>
                      <hr>

                      </div>

                  `
            )

        });


        $('#donation_section').on('click', '.delete_ads', function(e) {
            $(this).parent().parent().remove();
        })
    });

</script>
{{-- End Script html deomention value --}}
@endsection
