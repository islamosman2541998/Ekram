{{-- Bank transfer receipt picker: shows uploading / attached state from the Livewire upload --}}
@php($receiptOk = $image && method_exists($image, 'getClientOriginalName') && !$errors->has('image'))
<input wire:model="image" type="file" class="pay-btn d-none" id="fileInput" accept=".pdf,.jpg,.jpeg,.png">

<label for="fileInput" class="pay-btn attach-btn {{ $receiptOk ? 'is-done' : '' }}">
    <span class="attach-state" wire:loading.remove wire:target="image">
        @if ($receiptOk)
            <i class="fa fa-check-circle"></i>
            <span class="attach-main">تم إرفاق الإيصال</span>
            <span class="attach-sub">{{ \Illuminate\Support\Str::limit($image->getClientOriginalName(), 28) }} · تغيير</span>
        @else
            <i class="fa fa-paperclip"></i>
            <span class="attach-main">ارفاق إيصال الدفع</span>
            <span class="attach-sub">Pdf - jpeg - png</span>
        @endif
    </span>
    <span class="attach-state" wire:loading.flex wire:target="image">
        <i class="fa fa-spinner fa-spin"></i>
        <span class="attach-main">جاري رفع الإيصال...</span>
    </span>
</label>
