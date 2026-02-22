<div class="addCartMoal">
    @if($showModal)
    <!-- Modal -->
    <div class="modal" style="display: {{ $showModal ? 'block' : 'none' }}">
        <div class=" show" id="alertModal" aria-modal="true" role="dialog">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- <button type="button" class="btn-close"  wire:click="closeModal" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                    <h5 class="modal-title d-flex align-items-center justify-content-center" id="exampleModalLabel">
                        <img class="img-fluid modal-img text-center" src="{{asset('img/Untitled-1.png')}}" alt="{{ env('APP_NAME') }}" height="20px" width="20px">
                    </h5>
                </div>
                <div class="modal-body">
                    <p class="text-center">
                        @if($message != null)
                        {{ $message }}
                        @else
                        @lang('The project has been successfully added to the donation basket')
                        @endif
                    </p>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('site.cart.show') }}" class="button-primary btn-sm py-2">@lang('Show Cart')</a>
                    <button type="button" wire:click="closeModal" class="button-secandry btn-sm py-2" data-bs-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
        </div>
    </div>
    @endif
</div>

<style>

    .modal-img {
        height: 60px!important;
    }
    .modal {
        z-index:999999!important;

    }
    .modal-header{
        justify-content: space-around !important;
    }
</style>