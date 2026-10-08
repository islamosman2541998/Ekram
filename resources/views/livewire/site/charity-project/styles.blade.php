<style>
    /* =====================================================================
       Project page (scoped to .ek-project)
       ===================================================================== */
    .ek-project {
        --pj-teal: #2C5F5D;
        --pj-teal-2: #469e8d;
        --pj-orange: #EE5A34;
        --pj-amber: #FAA440;
        --pj-text: #1F3B3A;
        --pj-muted: #6B7C7A;
        --pj-border: #E3ECEB;
        --pj-soft: #F3F8F7;
        color: var(--pj-text);
        margin-bottom: 64px;
    }

    .ek-project *,
    .ek-project *::before,
    .ek-project *::after { box-sizing: border-box; }

    /* ---------- Layout ---------- */
    .ek-pj-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 420px);
        grid-template-areas:
            "media donate"
            "about donate";
        align-items: start;
        gap: 24px;
    }

    .ek-pj-media { grid-area: media; position: relative; min-width: 0; }
    .ek-pj-donate { grid-area: donate; position: sticky; top: calc(var(--ek-nav-h, 81px) + 20px); min-width: 0; }
    .ek-pj-about { grid-area: about; display: flex; flex-direction: column; gap: 20px; min-width: 0; }

    /* ---------- Cards ---------- */
    .ek-project .ek-pj-card {
        width: 100% !important;
        max-width: none !important;
        margin: 0 !important;
        padding: 22px !important;
        border: 1px solid var(--pj-border) !important;
        border-radius: 20px !important;
        background: #fff !important;
        box-shadow: 0 10px 30px rgba(31, 70, 69, .07) !important;
    }

    .ek-project .ek-pj-card__title {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0 0 14px;
        color: var(--pj-text);
        font-size: 20px !important;
        font-weight: 700;
    }

    .ek-project .ek-pj-card__title i { color: var(--pj-teal-2); font-size: 18px; }

    /* ---------- Media ---------- */
    .ek-project .project-image {
        position: relative;
        width: 100% !important;
        height: auto !important;
        margin: 0 !important;
        overflow: hidden;
        border-radius: 22px !important;
        background: var(--pj-soft);
        box-shadow: 0 14px 34px rgba(31, 70, 69, .12);
    }

    .ek-project .project-image img {
        display: block;
        width: 100% !important;
        height: auto !important;
        max-height: 560px;
        margin: 0 !important;
        border-radius: 0 !important;
        object-fit: cover;
    }

    .ek-project .carousel-indicators { margin-bottom: 12px; gap: 6px; }

    .ek-project .carousel-indicators [data-bs-target] {
        width: 8px;
        height: 8px;
        margin: 0;
        border: 0;
        border-radius: 999px;
        opacity: .6;
        transition: width .3s ease, opacity .3s ease;
    }

    .ek-project .carousel-indicators .active { width: 24px; opacity: 1; }

    .ek-pj-closed {
        position: absolute;
        top: 16px;
        inset-inline-start: 16px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 999px;
        background: rgba(255, 255, 255, .95);
        color: #1F8A5B;
        font-size: 14px;
        font-weight: 700;
        box-shadow: 0 6px 16px rgba(0, 0, 0, .12);
    }

    /* ---------- Donation card head ---------- */
    .ek-pj-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 18px;
    }

    .ek-pj-head__text { min-width: 0; }

    .ek-pj-chip {
        display: inline-block;
        margin-bottom: 8px;
        padding: 4px 12px;
        border-radius: 999px;
        background: var(--pj-soft);
        color: var(--pj-teal-2);
        font-size: 13px;
        font-weight: 600;
    }

    .ek-project .ek-pj-title {
        margin: 0;
        color: var(--pj-text);
        font-size: clamp(20px, 2vw, 24px) !important;
        font-weight: 800;
        line-height: 1.5;
    }

    .ek-pj-share {
        flex: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        border: 1px solid var(--pj-border);
        border-radius: 50%;
        background: #fff;
        color: var(--pj-teal);
        font-size: 16px;
        cursor: pointer;
        transition: background-color .2s ease, color .2s ease;
    }

    .ek-pj-share:hover { background: var(--pj-teal); color: #fff; }

    /* ---------- Progress ---------- */
    .ek-pj-progress {
        margin-bottom: 20px;
        padding: 14px 16px;
        border-radius: 14px;
        background: var(--pj-soft);
    }

    .ek-pj-progress__row {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 10px;
    }

    .ek-pj-progress__label { display: block; color: var(--pj-muted); font-size: 12.5px; }

    .ek-pj-progress__value {
        display: block;
        color: var(--pj-teal);
        font-size: 16px;
        font-weight: 800;
        white-space: nowrap;
    }

    .ek-pj-progress__value small { color: var(--pj-muted); font-size: 11px; font-weight: 500; }

    .ek-pj-progress__pct {
        padding: 3px 10px;
        border-radius: 999px;
        background: #fff;
        color: var(--pj-orange);
        font-size: 14px;
        font-weight: 800;
    }

    .ek-pj-bar {
        height: 8px;
        overflow: hidden;
        border-radius: 999px;
        background: #DCE7E5;
    }

    .ek-pj-bar span {
        display: block;
        height: 100%;
        min-width: 8px;
        border-radius: inherit;
        background: linear-gradient(90deg, var(--pj-amber), var(--pj-orange));
    }

    /* ---------- Amounts ---------- */
    .ek-pj-section-label {
        margin: 0 0 10px;
        color: var(--pj-text);
        font-size: 15px;
        font-weight: 700;
    }

    .ek-project .donation-amounts {
        display: grid !important;
        grid-template-columns: repeat(auto-fill, minmax(88px, 1fr));
        gap: 10px;
        width: 100% !important;
        margin: 0 0 12px !important;
        padding: 0 !important;
    }

    .ek-project .donation-amounts[data-count="1"] { grid-template-columns: minmax(0, 1fr); }
    .ek-project .donation-amounts[data-count="2"] { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    .ek-project .donation-amounts[data-count="3"] { grid-template-columns: repeat(3, minmax(0, 1fr)); }
    .ek-project .donation-amounts[data-count="4"],
    .ek-project .donation-amounts[data-count="many"] { grid-template-columns: repeat(4, minmax(0, 1fr)); }

    .ek-project .donation-amounts .amount-btn {
        position: relative;
        display: flex !important;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 2px;
        width: 100% !important;
        min-height: 64px;
        margin: 0 !important;
        padding: 8px 6px !important;
        border: 1.5px solid var(--pj-border) !important;
        border-radius: 14px !important;
        background: #fff !important;
        color: var(--pj-text) !important;
        box-shadow: none !important;
        opacity: 1 !important;
        transform: none !important;
        cursor: pointer;
        transition: border-color .2s ease, box-shadow .2s ease, background-color .2s ease !important;
    }

    /* the admin colour of each amount becomes a small accent strip */
    .ek-project .donation-amounts .amount-btn::before {
        content: "";
        position: absolute;
        top: 8px;
        inset-inline-start: 8px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--amt, var(--pj-teal-2));
    }

    .ek-project .donation-amounts .amount-btn:hover { border-color: var(--pj-teal-2) !important; }

    .ek-project .donation-amounts .amount-btn.active {
        border-color: var(--pj-teal) !important;
        background: var(--pj-teal) !important;
        color: #fff !important;
        box-shadow: 0 8px 18px rgba(44, 95, 93, .25) !important;
    }

    .ek-project .donation-amounts .amount-btn.active::before { background: #fff; }

    .ek-project .amount-btn__value,
    .ek-project .donation-amounts .amount-btn .price {
        font-size: 18px;
        font-weight: 800;
        line-height: 1.2;
    }

    .ek-project .amount-btn__cur {
        max-width: 100%;
        overflow: hidden;
        font-size: 11.5px;
        opacity: .75;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .ek-project .amount-btn.input-disable { opacity: .45 !important; cursor: not-allowed; }

    /* Other amount */
    .ek-project .custom-amount {
        position: relative;
        display: block !important;
        width: 100% !important;
        margin: 0 0 14px !important;
    }

    .ek-project .custom-amount .amount-input {
        width: 100% !important;
        height: 50px !important;
        margin: 0 !important;
        padding: 0 16px !important;
        padding-inline-end: 52px !important;
        border: 1.5px solid #D6E1DF !important;
        border-radius: 14px !important;
        background: #fff !important;
        color: var(--pj-text) !important;
        font-size: 16px !important;
        box-shadow: none !important;
    }

    .ek-project .custom-amount .amount-input:focus {
        border-color: var(--pj-teal-2) !important;
        box-shadow: 0 0 0 4px rgba(70, 158, 141, .15) !important;
        outline: none;
    }

    .ek-project .custom-amount .amount-input::placeholder { color: #9AABA8 !important; }

    .ek-project .custom-amount .currency {
        position: absolute !important;
        top: 50%;
        inset-inline-end: 16px;
        margin: 0 !important;
        transform: translateY(-50%);
        color: var(--pj-muted) !important;
        font-size: 13px !important;
        font-weight: 600;
        pointer-events: none;
    }

    /* ---------- Gift toggle ---------- */
    .ek-project .gift-option {
        display: flex !important;
        align-items: center;
        gap: 10px;
        width: 100% !important;
        margin: 0 0 14px !important;
        padding: 12px 14px !important;
        border: 1px dashed #BFD6D2 !important;
        border-radius: 14px !important;
        background: var(--pj-soft) !important;
    }

    .ek-project .gift-option .fa-gift { order: -1; color: var(--pj-orange) !important; font-size: 18px; }
    .ek-project .gift-option .gift-text { flex: 1; color: var(--pj-text) !important; font-size: 14px; font-weight: 600; }

    .ek-project .gift-option .gift-checkbox {
        flex: none;
        width: 20px;
        height: 20px;
        margin: 0;
        accent-color: var(--pj-teal);
        cursor: pointer;
    }

    .ek-project .gift-container .form-control,
    .ek-project .gift-container .form-select {
        min-height: 46px;
        border: 1px solid #D6E1DF;
        border-radius: 12px;
        box-shadow: none;
    }

    .ek-project .gift-container .gift-btn {
        border: 0;
        border-radius: 12px;
        background: var(--pj-teal);
    }

    /* ---------- Total + actions ---------- */
    .ek-pj-total {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin: 4px 0 12px;
        padding: 12px 16px;
        border-radius: 14px;
        background: var(--pj-soft);
    }

    .ek-pj-total__label { color: var(--pj-muted); font-size: 14px; font-weight: 600; }

    .ek-pj-total__value {
        color: var(--pj-teal);
        font-size: 22px;
        font-weight: 800;
        line-height: 1;
        white-space: nowrap;
    }

    .ek-pj-total__value small { color: var(--pj-muted); font-size: 12px; font-weight: 500; }

    .ek-project .checkout-container {
        display: flex !important;
        align-items: stretch;
        gap: 10px;
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .ek-project .checkout-container .checkout-btn {
        flex: 1;
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        gap: 8px;
        height: 54px !important;
        margin: 0 !important;
        padding: 0 20px !important;
        border: 0 !important;
        border-radius: 14px !important;
        background: linear-gradient(135deg, #F07A3F, var(--pj-orange)) !important;
        color: #fff !important;
        font-size: 17px !important;
        font-weight: 800;
        box-shadow: 0 10px 22px rgba(238, 90, 52, .25) !important;
        transition: transform .15s ease, box-shadow .2s ease, opacity .2s ease;
    }

    .ek-project .checkout-container .cart-icon-btn {
        flex: none;
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        width: 54px !important;
        height: 54px !important;
        margin: 0 !important;
        padding: 0 !important;
        border: 1.5px solid var(--pj-teal) !important;
        border-radius: 14px !important;
        background: #fff !important;
        color: var(--pj-teal) !important;
        font-size: 19px;
        box-shadow: none !important;
        transition: background-color .2s ease, color .2s ease;
    }

    .ek-project .checkout-container .cart-icon-btn .cart-shop { color: inherit !important; }
    .ek-project .checkout-container .cart-icon-btn i { font-size: 19px !important; }
    .ek-project .checkout-container .checkout-btn i { font-size: 18px !important; }

    .ek-project .checkout-container .checkout-btn:hover { transform: translateY(-1px); }
    .ek-project .checkout-container .cart-icon-btn:hover { background: var(--pj-teal) !important; color: #fff !important; }

    .ek-project .checkout-container button:disabled { opacity: .6; transform: none; }

    .ek-project .donation-card > div > .alert { margin: 0 0 12px; border-radius: 12px; font-size: 14px; }
    .ek-project .hadith-text { display: none; }

    /* ---------- About ---------- */
    .ek-project .project-details {
        margin: 0 !important;
        padding: 0 !important;
        color: #3B5150;
        font-size: 16px;
        line-height: 2;
        overflow-wrap: anywhere;
    }

    .ek-project .project-details p { margin: 0 0 8px; }
    .ek-project .project-details img { max-width: 100%; height: auto; border-radius: 12px; }

    /* ---------- Stats ---------- */
    .ek-project .statistics-section {
        display: grid !important;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 12px;
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        border: 0 !important;
        background: none !important;
        box-shadow: none !important;
    }

    .ek-project .stat-item {
        display: flex !important;
        flex-direction: row !important;
        align-items: center;
        gap: 12px;
        margin: 0 !important;
        padding: 16px !important;
        border: 1px solid var(--pj-border) !important;
        border-radius: 16px !important;
        background: #fff !important;
        box-shadow: 0 6px 18px rgba(31, 70, 69, .05) !important;
        text-align: start !important;
    }

    .ek-project .stat-icon {
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        flex: none;
        width: 44px !important;
        height: 44px !important;
        margin: 0 !important;
        border-radius: 12px !important;
        background: var(--pj-soft) !important;
        color: var(--pj-teal) !important;
        font-size: 17px !important;
    }

    .ek-project .stat-icon i { color: inherit !important; }
    .ek-project .stat-content { min-width: 0; }

    .ek-project .stat-value {
        color: var(--pj-text);
        font-size: 20px;
        font-weight: 800;
        line-height: 1.2;
    }

    .ek-project .stat-value--sm { font-size: 15px; }
    .ek-project .stat-title { margin: 0 !important; color: var(--pj-muted) !important; font-size: 13px !important; }

    /* ---------- Responsive ---------- */
    @media (max-width: 991.98px) {
        .ek-pj-grid {
            grid-template-columns: minmax(0, 1fr);
            grid-template-areas:
                "media"
                "donate"
                "about";
            gap: 18px;
        }

        .ek-pj-donate { position: static; }
    }

    @media (max-width: 575.98px) {
        .ek-project { margin-bottom: 40px; }
        .ek-project .ek-pj-card { padding: 16px !important; border-radius: 18px !important; }
        .ek-project .project-image { border-radius: 18px !important; }
        .ek-project .ek-pj-card__title { font-size: 18px !important; }
        .ek-project .project-details { font-size: 15px; line-height: 1.9; }
        .ek-project .donation-amounts[data-count="4"] { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .ek-project .donation-amounts[data-count="many"] { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .ek-project .statistics-section { grid-template-columns: minmax(0, 1fr); }
        .ek-pj-progress__value { font-size: 15px; }
    }
</style>
