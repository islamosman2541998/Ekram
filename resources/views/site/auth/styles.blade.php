<style>
    /* =====================================================================
       Login / Register pages (scoped to .ek-auth)
       ===================================================================== */
    .ek-auth {
        --au-teal: #2C5F5D;
        --au-teal-2: #469e8d;
        --au-orange: #EE5A34;
        --au-text: #1F3B3A;
        --au-muted: #6B7C7A;
        --au-border: #E3ECEB;
        --au-soft: #F3F8F7;
        padding: 40px 16px 64px;
    }

    .ek-auth *,
    .ek-auth *::before,
    .ek-auth *::after { box-sizing: border-box; }

    .ek-auth__wrap {
        display: grid;
        grid-template-columns: minmax(0, 5fr) minmax(0, 6fr);
        max-width: 1040px;
        margin: 0 auto;
        overflow: hidden;
        border: 1px solid var(--au-border);
        border-radius: 26px;
        background: #fff;
        box-shadow: 0 20px 50px rgba(31, 70, 69, .10);
    }

    .ek-auth .ek-auth__wrap { overflow: visible; }

    .ek-auth__side {
        border-start-start-radius: 25px;
        border-end-start-radius: 25px;
    }

    /* ---------- Brand side ---------- */
    .ek-auth__side {
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 14px;
        padding: 44px 40px;
        overflow: hidden;
        background: linear-gradient(150deg, #4fae9c 0%, var(--au-teal-2) 40%, var(--au-teal) 100%);
        color: #fff;
    }

    .ek-auth__side::after {
        content: "";
        position: absolute;
        bottom: -90px;
        inset-inline-end: -90px;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .08);
    }

    .ek-auth__logo {
        display: inline-flex;
        align-self: center;
        margin-bottom: 8px;
        padding: 16px 22px;
        border-radius: 22px;
        background: #fff;
        box-shadow: 0 10px 24px rgba(0, 0, 0, .10);
    }

    .ek-auth__logo img { display: block; height: 96px; width: auto; }

    .ek-auth .ek-auth__side-title {
        margin: 10px 0 0;
        color: #fff !important;
        font-size: clamp(24px, 2.4vw, 32px) !important;
        font-weight: 800;
        line-height: 1.4;
    }

    .ek-auth__side-text { margin: 0; color: rgba(255, 255, 255, .9); font-size: 15.5px; line-height: 1.9; }

    .ek-auth__perks {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin: 10px 0 0;
        padding: 0;
        list-style: none;
    }

    .ek-auth__perks li {
        display: flex;
        align-items: center;
        gap: 12px;
        color: #fff;
        font-size: 14.5px;
        font-weight: 600;
    }

    .ek-auth__perks span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: none;
        width: 36px;
        height: 36px;
        border-radius: 11px;
        background: rgba(255, 255, 255, .16);
        font-size: 15px;
    }

    /* ---------- Form side ---------- */
    .ek-auth__main { position: relative; padding: 44px 44px 36px; min-width: 0; }

    .ek-auth__main > div > .row { margin: 0 !important; }
    .ek-auth__main > div > .row > [class*="col-"] { padding: 0 !important; }

    .ek-auth .auth-card {
        width: 100% !important;
        max-width: none !important;
        margin: 0 !important;
        padding: 0 !important;
        border: 0 !important;
        border-radius: 0 !important;
        background: transparent !important;
        box-shadow: none !important;
        overflow: visible !important; /* login.css clips it, which cut the country dropdown */
    }

    .ek-auth .auth-header { margin: 0 0 6px !important; padding: 0 !important; text-align: start !important; }

    .ek-auth .auth-title {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0 !important;
        color: var(--au-text) !important;
        font-size: clamp(22px, 2.2vw, 28px) !important;
        font-weight: 800;
    }

    .ek-auth .auth-title i {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: var(--au-soft);
        color: var(--au-teal-2) !important;
        font-size: 17px !important;
    }

    .ek-auth .auth-body { padding: 0 !important; }

    .ek-auth .auth-description {
        margin: 8px 0 0 !important;
        color: var(--au-muted) !important;
        font-size: 14.5px !important;
        font-weight: 400 !important;
        line-height: 1.9 !important;
        text-align: start !important;
    }

    .ek-auth .auth-description + .auth-description { display: none; }

    .ek-auth .auth-form { margin-top: 26px !important; padding: 0 !important; }

    .ek-auth .auth-form .form-group {
        display: block !important;
        margin: 0 0 18px !important;
        text-align: start !important;
    }

    .ek-auth .auth-form .form-label {
        display: block !important;
        width: auto !important;
        margin: 0 0 8px !important;
        color: var(--au-text) !important;
        font-size: 14px !important;
        font-weight: 700 !important;
        text-align: start !important;
    }

    .ek-auth .auth-form .form-label .text-danger { font-size: 14px; }

    .ek-auth .auth-form .input-group { display: block !important; width: 100%; }

    .ek-auth .auth-form .form-control {
        display: block;
        width: 100% !important;
        height: 52px !important;
        margin: 0 !important;
        padding: 0 16px !important;
        border: 1.5px solid #D6E1DF !important;
        border-radius: 14px !important;
        background: #fff !important;
        color: var(--au-text) !important;
        font-size: 16px !important;
        box-shadow: none !important;
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .ek-auth .auth-form .form-control:focus {
        border-color: var(--au-teal-2) !important;
        box-shadow: 0 0 0 4px rgba(70, 158, 141, .15) !important;
        outline: none;
    }

    .ek-auth .auth-form .form-control::placeholder { color: #A3B2AF !important; }

    /* intl-tel-input */
    .ek-auth .iti { display: block !important; width: 100% !important; }
    .ek-auth .iti input.form-control { padding-inline-start: 16px !important; }
    .ek-auth .iti--separate-dial-code .iti__selected-flag {
        border-radius: 13px 0 0 13px;
        background: var(--au-soft) !important;
    }
    .ek-auth .iti__country-list { max-width: min(320px, 80vw); border-radius: 12px; }

    .ek-auth .auth-form .text-danger:not(label .text-danger) {
        display: block;
        margin-top: 6px;
        font-size: 13px !important;
        font-weight: 500;
        text-align: start;
    }

    .ek-auth #notification-login:empty,
    .ek-auth #notification-register:empty { display: none; }

    .ek-auth .auth-form .row { margin: 0 !important; }
    .ek-auth .auth-form .row > div { padding: 0 !important; text-align: start !important; }

    .ek-auth .alert {
        margin: 10px 0 0 !important;
        padding: 10px 14px !important;
        border-radius: 12px !important;
        font-size: 13.5px !important;
        text-align: start !important;
    }

    .ek-auth .alert li { list-style: none; }

    .ek-auth .success-message {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0 0 14px;
        padding: 10px 14px;
        border-radius: 12px;
        background: #EAF7F0;
        color: #1F8A5B;
        font-size: 14px;
    }

    /* Primary button */
    .ek-auth .auth-form .btn-primary {
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        width: 100% !important;
        height: 54px !important;
        margin: 6px 0 0 !important;
        padding: 0 20px !important;
        border: 0 !important;
        border-radius: 14px !important;
        background: linear-gradient(135deg, #F07A3F, var(--au-orange)) !important;
        color: #fff !important;
        font-size: 17px !important;
        font-weight: 800;
        box-shadow: 0 10px 22px rgba(238, 90, 52, .25) !important;
        transition: transform .15s ease, box-shadow .2s ease, opacity .2s ease;
    }

    .ek-auth .auth-form .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 14px 28px rgba(238, 90, 52, .3) !important; }
    .ek-auth .auth-form .btn-primary:disabled { opacity: .55; transform: none; box-shadow: none !important; }

    /* "Don't have an account? / Already have one?" */
    .ek-auth .auth-switch {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        gap: 6px;
        margin: 22px 0 0 !important;
        padding-top: 18px;
        border-top: 1px dashed var(--au-border);
        color: var(--au-muted);
        font-size: 14.5px;
        text-align: center;
    }

    .ek-auth .auth-switch a {
        color: var(--au-teal-2) !important;
        font-weight: 800;
        text-decoration: none;
    }

    .ek-auth .auth-switch a:hover { text-decoration: underline; text-underline-offset: 4px; }

    /* the form row is dimmed while a modal is open */
    .ek-auth__main > div > .row[style*="opacity"] { opacity: 1 !important; }

    /* ---------- OTP / "register first" modals ---------- */
    .ek-auth .modal.show {
        display: flex !important;
        align-items: center;
        justify-content: center;
        padding: 16px;
        background: rgba(20, 40, 39, .55);
        backdrop-filter: blur(3px);
    }

    .ek-auth .modal .modal-dialog { width: 100%; max-width: 420px; margin: 0 auto !important; transform: none !important; }

    .ek-auth .modal .modal-content {
        overflow: hidden;
        border: 0;
        border-radius: 20px;
        box-shadow: 0 30px 60px rgba(0, 0, 0, .25);
    }

    .ek-auth #exampleModal .modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 20px 10px;
        border: 0;
    }

    .ek-auth #exampleModal .modal-header .col-md-3 { width: auto; flex: none; }

    .ek-auth #exampleModal .modal-title { margin: 0; color: var(--au-text); font-size: 19px; font-weight: 700; }

    .ek-auth #exampleModal .modal-title::after {
        content: "أدخل الكود المرسل إلى جوالك";
        display: block;
        margin-top: 4px;
        color: var(--au-muted);
        font-size: 13px;
        font-weight: 400;
    }

    .ek-auth .modal .btn-close {
        width: 36px;
        height: 36px;
        margin: 0;
        padding: 0;
        border-radius: 50%;
        background-color: var(--au-soft);
        background-size: 12px;
        opacity: 1;
    }

    .ek-auth #exampleModal .modal-body { padding: 10px 20px 22px; }

    .ek-auth #exampleModal .modal-body .row { display: flex; flex-direction: column; gap: 12px; margin: 0; }

    .ek-auth #exampleModal .modal-body .row > [class*="col-"] { width: 100%; max-width: none; flex: none; padding: 0; }

    .ek-auth #exampleModal .modal-body .form-control {
        height: 58px;
        border: 1px solid #D6E1DF;
        border-radius: 14px;
        background: var(--au-soft);
        color: var(--au-text);
        font-size: 24px;
        font-weight: 700;
        letter-spacing: .5em;
        text-align: center;
        direction: ltr;
    }

    .ek-auth #exampleModal .modal-body .form-control:focus {
        border-color: var(--au-teal-2);
        background: #fff;
        box-shadow: 0 0 0 4px rgba(70, 158, 141, .15);
    }

    .ek-auth #exampleModal .modal-body .btn {
        width: 100%;
        height: 50px;
        margin: 0 !important;
        border: 0;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--au-teal-2), var(--au-teal));
        color: #fff;
        font-size: 16px;
        font-weight: 700;
    }

    .ek-auth #exampleModal .success-message { margin: 0 !important; justify-content: center; background: #FDECEC; font-size: 14px; }

    /* "this number is not registered" modal */
    .ek-auth #register_modal .modal-body { position: relative; padding: 26px 22px 22px; }

    .ek-auth #register_modal .modal-body .row {
        display: flex;
        flex-direction: column;
        align-items: stretch;
        gap: 14px;
        margin: 0;
    }

    .ek-auth #register_modal .modal-body .row > [class*="col-"] { width: 100%; max-width: none; flex: none; padding: 0; margin: 0 !important; }

    .ek-auth #register_modal .modal-body p { margin: 0 !important; color: var(--au-text); font-size: 15.5px; font-weight: 600; }

    .ek-auth #register_modal .modal-body a {
        display: flex !important;
        align-items: center;
        justify-content: center;
        height: 50px;
        padding: 0 !important;
        border-radius: 12px !important;
        background: linear-gradient(135deg, #F07A3F, var(--au-orange)) !important;
        font-size: 16px;
        font-weight: 700;
        text-decoration: none;
    }

    .ek-auth #register_modal .modal-body .col-md-1 { position: absolute; top: 12px; inset-inline-end: 12px; width: auto !important; }

    /* ---------- Country picker (intl-tel-input dropdown) ---------- */
    .ek-auth .iti__country-list {
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

    .ek-auth .iti__country-list::-webkit-scrollbar { width: 8px; }
    .ek-auth .iti__country-list::-webkit-scrollbar-track { margin: 8px 0; border-radius: 8px; background: #EEF4F3; }
    .ek-auth .iti__country-list::-webkit-scrollbar-thumb { border-radius: 8px; background: #469e8d; }
    .ek-auth .iti__country-list::-webkit-scrollbar-thumb:hover { background: #2C5F5D; }

    .ek-auth .iti__country {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 10px;
        border-radius: 10px;
        font-size: 14px;
        direction: rtl;
    }

    .ek-auth .iti__country.iti__highlight { background: #F3F8F7; }
    .ek-auth .iti__country.iti__active { background: #E6F1EF; font-weight: 700; }

    .ek-auth .iti__country .iti__flag-box { order: 0; margin: 0; }
    .ek-auth .iti__country-name { display: inline !important; order: 1; flex: 1; margin: 0; color: #1F3B3A; }
    .ek-auth .iti__dial-code { order: 2; margin: 0; color: #6B7C7A; direction: ltr; }

    .ek-auth .iti__divider { margin: 6px 4px; padding: 0; border-bottom: 1px dashed #E3ECEB; }

    /* ---------- Responsive ---------- */
    @media (max-width: 991.98px) {
        .ek-auth__wrap { grid-template-columns: minmax(0, 1fr); max-width: 560px; }
        .ek-auth__side { border-radius: 25px 25px 0 0; }

        .ek-auth__side { gap: 10px; padding: 28px 24px; }
        .ek-auth__perks { display: none; }
        .ek-auth .ek-auth__side-title { margin-top: 4px; }

        .ek-auth__main { padding: 30px 24px 28px; }
    }

    @media (max-width: 575.98px) {
        .ek-auth { padding: 18px 12px 40px; }
        .ek-auth__wrap { border-radius: 20px; }
        .ek-auth__side { padding: 22px 20px; }
        .ek-auth__logo img { height: 72px; }
        .ek-auth__side-text { font-size: 14.5px; }
        .ek-auth__main { padding: 24px 18px 22px; }
        .ek-auth .auth-form { margin-top: 20px !important; }
    }
</style>
