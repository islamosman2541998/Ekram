   @if ($show_fast_donation)
   <div>
       <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
       <style>
           .iti {
               width: 100%;
           }
           .iti-mobile .iti__country-list {
               width: 90%;
           }
           .iti__country-name {
               display: none;
           }

           /* Livewire renders only the chosen method; public/site/js/cart.js toggles .payment-content
              by image index and was hiding the bank-transfer form. */
           .fast-pay .payment-content { display: block !important; }

           /* ================= Fast donation panel: same look as the project / checkout pages ================= */
           .fast-pay {
               --fp-teal: #2C5F5D;
               --fp-teal-2: #469e8d;
               --fp-orange: #EE5A34;
               --fp-text: #1F3B3A;
               --fp-muted: #6B7C7A;
               --fp-border: #E3ECEB;
               --fp-soft: #F3F8F7;
           }

           .fast-pay .donation-form,
           .fast-pay.expanded .donation-form {
               height: auto;
               max-height: min(560px, calc(100vh - 160px));
               padding: 16px 16px 18px;
               border-radius: 0 0 16px 16px;
               background: #fff;
               box-shadow: 0 18px 40px rgba(31, 70, 69, .18);
           }

           .fast-pay .donation-form .form-title {
               margin: 14px 0 8px;
               color: var(--fp-text);
               font-size: 14px;
               font-weight: 700;
               text-align: start;
           }

           .fast-pay .donation-form .form-title::after { display: none; }
           .fast-pay .donation-form > .form-title:first-child { margin-top: 0; }

           /* categories */
           .fast-pay .donation-options { display: flex; flex-wrap: wrap; gap: 6px; margin: 0 0 10px; }

           .fast-pay .donation-option {
               margin: 0;
               padding: 7px 12px;
               border: 1px solid var(--fp-border);
               border-radius: 999px;
               background: #fff;
               color: var(--fp-text);
               font-size: 13px;
               cursor: pointer;
               transition: border-color .15s ease, background-color .15s ease, color .15s ease;
           }

           .fast-pay .donation-option:hover { border-color: var(--fp-teal-2); }
           .fast-pay .donation-option.active { border-color: var(--fp-teal); background: var(--fp-teal); color: #fff; }

           /* inputs */
           .fast-pay .project-select,
           .fast-pay .form-control,
           .fast-pay .amount-input,
           .fast-pay .bank-input {
               width: 100% !important;
               height: 44px !important;
               margin: 0 !important;
               padding: 0 12px !important;
               border: 1px solid #D6E1DF !important;
               border-radius: 10px !important;
               background-color: #fff !important;
               color: var(--fp-text) !important;
               font-size: 14px !important;
               box-shadow: none !important;
           }

           .fast-pay .project-select:focus,
           .fast-pay .form-control:focus,
           .fast-pay .amount-input:focus,
           .fast-pay .bank-input:focus {
               border-color: var(--fp-teal-2) !important;
               box-shadow: 0 0 0 3px rgba(70, 158, 141, .15) !important;
               outline: none;
           }

           .fast-pay .bank-input:disabled { background-color: var(--fp-soft) !important; }
           .fast-pay .form-group { margin: 0 0 10px !important; }
           .fast-pay .iti { display: block; width: 100%; }
           .fast-pay .iti--separate-dial-code .iti__selected-flag { border-radius: 9px 0 0 9px; background: var(--fp-soft); }

           /* amounts: admin colour per amount, ring + check on the selected one */
           .fast-pay .donation-amounts { display: block !important; width: 100%; margin: 0 !important; }
           .fast-pay .amount-group { width: 100%; }

           .fast-pay .amount-buttons {
               display: block !important;
               margin: 0 0 6px !important;
           }

           .fast-pay .amount-buttons .donation-amounts {
               display: grid !important;
               grid-template-columns: repeat(auto-fit, minmax(70px, 1fr));
               gap: 8px;
               margin: 0 0 8px !important;
           }

           .fast-pay .amount-btn {
               position: relative;
               display: flex !important;
               align-items: center;
               justify-content: center;
               width: 100% !important;
               min-height: 44px;
               margin: 0 !important;
               padding: 6px !important;
               border: 0 !important;
               border-radius: 10px !important;
               color: #fff !important;
               font-size: 15px !important;
               font-weight: 700;
               opacity: 1 !important;
               transform: none !important;
               box-shadow: 0 4px 10px rgba(31, 70, 69, .12) !important;
               cursor: pointer;
           }

           .fast-pay .amount-btn .price span { color: #fff; font-size: 15px; font-weight: 700; }

           .fast-pay .amount-btn.active {
               box-shadow: 0 0 0 2px #fff, 0 0 0 4px var(--fp-teal), 0 6px 14px rgba(31, 70, 69, .2) !important;
           }

           .fast-pay .amount-btn.active::after {
               content: "\f00c";
               position: absolute;
               top: -7px;
               inset-inline-end: -7px;
               width: 18px;
               height: 18px;
               border: 2px solid #fff;
               border-radius: 50%;
               background: var(--fp-teal);
               color: #fff;
               font-family: "Font Awesome 6 Free";
               font-size: 8px;
               font-weight: 900;
               line-height: 14px;
               text-align: center;
           }

           .fast-pay .custom-amount { position: relative; display: block !important; width: 100%; margin: 0 !important; }

           .fast-pay .custom-amount .currency {
               position: absolute;
               top: 50%;
               inset-inline-end: 12px;
               margin: 0 !important;
               transform: translateY(-50%);
               color: var(--fp-muted) !important;
               font-size: 12px !important;
               pointer-events: none;
           }

           .fast-pay .custom-amount .amount-input { padding-inline-end: 40px !important; }

           .fast-pay .donation-form > .text-danger {
               display: block;
               padding: 8px 10px;
               border-radius: 8px;
               background: #FFF6F1;
               color: #B5471F !important;
               font-size: 13px;
               text-align: center;
           }

           /* payment methods as cards */
           .fast-pay .payment-methods { margin: 0 0 6px !important; padding: 0 !important; }

           .fast-pay .payment-methods .img-container {
               display: grid !important;
               grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
               gap: 8px;
               width: 100% !important;
               margin: 0 !important;
           }

           .fast-pay .payment-methods .nav-link {
               position: relative;
               display: flex !important;
               align-items: center;
               justify-content: center;
               height: 52px;
               margin: 0 !important;
               padding: 6px !important;
               border: 1.5px solid var(--fp-border) !important;
               border-radius: 10px !important;
               background: #fff !important;
               transition: border-color .15s ease;
           }

           .fast-pay .payment-methods .nav-link:hover { border-color: var(--fp-teal-2) !important; }

           .fast-pay .payment-methods .nav-link.active {
               border-color: var(--fp-teal) !important;
               background: var(--fp-soft) !important;
               box-shadow: 0 0 0 3px rgba(44, 95, 93, .12);
           }

           .fast-pay .payment-methods .nav-link img { max-width: 100%; max-height: 28px; width: auto; height: auto; }

           /* chosen method content */
           .fast-pay .tab-content { margin: 10px 0 0 !important; }
           .fast-pay .payment-content > p,
           .fast-pay .bank-text { display: none; }

           .fast-pay .bank-fields { margin: 0 !important; padding: 0 !important; }
           .fast-pay .bank-form { display: block !important; margin: 0 0 10px !important; }

           .fast-pay .bank-form > label:not(.pay-btn) {
               display: block !important;
               margin: 0 0 5px !important;
               color: var(--fp-text) !important;
               font-size: 13px !important;
               font-weight: 600;
               text-align: start;
           }

           .fast-pay .attach-btn {
               display: flex !important;
               flex-wrap: wrap;
               align-items: center;
               justify-content: center;
               gap: 6px;
               width: 100% !important;
               min-height: 46px;
               margin: 0 !important;
               padding: 8px 12px !important;
               border: 1.5px dashed var(--fp-teal-2) !important;
               border-radius: 10px !important;
               background: var(--fp-soft) !important;
               color: var(--fp-teal) !important;
               font-size: 13.5px !important;
               font-weight: 600;
               cursor: pointer;
           }

           .fast-pay .attach-btn span { margin: 0 !important; color: var(--fp-muted) !important; font-size: 11px !important; }

           .fast-pay .cart-form-actions {
               display: flex !important;
               align-items: center;
               gap: 8px;
               margin: 6px 0 0 !important;
               padding: 0 !important;
           }

           .fast-pay .cart-form-actions .proceed-text { display: none !important; }

           .fast-pay .cart-form-actions .pay-btn {
               flex: 1;
               display: inline-flex !important;
               align-items: center;
               justify-content: center;
               gap: 8px;
               height: 46px !important;
               margin: 0 !important;
               padding: 0 16px !important;
               border: 0 !important;
               border-radius: 10px !important;
               background: linear-gradient(135deg, #F07A3F, var(--fp-orange)) !important;
               color: #fff !important;
               font-size: 15px !important;
               font-weight: 700;
               box-shadow: 0 8px 18px rgba(238, 90, 52, .22) !important;
           }

           .fast-pay .cart-form-actions .pay-btn:disabled { opacity: .6; }

           .fast-pay .cart-form-actions .cancel-btn {
               display: inline-flex !important;
               align-items: center;
               justify-content: center;
               flex: none;
               width: 46px !important;
               height: 46px !important;
               margin: 0 !important;
               padding: 0 !important;
               border: 1px solid var(--fp-border) !important;
               border-radius: 10px !important;
               background: #fff !important;
               color: var(--fp-muted) !important;
               font-size: 16px;
               text-decoration: none;
           }

           .fast-pay input[type="file"].d-none { display: none !important; }
       </style>


       <!-- quick donation  -->
       <div class="fast-pay @if($open) expanded @endif">
           <div class="container bg-fast-pay  " wire:click="toogleOpen()">
               <div class="white-layer"></div>
               <span class="plus-btn">+</span>
               <h6> @lang('Fast Donation') </h6>
           </div>


           <div class="donation-form" style="{{ $open ? 'display:block, opacity: translateX(4.13568%); transform:0.958643' :'display:none, opacity: translateX(94.338%); transform:0.0566107' }}">
               <div class="form-title">اختر نوع التبرع</div>

               <div class="donation-options">
                   @forelse($categories as $key => $category)
                   <div class="donation-option @if($selectedCategory == $category->id) active @endif" wire:click="SelectCategory({{ $category->id }})" data-option="{{ $category->trans->where('locale', $current_lang)->first()->title }}">
                       {{ $category->trans->where('locale', $current_lang)->first()->title }}
                   </div>
                   @empty

                   @endforelse
               </div>

               <!-- Project selection groups - each for a specific donation type -->
               <div class="project-selection-container">
                   <!-- Projects for الإطعام -->
                   <div class="project-group">
                       <div class="form-group">
                           <select class="project-select" wire:model="selectedProject" wire:change="SelectProject()">
                               <option value="" selected>@lang('Choose a project')</option>
                               @forelse($projects as $key => $project)
                               <option value="{{ $project->id }}">
                                   {{ $project->trans->where('locale', $current_lang)->first()->title }}
                               </option>
                               @empty
                               @endforelse
                           </select>
                       </div>
                   </div>
               </div>

               <!-- Donation Amount Buttons - Initially Hidden -->
               <div class="donation-amounts d-flex align-items-center justify-content-center" id="donation-amounts">
                   <!-- Default amounts for الإطعام -->
                   <div class="amount-group" id="projects">
                       <div class="form-title">اختر مبلغ التبرع</div>
                       <div class="donations amount-buttons  d-flex align-items-center justify-content-center gap-1 mb-3 custom-card-btn-row">

                           @if (is_array($donation))
                           @switch($donation['type'])
                           @case('unit')
                           <div class="donation-amounts text-center">
                               @forelse (@$donation['data'] ?? [] as $key => $data)
                               <label data-toggle="tooltip" data-placement="top" title="{{ $data['name'] }}" style="background-color:{{ is_array($colors) && count($colors) > 0 ? $colors[$key % count($colors)] : '#ccc' }}" class="amount-btn {{ $unitValueRadio == json_encode($data) ? 'active' : null }} {{ $data['value'] == $donationAmt ? 'active' : null }}">
                                   <input wire:model.live="unitValueRadio" type="radio" value="{{ json_encode($data) }}" style="display: none">
                                   <div class="price">
                                       <span>{{ $data['value'] }}</span>
                                       {{-- <small class="large-screen"> &#65020;</small> --}}
                                   </div>
                               </label>
                               @empty
                               @endforelse
                           </div>
                           <div class="custom-amount">
                               <input type="number" wire:model.live="unitValueInput" min="0" placeholder="@lang('Another amount')" class="amount-input" />
                               <span class="currency">رس</span>
                           </div>
                           @break

                           @case('share')
                           <div class="donation-amounts text-center">
                               @forelse (@$donation['data']??[] as $key => $data)
                               <label data-toggle="tooltip" data-placement="top" title="{{ $data['name'] }}" for="ab-{{ $key }}" style="background-color:{{ is_array($colors) && count($colors) > 0 ? $colors[$key % (count($colors) ?? 0)] : '#ccc' }}" class="amount-btn  {{ $shareValue == json_encode($data) ? 'active' : null }}" {{ $shareValue == json_encode($data) ? 'active' : '' }}>
                                   <input wire:model.live="shareValue" type="radio" value="{{ json_encode($data) }}" id="ab-{{ $key }}" style="display: none">
                                   {{ $data['value'] }}
                               </label>
                               @empty
                               @endforelse
                           </div>
                           @break

                           @case('fixed')
                           <div class="donation-amounts text-center">
                               <button class="btn btn-primary amount-btn amount-btn-500" style="background-color:{{ @$colors[0] }}">
                                   {{ @$donation['data'] }} <span>رس</span>
                               </button>
                           </div>
                           @break

                           @case('open')
                           <div class="custom-amount">
                               <input type="number" wire:model="openValue" min="0" placeholder="@lang('Price')" class="amount-input" />
                               <span class="currency">رس</span>
                           </div>
                           @break

                           @default
                           <span>Something went wrong, please try again</span>
                           @endswitch
                           @endif
                       </div>
                   </div>
               </div>

               <div class="form-group mt-3">
                   <input type="text" wire:model="name" class="form-control" placeholder="@lang('Name')">
               </div>

               <div class="input-group" wire:ignore>
                   <input type="number" wire:ignore id="login-mobile" class="form-control iti-phone" wire:model="mobile" placeholder="@lang('Mobile')" style="direction: ltr" />
                   <input id="countryData-login" wire:ignore wire:model="mobileWithCode" value="{{ $mobileWithCode }}" type="hidden" />
                   <span class="text-danger" id="notification-login"></span>
               </div>

               <div class="form-title"> @lang('Payment Method') </div>

               @if($donationAmt <= 0 ) <span class="text-danger"> يجب اختيار التبرع </span>
                   @elseif ( $name == "" )<span class="text-danger">الاسم مطلوب </span>
                   @elseif ( $mobile == "" )<span class="text-danger"> الموبيل مطلوب </span>
                   @else

                   <div class="payment-methods">
                       <div class="img-container">
                            @if ($visaStatus)
                            <button wire:click="SelectPayment('visa')" @if(!$donationAmt) disabled @endif class="p-0 nav-link @if($paymentMethod == "visa") active @endif" type="button" aria-selected="true">
                                <span class="img">
                                    <img src="{{ site_path('img/pay-4.png') }}" alt="" />
                                </span>
                            </button>
                            @endif
                           @if ($applePayStatus && ($iphone || $safari))
                                <button wire:click="SelectPayment('applePay')" @if(!$donationAmt) disabled @endif class="p-0 nav-link @if($paymentMethod == "applePay") active @endif" type="button" aria-selected="true">
                                    <span class="img">
                                        <img src="{{ site_path('img/pay-2.png') }}" alt="" />
                                    </span>
                                </button>
                                @if(!config("app.TEST_MODE"))
                                <input type="hidden" id="SHARequestPhrase" value="{{config("payfort.SHARequestPhrase")}}">
                                @else
                                <input type="hidden" id="SHARequestPhrase" value="96o0CiKlNkSJO7/OJH8ALl$+">
                                @endif
                           @endif
                           @if ($banktransferStatus)
                           <button wire:click="SelectPayment('bankTransfer')" @if(!$donationAmt) disabled @endif class="p-0 nav-link @if($paymentMethod == "bankTransfer") active @endif" type="button" role="tab" aria-selected="true">
                               <span class="img">
                                   <img src="{{ site_path('img/pay-1.png') }}" alt="" />
                               </span>
                           </button>
                        @endif
                       </div>
                   </div>

                   @if($donationAmt > 0)
                   <div class="tab-content my-3" id="pills-tabContent2">

                       <!-- visa-pay-tab -->
                       @if($paymentMethod == "visa"  && $visaStatus)
                       @livewire('site.fast-donation.payments.visa', ['dataDonation' => $dataDonation])

                       <!-- apple-pay-tab -->
                       @elseif($paymentMethod == "applePay" && $applePayStatus)
                  
                       @livewire('site.fast-donation.payments.apple-pay', ['dataDonation' => $dataDonation])

                       <!-- transfer-pay-tab -->
                       @elseif($paymentMethod == "bankTransfer" && $banktransferStatus)
                       @livewire('site.fast-donation.payments.bank-transfer', ['dataDonation' => $dataDonation])

                       @endif
                   </div>
                   @endif
                   @endif

           </div>
       </div>
       <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
       <script>
           function pay() {
               CalculateSignature();
               document.getElementById("paymentForm").submit();

           }

           function CalculateSignature() {
               // const requestShaPhrase = "96o0CiKlNkSJO7/OJH8ALl$+"; // Set your request SHA phrase here.
               const requestShaPhrase = document.getElementById("SHARequestPhrase").value; // "737LIJbY2e1b5sTd0.8iPE+_"; // Set your request SHA phrase here.

               let signatureString = requestShaPhrase;

               // Get form data
               const formData = new FormData(document.getElementById("paymentForm"));

               // Convert formData to object for easy sorting
               const formDataObject = {};
               formData.forEach((value, key) => {
                   formDataObject[key] = value;
               });

               // Sort formDataObject by keys
               const sortedFormDataObject = Object.fromEntries(
                   Object.entries(formDataObject).sort(([keyA], [keyB]) => keyA.localeCompare(keyB))
               );

               // Construct sorted signatureString
               for (const [key, value] of Object.entries(sortedFormDataObject)) {
                   if (key !== 'signature') {
                       signatureString += key + '=' + value;
                   }
               }

               signatureString += requestShaPhrase;

               // Calculate SHA256 signature
               const calculatedSignature = CryptoJS.SHA256(signatureString).toString();

               // Set signature value in the form
               document.getElementById("signature").value = calculatedSignature;
               // Submit the form
               document.getElementById("paymentForm").submit();
           }

       </script>

       <!-- International Tel Input Script -->
       <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

       <script>
           $(document).ready(function() {
               var phoneInputField = document.querySelector("#login-mobile");
               var phoneInput = window.intlTelInput(phoneInputField, {
                   preferredCountries: ['sa', 'ae', 'kw', 'qa', 'bh', 'om']
                   , separateDialCode: true
                   , utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
                   , initialCountry: "auto"
                   , geoIpLookup: function(success, failure) {
                       fetch("https://ipapi.co/json")
                           .then(function(res) {
                               return res.json();
                           })
                           .then(function(data) {
                               success(data.country_code);
                           })
                           .catch(function() {
                               failure();
                           });
                   }


               });

               phoneInputField.addEventListener('keyup', function() {
                var full_number = phoneInput.getNumber();
                $('#countryData-login').val(full_number);
                   console.log("Input changed!", full_number);
               });
             
           });

       </script>
   </div>

   @endif
