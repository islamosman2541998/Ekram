<style>
    /* =====================================================================
       Checkout page (scoped to .ek-checkout so other pages using the same
       auth / payment components are not affected)
       ===================================================================== */
    .ek-checkout {
        --co-teal: #2C5F5D;
        --co-teal-2: #469e8d;
        --co-orange: #EE5A34;
        --co-amber: #FAA440;
        --co-text: #1F3B3A;
        --co-muted: #6B7C7A;
        --co-border: #E3ECEB;
        --co-soft: #F3F8F7;
        --co-radius: 18px;
        max-width: 1200px !important;
        margin: 0 auto 64px;
        padding: 0 16px;
        color: var(--co-text);
    }

    .ek-checkout *,
    .ek-checkout *::before,
    .ek-checkout *::after { box-sizing: border-box; }

    /* ---------- Layout ---------- */
    .ek-co-grid {
        display: grid;
        grid-template-columns: minmax(0, 420px) minmax(0, 1fr);
        align-items: start;
        gap: 24px;
    }

    .ek-co-summary { position: sticky; top: calc(var(--ek-nav-h, 81px) + 20px); }
    .ek-co-main { display: flex; flex-direction: column; gap: 20px; min-width: 0; }

    /* ---------- Cards ---------- */
    .ek-checkout .ek-co-card {
        position: relative;
        padding: 22px;
        border: 1px solid var(--co-border);
        border-radius: var(--co-radius);
        background: #fff;
        box-shadow: 0 10px 30px rgba(31, 70, 69, .06);
    }

    .ek-co-card__head {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 18px;
    }

    .ek-co-card__icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: none;
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: var(--co-soft);
        color: var(--co-teal);
        font-size: 16px;
    }

    .ek-checkout .ek-co-card__title {
        margin: 0;
        font-size: 19px !important;
        font-weight: 700;
        color: var(--co-text);
    }

    .ek-co-badge {
        margin-inline-start: auto;
        min-width: 28px;
        height: 28px;
        padding: 0 8px;
        border-radius: 999px;
        background: var(--co-teal);
        color: #fff;
        font-size: 13px;
        font-weight: 700;
        line-height: 28px;
        text-align: center;
    }

    /* ---------- Summary items ---------- */
    .ek-checkout .ek-co-items {
        list-style: none;
        margin: 0;
        padding: 0;
        max-height: 420px;
        overflow-y: auto;
        overscroll-behavior: contain;
    }

    .ek-co-item {
        display: grid;
        grid-template-columns: 56px minmax(0, 1fr) auto;
        align-items: center;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px dashed var(--co-border);
    }

    .ek-co-item:first-child { padding-top: 0; }
    .ek-co-item:last-child { border-bottom: 0; }

    .ek-co-item__img {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        object-fit: cover;
        background: var(--co-soft);
    }

    .ek-co-item__info { display: flex; flex-direction: column; gap: 4px; min-width: 0; }

    .ek-co-item__title {
        color: var(--co-text);
        font-size: 14.5px;
        font-weight: 600;
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .ek-co-item__meta {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 6px;
        color: var(--co-muted);
        font-size: 13px;
    }

    .ek-co-item__meta b { color: var(--co-amber); font-weight: 700; }
    .ek-co-dot { width: 4px; height: 4px; border-radius: 50%; background: #C9D4D2; }
    .ek-co-item__gift { color: var(--co-teal-2); }

    .ek-co-item__price {
        color: var(--co-teal);
        font-size: 17px;
        font-weight: 700;
        white-space: nowrap;
    }

    .ek-co-item__price small { color: var(--co-muted); font-size: 12px; font-weight: 500; }
    .ek-co-empty { padding: 12px 0; color: var(--co-muted); text-align: center; }

    .ek-co-total {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-top: 16px;
        padding: 16px 18px;
        border-radius: 14px;
        background: linear-gradient(135deg, #3a7a78 0%, var(--co-teal) 100%);
        color: #fff;
    }

    .ek-co-total__label { font-size: 15px; opacity: .9; }
    .ek-co-total__value { font-size: 26px; font-weight: 800; line-height: 1; white-space: nowrap; }
    .ek-co-total__value small { font-size: 14px; font-weight: 500; opacity: .85; }

    .ek-co-secure {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin: 0;
        color: var(--co-muted);
        font-size: 13px;
    }

    .ek-co-secure i { color: var(--co-teal-2); }

    /* ---------- Neutralise the old boxed wrappers inside our cards ---------- */
    .ek-checkout .ek-co-card .cart-main,
    .ek-checkout .ek-co-card .cart-form,
    .ek-checkout .ek-co-card .TotalCard,
    .ek-checkout .ek-co-card .auth-form {
        width: 100% !important;
        max-width: none !important;
        margin: 0 !important;
        padding: 0 !important;
        border: 0 !important;
        border-radius: 0 !important;
        background: transparent !important;
        box-shadow: none !important;
    }

    .ek-checkout .ek-co-card .cart-form { display: block !important; }

    /* ---------- Donor tabs (old / new) ---------- */
    .ek-checkout .cart-form-tabs {
        margin: 0 0 18px !important;
        padding: 0 !important;
        border: 0 !important;
        background: none !important;
    }

    .ek-checkout .cart-form-tabs .Btns {
        display: flex !important;
        gap: 4px;
        width: 100%;
        padding: 4px;
        border-radius: 14px;
        background: var(--co-soft);
    }

    .ek-checkout .cart-form-tabs .tab-btn {
        flex: 1;
        height: 44px;
        margin: 0 !important;
        padding: 0 12px !important;
        border: 0 !important;
        border-radius: 11px !important;
        background: transparent !important;
        color: var(--co-muted) !important;
        font-size: 15px !important;
        font-weight: 600;
        box-shadow: none !important;
        transition: background-color .2s ease, color .2s ease, box-shadow .2s ease;
    }

    .ek-checkout .cart-form-tabs .tab-btn:hover { color: var(--co-teal) !important; }

    .ek-checkout .cart-form-tabs .tab-btn.active {
        background: #fff !important;
        color: var(--co-teal) !important;
        box-shadow: 0 4px 12px rgba(31, 70, 69, .12) !important;
    }

    /* ---------- Form fields (auth + bank transfer) ---------- */
    .ek-checkout .auth-form .form-group,
    .ek-checkout .bank-form {
        display: block !important;
        margin: 0 0 14px !important;
        text-align: start !important;
    }

    .ek-checkout .auth-form .form-label,
    .ek-checkout .auth-form label,
    .ek-checkout .bank-form > label:not(.pay-btn) {
        display: block !important;
        width: auto !important;
        margin: 0 0 6px !important;
        color: var(--co-text) !important;
        font-size: 14px !important;
        font-weight: 600;
        text-align: start !important;
    }

    .ek-checkout .auth-form .form-control,
    .ek-checkout .auth-form input[type="text"],
    .ek-checkout .auth-form input[type="email"],
    .ek-checkout .auth-form input[type="number"],
    .ek-checkout .bank-input {
        display: block;
        width: 100% !important;
        max-width: none !important;
        height: 48px !important;
        margin: 0 !important;
        padding: 0 14px;
        border: 1px solid #D6E1DF !important;
        border-radius: 12px !important;
        background: #fff !important;
        color: var(--co-text) !important;
        font-size: 15px !important;
        box-shadow: none !important;
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .ek-checkout .auth-form .form-control:focus,
    .ek-checkout .bank-input:focus {
        border-color: var(--co-teal-2) !important;
        box-shadow: 0 0 0 4px rgba(70, 158, 141, .15) !important;
        outline: none;
    }

    .ek-checkout .auth-form .form-control::placeholder,
    .ek-checkout .bank-input::placeholder {
        color: #9AABA8 !important;
        opacity: 1;
    }

    .ek-checkout .auth-form .input-group { display: block !important; width: 100%; }

    /* intl-tel-input: full width, dial code area matching the field */
    .ek-checkout .iti { display: block !important; width: 100% !important; }
    .ek-checkout .iti-phone,
    .ek-checkout .iti input { width: 100% !important; }
    .ek-checkout .iti__flag-container { padding: 1px; }
    .ek-checkout .iti--separate-dial-code .iti__selected-flag {
        border-radius: 11px 0 0 11px;
        background: var(--co-soft) !important;
    }
    .ek-checkout .iti__country-list { max-width: min(320px, 80vw); border-radius: 12px; }

    .ek-checkout .auth-form .text-danger,
    .ek-checkout .bank-form .text-danger {
        display: block;
        margin-top: 6px;
        font-size: 13px !important;
        font-weight: 500;
    }

    .ek-checkout .auth-form .text-danger:empty { display: none; }

    /* required asterisk stays next to its label */
    .ek-checkout .auth-form label .text-danger {
        display: inline !important;
        margin: 0 2px 0 0;
        font-size: 14px !important;
    }

    .ek-checkout .auth-form .row { margin: 0 !important; }
    .ek-checkout .auth-form .alert { margin: 8px 0 0 !important; padding: 8px 12px; border-radius: 10px; font-size: 13px; }
    .ek-checkout .cart-form > .alert { border-radius: 12px; font-size: 14px; }

    /* Primary action buttons */
    .ek-checkout .auth-form .btn-primary {
        width: 100% !important;
        height: 50px;
        margin-top: 6px;
        border: 0 !important;
        border-radius: 12px !important;
        background: linear-gradient(135deg, var(--co-teal-2), var(--co-teal)) !important;
        color: #fff !important;
        font-size: 16px !important;
        font-weight: 700;
        box-shadow: 0 8px 18px rgba(44, 95, 93, .22) !important;
        transition: transform .15s ease, box-shadow .2s ease, opacity .2s ease;
    }

    .ek-checkout .auth-form .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 12px 24px rgba(44, 95, 93, .28) !important; }
    .ek-checkout .auth-form .btn-primary:disabled { opacity: .55; transform: none; box-shadow: none !important; }

    /* ---------- OTP modal ---------- */
    .ek-checkout #exampleModal.show {
        display: flex !important;
        align-items: center;
        justify-content: center;
        padding: 16px;
        background: rgba(20, 40, 39, .55);
        backdrop-filter: blur(3px);
    }

    .ek-checkout #exampleModal .modal-dialog {
        width: 100%;
        max-width: 420px;
        margin: 0 auto !important;
        transform: none !important;
    }

    .ek-checkout #exampleModal .modal-content {
        overflow: hidden;
        border: 0;
        border-radius: 20px;
        box-shadow: 0 30px 60px rgba(0, 0, 0, .25);
    }

    .ek-checkout #exampleModal .modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 20px 10px;
        border: 0;
    }

    .ek-checkout #exampleModal .modal-header .col-md-3 { width: auto; flex: none; }

    .ek-checkout #exampleModal .modal-title {
        margin: 0;
        font-size: 19px;
        font-weight: 700;
        color: var(--co-text);
    }

    .ek-checkout #exampleModal .modal-title::after {
        content: "أدخل الكود المرسل إلى جوالك";
        display: block;
        margin-top: 4px;
        color: var(--co-muted);
        font-size: 13px;
        font-weight: 400;
    }

    .ek-checkout #exampleModal .btn-close {
        width: 36px;
        height: 36px;
        margin: 0;
        padding: 0;
        border-radius: 50%;
        background-color: var(--co-soft);
        background-size: 12px;
        opacity: 1;
    }

    .ek-checkout #exampleModal .modal-body { padding: 10px 20px 22px; }

    .ek-checkout #exampleModal .modal-body .row {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin: 0;
    }

    .ek-checkout #exampleModal .modal-body .row > [class*="col-"] {
        width: 100%;
        max-width: none;
        flex: none;
        padding: 0;
    }

    .ek-checkout #exampleModal .modal-body .form-control {
        height: 58px;
        border: 1px solid #D6E1DF;
        border-radius: 14px;
        background: var(--co-soft);
        color: var(--co-text);
        font-size: 24px;
        font-weight: 700;
        letter-spacing: .5em;
        text-align: center;
        direction: ltr;
    }

    .ek-checkout #exampleModal .modal-body .form-control:focus {
        border-color: var(--co-teal-2);
        background: #fff;
        box-shadow: 0 0 0 4px rgba(70, 158, 141, .15);
    }

    .ek-checkout #exampleModal .modal-body .btn-primary {
        width: 100%;
        height: 50px;
        border: 0;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--co-teal-2), var(--co-teal));
        font-size: 16px;
        font-weight: 700;
    }

    .ek-checkout #exampleModal .success-message { margin: 0 !important; font-size: 14px; text-align: center; }

    /* ---------- Payment methods ---------- */
    .ek-checkout .TotalCard > .text-danger {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 14px 16px;
        border: 1px solid #FBD9C9;
        border-radius: 12px;
        background: #FFF6F1;
        color: #B5471F !important;
        font-size: 14px;
        font-weight: 600;
    }

    .ek-checkout .TotalCard > .text-danger::before {
        content: "\f023";
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
    }

    .ek-checkout .payment-methods {
        display: block !important;
        width: 100% !important;
        margin: 0 0 18px !important;
        padding: 0 !important;
        border: 0 !important;
        background: none !important;
    }

    .ek-checkout .payment-methods .label { display: none !important; }

    .ek-checkout .payment-methods .img-container {
        display: grid !important;
        grid-template-columns: repeat(auto-fit, minmax(110px, 1fr));
        gap: 10px;
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .ek-checkout .payment-methods .payment-items {
        position: relative;
        display: flex !important;
        align-items: center;
        justify-content: center;
        width: 100% !important;
        height: 64px !important;
        margin: 0 !important;
        padding: 8px !important;
        border: 1.5px solid var(--co-border) !important;
        border-radius: 14px !important;
        background: #fff !important;
        box-shadow: none !important;
        cursor: pointer;
        transition: border-color .2s ease, box-shadow .2s ease, transform .15s ease;
    }

    .ek-checkout .payment-methods .payment-items:hover { border-color: var(--co-teal-2) !important; transform: translateY(-1px); }

    .ek-checkout .payment-methods .payment-items.active {
        border-color: var(--co-teal) !important;
        background: var(--co-soft) !important;
        box-shadow: 0 0 0 3px rgba(44, 95, 93, .12) !important;
    }

    .ek-checkout .payment-methods .payment-items.active::after {
        content: "\f00c";
        position: absolute;
        top: -8px;
        inset-inline-end: -8px;
        width: 22px;
        height: 22px;
        border: 2px solid #fff;
        border-radius: 50%;
        background: var(--co-teal);
        color: #fff;
        font-family: "Font Awesome 6 Free";
        font-size: 10px;
        font-weight: 900;
        line-height: 18px;
        text-align: center;
    }

    .ek-checkout .payment-methods .payment-items img {
        width: auto !important;
        max-width: 100% !important;
        height: auto !important;
        max-height: 34px !important;
        margin: 0 !important;
        border: 0 !important;
        object-fit: contain;
    }

    /* Pay / cancel row (visa + bank) */
    .ek-checkout .cart-form-actions {
        display: flex !important;
        align-items: center;
        gap: 10px;
        width: 100%;
        margin: 4px 0 0 !important;
        padding: 0 !important;
    }

    .ek-checkout .cart-form-actions .proceed-text { display: none !important; }

    .ek-checkout .payment-content,
    .ek-checkout .cart-form-actions {
        border: 0 !important;
        background: none !important;
        box-shadow: none !important;
    }

    .ek-checkout .payment-content { margin: 0 !important; padding: 0 !important; }

    /* Showing/hiding a method is done by the Livewire wrappers ($paymentMethod).
       public/site/js/cart.js still toggles .payment-content by image *index*, which is wrong when
       Apple Pay is listed (3 images, 2 contents) and hid the bank form on iPhone - keep them visible. */
    .ek-checkout #payment-methods .payment-content { display: block !important; }

    /* keep the hidden receipt file input hidden */
    .ek-checkout input[type="file"].d-none { display: none !important; }

    .ek-checkout .pay-btn:not(.attach-btn):not(input) {
        flex: 1;
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: auto !important;
        height: 52px !important;
        margin: 0 !important;
        padding: 0 20px !important;
        border: 0 !important;
        border-radius: 12px !important;
        background: linear-gradient(135deg, #F07A3F, var(--co-orange)) !important;
        color: #fff !important;
        font-size: 17px !important;
        font-weight: 700;
        box-shadow: 0 10px 22px rgba(238, 90, 52, .25) !important;
        transition: transform .15s ease, box-shadow .2s ease, opacity .2s ease;
    }

    .ek-checkout .pay-btn:not(.attach-btn):not(input):hover { transform: translateY(-1px); }
    .ek-checkout .pay-btn:not(.attach-btn):not(input):disabled { opacity: .5; transform: none; box-shadow: none !important; cursor: not-allowed; }

    .ek-checkout .cancel-btn {
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        flex: none;
        width: 52px !important;
        height: 52px !important;
        margin: 0 !important;
        padding: 0 !important;
        border: 1px solid var(--co-border) !important;
        border-radius: 12px !important;
        background: #fff !important;
        color: var(--co-muted) !important;
        font-size: 18px;
        text-decoration: none;
    }

    .ek-checkout .cancel-btn:hover { border-color: #F3B3A2 !important; color: var(--co-orange) !important; }
    .ek-checkout .cancel-btn i { font-size: 18px !important; line-height: 1; }

    /* Bank transfer */
    .ek-checkout .bank-fields,
    .ek-checkout .bank.payment-content { margin: 0 !important; padding: 0 !important; }
    .ek-checkout .bank-text { display: none !important; }

    .ek-checkout select.bank-input { appearance: auto; }

    .ek-checkout .attach-btn {
        display: flex !important;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100% !important;
        min-height: 52px;
        margin: 4px 0 0 !important;
        padding: 10px 16px !important;
        border: 1.5px dashed var(--co-teal-2) !important;
        border-radius: 12px !important;
        background: var(--co-soft) !important;
        color: var(--co-teal) !important;
        font-size: 15px !important;
        font-weight: 600;
        cursor: pointer;
    }

    .ek-checkout .attach-btn .attach-state[wire\:loading\.flex] { display: none; }
    .ek-checkout .attach-btn .attach-state { display: flex; flex-wrap: wrap; align-items: center; justify-content: center; gap: 4px 8px; }
    .ek-checkout .attach-btn .attach-main { margin: 0 !important; color: var(--co-teal) !important; font-size: inherit !important; font-weight: 700; }
    .ek-checkout .attach-btn .attach-sub { margin: 0 !important; color: var(--co-muted) !important; font-size: 12px !important; font-weight: 600; direction: ltr; unicode-bidi: plaintext; }
    .ek-checkout .attach-btn.is-done { border-style: solid !important; border-color: #2E9E6B !important; background: #EEF8F2 !important; }
    .ek-checkout .attach-btn.is-done .attach-main,
    .ek-checkout .attach-btn.is-done .fa-check-circle { color: #1F7A50 !important; }
    .ek-checkout .attach-btn.is-done .fa-check-circle { font-size: 18px; }

    /* Apple Pay */
    .ek-checkout #payment-methods .btn-success {
        height: 52px;
        border: 0;
        border-radius: 12px;
        background: #000;
        font-size: 17px;
        font-weight: 600;
    }

    .ek-checkout #payment-methods .container { padding: 0 !important; }

    /* ---------- Country picker (intl-tel-input dropdown) ---------- */
    .ek-checkout .iti__country-list {
        /* open over the input (RTL would otherwise push it out of the card / screen) */
        left: 0 !important;
        right: auto !important;
        z-index: 50;
        width: 300px;
        max-width: min(300px, 82vw);
        max-height: 260px;
        margin-top: 6px;
        padding: 6px;
        overflow-y: auto;
        overscroll-behavior: contain;
        border: 1px solid #E3ECEB;
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 18px 40px rgba(31, 70, 69, .18);
        white-space: normal;
        scrollbar-width: thin;
        scrollbar-color: #469e8d #EEF4F3;
    }

    .ek-checkout .iti__country-list::-webkit-scrollbar { width: 8px; }
    .ek-checkout .iti__country-list::-webkit-scrollbar-track { margin: 8px 0; border-radius: 8px; background: #EEF4F3; }
    .ek-checkout .iti__country-list::-webkit-scrollbar-thumb { border-radius: 8px; background: #469e8d; }
    .ek-checkout .iti__country-list::-webkit-scrollbar-thumb:hover { background: #2C5F5D; }

    .ek-checkout .iti__country {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 10px;
        border-radius: 10px;
        font-size: 14px;
        direction: rtl;
    }

    .ek-checkout .iti__country.iti__highlight { background: #F3F8F7; }
    .ek-checkout .iti__country.iti__active { background: #E6F1EF; font-weight: 700; }

    .ek-checkout .iti__country .iti__flag-box { order: 0; margin: 0; }
    .ek-checkout .iti__country-name { display: inline !important; order: 1; flex: 1; margin: 0; color: #1F3B3A; }
    .ek-checkout .iti__dial-code { order: 2; margin: 0; color: #6B7C7A; direction: ltr; }

    .ek-checkout .iti__divider { margin: 6px 4px; padding: 0; border-bottom: 1px dashed #E3ECEB; }

    /* ---------- Responsive ---------- */
    @media (max-width: 991.98px) {
        .ek-co-grid { grid-template-columns: minmax(0, 1fr); gap: 18px; }
        .ek-co-summary { position: static; }
        .ek-checkout .ek-co-items { max-height: none; }
    }

    @media (max-width: 575.98px) {
        .ek-checkout { padding: 0 12px; margin-bottom: 40px; }
        .ek-checkout .ek-co-card { padding: 16px; border-radius: 16px; }
        .ek-co-card__head { margin-bottom: 14px; }
        .ek-checkout .ek-co-card__title { font-size: 17px !important; }
        .ek-co-item { grid-template-columns: 48px minmax(0, 1fr) auto; gap: 10px; }
        .ek-co-item__img { width: 48px; height: 48px; }
        .ek-co-total__value { font-size: 22px; }
        .ek-checkout .cart-form-tabs .tab-btn { height: 42px; font-size: 14px !important; }
        .ek-checkout .payment-methods .img-container { grid-template-columns: repeat(auto-fit, minmax(90px, 1fr)); }
    }
    /* style.css sets main { overflow-x: hidden }, which turns <main> into a scroll container and
       breaks position: sticky (the element got pushed down). clip hides the same overflow without that. */
    main:has(.ek-checkout) { overflow-x: clip !important; }
</style>
