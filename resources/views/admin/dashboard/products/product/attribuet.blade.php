@if (isset($product) && $unique_attributeSet->first() != null)
    <div class="accordion mt-4 mb-4" id="accordionExample">
        <div class="accordion-item border rounded">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    @lang('attribute.attrbiutesSet')
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse show mt-3" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    @livewire('admin.product.variance-product-table', ['product' => $product, 'unique_attributeSet' => $unique_attributeSet,'product_id' => $product->id])
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="modal fade" id="secondModal" tabindex="-1" role="dialog" aria-labelledby="secondModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="card-body mt-0 pt-0">
                        <iframe width="100%" height="500" src="{{ asset('backend/filemanager/dialog.php') }}?type=2&field_id=galery_vairians&relative_url=1" frameborder="0" style="overflow: scroll; overflow-x: hidden; overflow-y: scroll; "></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="accordion mt-4 mb-4" id="accordionExample">
        <div class="accordion-item border rounded">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    @lang('attribute.attrbiutesSet')
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse show mt-3" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <div class="row mb-3 ">
                        <div id="ads_section">
                            <div class="row section ">
                                <div class="col-sm-6">
                                    <label for="example-text-input" class="col-sm-12 col-form-label">@lang('attribute.attrbiutesSet')</label>
                                    <select class="form-select form-select-sm attribute-set" name="attributes[attributesSet_id][]" id="attrbiutesSet" aria-label=".form-select-sm example">
                                        <option value="">@lang('attribute.choose_attrbiutesSet')</option>
                                        @foreach ($attribute_set as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->trans->where('locale', $current_lang)->first()->title }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="example-text-input" class="col-sm-12 col-form-label">@lang('attribute.attributeValue')</label>
                                    <select class="form-select form-select-sm attribute-value" name="attributes[attributevalue_id][]" id="attributeValue" aria-label=".form-select-sm example">
                                    </select>
                                </div>

                            </div>
                        </div>
                        <button type="button" class="btn btn-success form-control mt-2" id="add_ads_section">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<script>
    $(document).ready(function() {

        $('#addTime_variance').click(function() {
            $('#dateForm_variance').removeClass("d-none");
            $('#cancel_variance').removeClass("d-none");
            $(this).addClass('d-none');
        });

        $('#cancel_variance').click(function() {
            $('#dateForm_variance').addClass("d-none");
            $('#addTime_variance').removeClass("d-none");
            $(this).addClass('d-none');
        });
    });
</script>