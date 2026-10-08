<div>
    <style>
 
@media (min-width: 481px) and (max-width: 767px)
{
    .amount-btn {
    padding: 11px 15px  !important;
   
}
}

   .amount-btn {
    padding: 11px 20px !important;
   
}
.amount-btn {
    padding: 11px 20px !important;
    border: 2px solid transparent;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    opacity: 0.85;
}

.amount-btn.active {
    border: 3px solid #333 !important;
    opacity: 1;
    transform: scale(1.05);
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}

</style>
    <div class="gift-option">
        <span class="gift-text">تبرع عن أسرتك و أصدقائك و شاركهم الأجر</span>
        <i class="fa-solid fa-gift"></i>
        <input type="checkbox" class="gift-checkbox" wire:model.live="giftStatus" wire:change="startGift" />
    </div>

    <div class="gift-container" style="@if (!$giftStatus) display: none !important; @endif;">
        @forelse($cardFields as $index => $field)
        @if (isset($cardInfo[$index]['saved']) && $cardInfo[$index]['saved'])
        @php
            $savedImg = $cardFields[$index]['image'] ?? null;
            $savedTitle = $cardFields[$index]['cardTitle'] ?? null;
        @endphp
        <div class="gift-form saved-card">
            <button type="button" class="gift-remove" wire:click="removeField({{ $index }})" title="حذف">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="gift-saved">
                @if ($savedImg)
                    <a class="gift-saved__card" href="{{ getImageFileManger($savedImg) }}" target="_blank" title="عرض البطاقة">
                        <img src="{{ asset(getImage($savedImg)) }}" alt="بطاقة الإهداء">
                    </a>
                @else
                    <span class="gift-saved__card gift-saved__card--empty"><i class="fa-solid fa-gift"></i></span>
                @endif

                <div class="gift-saved__info">
                    <span class="gift-saved__badge"><i class="fa-solid fa-circle-check"></i> تم حفظ الإهداء</span>
                    <div class="gift-saved__name">{{ $cardFields[$index]['giver_name'] ?? '' }}</div>
                    <div class="gift-saved__meta">
                        @if (!empty($cardFields[$index]['giver_mobile']))
                            <span dir="ltr"><i class="fa-solid fa-mobile-screen"></i> {{ $cardFields[$index]['giver_mobile'] }}</span>
                        @endif
                        @if (!empty($savedTitle))
                            <span><i class="fa-regular fa-image"></i> {{ $savedTitle }}</span>
                        @endif
                    </div>
                </div>

                <div class="gift-saved__amount">
                    {{ $cardFields[$index]['donationAmt'] ?? 0 }}
                    <small>ر.س</small>
                </div>
            </div>

            @if (!empty($cardFields[$index]['sendCopy']))
                <div class="gift-saved__note">
                    <i class="fa-solid fa-paper-plane"></i> سيتم إرسال نسخة من البطاقة إلى جوالك
                </div>
            @endif
        </div>
        @else
        <div class="gift-form mb-4">
            <button type="button" class="gift-remove" wire:click="removeField({{ $index }})" title="حذف">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <h4 class="gift-form__title"><i class="fa-solid fa-gift"></i> بيانات المهدى إليه</h4>

            @if ($index == $errorIndex)
            <div class="alert alert-danger text-center" role="alert">
                {{ $cardInfoMessage }}
            </div>
            @endif

            <!-- Donation Amount Section -->
            <div class="gift-donation-section mb-3">
                <div class="donation-label mb-2">مبلغ التبرع</div>
                <div class="donation-amounts gift-amounts @if (is_array($donation) && in_array($donation['type'], ['unit', 'open'])) is-wrapper @endif">
                    @if (is_array($donation))
                        @switch($donation['type'])
                            @case('unit')
                                <div class="donation-amounts  text-center">
                                    @forelse (@$donation['data'] ?? [] as $key => $data)
                                    <label data-toggle="tooltip" data-placement="top" title="{{ $data['name'] }}"  style="background-color:{{ is_array($colors) && count($colors) > 0 ? $colors[$key % count($colors)] : '#ccc' }}" 
                                        class="amount-btn amount-btn {{ $cardFields[$index]['unitValueRadio'] == json_encode($data) ? 'active' : null }} ">
                                        <input wire:model.live="cardFields.{{ $index }}.unitValueRadio" type="radio" value="{{ json_encode($data) }}"  wire:click="updateDonation({{ $index }})" style="display: none">
                                        <div class="price">
                                            <span>{{ $data['value'] }}</span>
                                            {{-- <small class="large-screen"> &#65020;</small> --}}
                                        </div>
                                    </label>
                                    @empty
                                    @endforelse
                                </div>
                                <div class="custom-amount">
                                    <input type="number" wire:model.live="cardFields.{{ $index }}.unitValueInput" wire:change="updateDonation({{ $index }})"  min="0" placeholder="@lang('Another amount')" class="amount-input" />
                                    <span class="currency">رس</span>
                                </div>
                                @break

                            @case('share')
                                @foreach ($donation['data'] as $key => $data)
                                    @php
                                    $color = is_array($colors) && count($colors) > 0 ? $colors[$key % count($colors)] : '#36a2eb';
                                    @endphp
                                    <label class="amount-btn {{ @$cardFields[$index]['shareValue']  == json_encode($data) ? 'active' : null }}" style="background-color: {{ $color }};" data-toggle="tooltip" data-placement="top" title="{{ $data['name'] }}">
                                        <input type="radio" wire:model.live="cardFields.{{ $index }}.shareValue" value="{{ json_encode($data) }}" wire:click="updateDonation({{ $index }})" style="display: none" />
                                        {{ $data['value'] }}
                                    </label>
                                @endforeach
                                @break

                            @case('fixed')
                                <button class="amount-btn" style="background-color: {{ is_array($colors) && count($colors) > 0 ? $colors[0] : '#36a2eb' }};">
                                    {{ $donation['data'] }} رس
                                </button>
                                @break

                            @case('open')
                                <div class="custom-amount">
                                    <input type="number" wire:model.live="cardFields.{{ $index }}.openValue" wire:change="updateDonation({{ $index }})" class="form-control text-center" placeholder="أدخل المبلغ" min="1" required>
                                    <span class="currency">رس</span>
                                </div>
                                @break

                            @default
                                @foreach ($donation['data'] as $key => $data)
                                @php
                                $color = is_array($colors) && count($colors) > 0 ? $colors[$key % count($colors)] : '#36a2eb';
                                @endphp
                                <label class="amount-btn" style="background-color: {{ $color }};">
                                    <input type="radio" wire:model.live="cardFields.{{ $index }}.donationAmt" value="{{ $data['value'] }}" style="display: none" />
                                    <div class="price">
                                        <span>{{ $data['value'] }}</span>
                                    </div>
                                </label>
                                @endforeach
                        @endswitch
                    @else
                        @foreach ($donation['data'] as $key => $data)
                            @php
                            $color = is_array($colors) && count($colors) > 0 ? $colors[$key % count($colors)] : '#36a2eb';
                            @endphp
                            <label class="amount-btn" style="background-color: {{ $color }};">
                                <input type="radio" wire:model.live="cardFields.{{ $index }}.donationAmt" value="{{ $data['value'] }}" style="display: none" />
                                <div class="price">
                                    <span>{{ $data['value'] }} رس</span>
                                </div>
                            </label>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="inputs-container">
                    <!-- Recipient Inputs -->
                    <div class="form-group">
                        <label>الاسم</label>
                        <input type="text" class="form-control" wire:model="cardFields.{{ $index }}.giver_name" placeholder="اسم المستلم" />
                    </div>
                    <div class="form-group">
                        <label>الجوال <span class="text-muted">(اجباري)</span></label>
                        <input type="tel" class="form-control" wire:model="cardFields.{{ $index }}.giver_mobile" placeholder="رقم الجوال" oninput="this.value = this.value.replace(/[^0-9]/g, '');" maxlength="9" required />
                    </div>
                </div>
            </div>

            <!-- Copy to mobile -->
            <div class="send-copy-container">
                <input type="checkbox" class="form-check-input" id="send_copy_checkbox" wire:model="cardFields.{{ $index }}.sendCopy" />
                <label class="form-check-label">إرسال نسخة من البطاقة إلى جوالي</label>
            </div>

            <!-- Gift Category -->
            <div class="form-group mb-3">
                <label class="gift-category-label">فئة الإهداء</label>
                <select wire:model="cardFields.{{ $index }}.giftType" class="form-select" wire:change="selectGiftType({{ $index }})">
                    <option value="">اختيار فئة الإهداء</option>
                    @foreach (json_decode($cards ?? '', true) ?? [] as $keyCard => $cardtitle)
                    <option value="{{ $keyCard }}">
                        {{ $cardtitle['title_' . app()->getLocale()] }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div id="gift_cards_container" class="gift-cards-container">
                <!-- Gift Cards -->
                @if (!empty($cardInfo[$index]['cardImages']))
                <div class="gift-cards-grid">
                    @foreach (json_decode($cardInfo[$index]['cardImages'], true) as $keyImg => $img)
                    <label class="btn btn-light gift-img group-img image-selector @if ($cardFields[$index]['image'] == $img) active @endif" for="gift-{{ $keyImg }}">
                        <input type="radio" id="gift-{{ $keyImg }}" class="d-none" value="{{ $img }}" wire:model.live="cardFields.{{ $index }}.image" required="">
                        <img src="{{ asset(getImage($img)) }}" alt="بطاقة إهداء">
                    </label>
                    @endforeach
                </div>
                @endif
            </div>

            <div class="gift-actions">
                <button class="btn btn-primary btn-xs gift-save" wire:click="saveGiftInfo({{ $index }})">
                    <i class="fa-solid fa-check"></i> حفظ
                </button>
            </div>
        </div>
        @endif
        @empty
        @endforelse

        <!-- Add Another Gift Button -->
        @if ($cardFields)
        <div class="gift-add-wrap">
            <button class="btn btn-primary gift-btn" id="add_another_gift" wire:click="addField">
                <i class="fa-solid fa-plus"></i> @lang('Add a gift for someone else')
            </button>
        </div>
        @endif
    </div>

    <!-- Modal for gift card preview -->
    <div class="modal fade" id="popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <!-- Image will be inserted here -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        function initializeImageSelectors() {
            document.querySelectorAll('.image-selector').forEach(function(selector) {
                selector.addEventListener('click', function() {
                    const container = this.closest('.gift-cards-grid');

                    container.querySelectorAll('.image-selector').forEach(function(s) {
                        s.classList.remove('active');
                    });

                    this.classList.add('active');

                    const radioInput = this.querySelector('input[type="radio"]');
                    if (radioInput) {
                        radioInput.checked = true;
                        radioInput.dispatchEvent(new Event('change'));
                    }
                });
            });
        }

        function initializeDonationButtons() {
            document.querySelectorAll('.donation-amount-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const container = this.closest('.donation-amount-buttons');

                    container.querySelectorAll('.donation-amount-btn').forEach(function(b) {
                        b.classList.remove('active');
                    });

                    this.classList.add('active');
                });
            });
        }

        initializeImageSelectors();
        initializeDonationButtons();

        document.addEventListener('livewire:load', function() {
            initializeImageSelectors();
            initializeDonationButtons();
        });

        document.addEventListener('livewire:initialized', function() {
            initializeImageSelectors();
            initializeDonationButtons();
        });

        Livewire.hook('message.processed', (message, component) => {
            setTimeout(() => {
                initializeImageSelectors();
                initializeDonationButtons();
            }, 100);
        });
    });

</script>
