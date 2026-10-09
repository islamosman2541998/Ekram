<style>
    /* =====================================================================
       Donor profile pages (scoped to .ek-profile) - plain, quiet layout
       ===================================================================== */
    .ek-profile {
        --pf-teal: #2C5F5D;
        --pf-orange: #EE5A34;
        --pf-text: #1F2A2A;
        --pf-muted: #66706F;
        --pf-line: #E4E7E6;
        --pf-bg-soft: #F7F8F8;
        padding: 32px 16px 64px;
        color: var(--pf-text);
    }

    /* style.css sets main { overflow-x: hidden }, which turns <main> into a scroll container and
       breaks position: sticky. clip hides the same overflow without that. */
    main.ek-profile { overflow-x: clip !important; }

    .ek-profile *,
    .ek-profile *::before,
    .ek-profile *::after { box-sizing: border-box; }

    .ek-profile__wrap {
        display: grid;
        grid-template-columns: 240px minmax(0, 1fr);
        align-items: start;
        gap: 28px;
        max-width: 1140px;
        margin: 0 auto;
    }

    .ek-profile__main { display: flex; flex-direction: column; gap: 20px; min-width: 0; }

    /* ---------- Cards ---------- */
    .ek-profile .ek-pf-card {
        padding: 22px 24px;
        border: 1px solid var(--pf-line);
        border-radius: 12px;
        background: #fff;
    }

    .ek-pf-card__head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 14px;
    }

    .ek-profile .ek-pf-card__title {
        margin: 0;
        color: var(--pf-text);
        font-size: 17px !important;
        font-weight: 700;
    }

    /* ---------- Page head ---------- */
    .ek-pf-pagehead {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 16px;
        padding-bottom: 18px;
        border-bottom: 1px solid var(--pf-line);
    }

    .ek-profile .ek-pf-pagehead__title {
        margin: 0 0 4px;
        color: var(--pf-text);
        font-size: 28px !important;
        font-weight: 800;
    }

    .ek-pf-pagehead__sub { margin: 0; color: var(--pf-muted); font-size: 15px; }

    /* ---------- Side ---------- */
    .ek-pf-side { padding: 20px 0 !important; }

    .ek-pf-user { padding: 0 20px 16px; border-bottom: 1px solid var(--pf-line); }
    .ek-pf-user__name { color: var(--pf-text); font-size: 16px; font-weight: 700; overflow-wrap: anywhere; }
    .ek-pf-user__meta { margin-top: 2px; color: var(--pf-muted); font-size: 13.5px; text-align: start; }

    .ek-pf-nav { display: flex; flex-direction: column; padding: 10px 0; }

    .ek-pf-nav__item {
        display: block;
        padding: 10px 20px;
        border-inline-start: 3px solid transparent;
        color: var(--pf-text) !important;
        font-size: 15px;
        text-decoration: none;
        transition: background-color .15s ease, border-color .15s ease;
    }

    .ek-pf-nav__item:hover { background: var(--pf-bg-soft); }

    .ek-pf-nav__item.active {
        border-inline-start-color: var(--pf-teal);
        background: var(--pf-bg-soft);
        color: var(--pf-teal) !important;
        font-weight: 700;
    }

    .ek-pf-side__foot {
        display: flex;
        flex-direction: column;
        gap: 2px;
        padding: 12px 20px 0;
        border-top: 1px solid var(--pf-line);
    }

    .ek-pf-side__action {
        padding: 6px 0;
        color: var(--pf-muted) !important;
        font-size: 14px;
        text-decoration: none;
    }

    .ek-pf-side__action:hover { color: var(--pf-text) !important; text-decoration: underline; text-underline-offset: 3px; }
    .ek-pf-side__action--danger:hover { color: #B42318 !important; }

    /* ---------- Buttons / links ---------- */
    .ek-pf-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        height: 40px;
        padding: 0 18px;
        border: 1px solid transparent;
        border-radius: 8px;
        font-size: 14.5px;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        cursor: pointer;
        transition: background-color .15s ease, border-color .15s ease, color .15s ease;
    }

    .ek-pf-btn--primary { background: var(--pf-teal); color: #fff !important; }
    .ek-pf-btn--primary:hover { background: #234c4a; }
    .ek-pf-btn--outline { height: 36px; padding: 0 14px; border-color: var(--pf-line); background: #fff; color: var(--pf-text) !important; }
    .ek-pf-btn--outline:hover { border-color: var(--pf-teal); color: var(--pf-teal) !important; }
    .ek-pf-btn--ghost { border-color: var(--pf-line); background: #fff; color: var(--pf-text) !important; }
    .ek-pf-btn--danger { background: #B42318; color: #fff !important; }

    .ek-pf-link { color: var(--pf-teal) !important; font-size: 14px; font-weight: 600; text-decoration: none; }
    .ek-pf-link:hover { text-decoration: underline; text-underline-offset: 3px; }

    /* ---------- Summary ---------- */
    .ek-pf-summary { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); padding: 0 !important; }

    .ek-pf-summary__item {
        display: flex;
        flex-direction: column;
        gap: 6px;
        padding: 18px 24px;
    }

    .ek-pf-summary__item + .ek-pf-summary__item { border-inline-start: 1px solid var(--pf-line); }

    .ek-pf-summary__label { color: var(--pf-muted); font-size: 13.5px; }
    .ek-pf-summary__value { color: var(--pf-text); font-size: 24px; font-weight: 800; line-height: 1.2; }
    .ek-pf-summary__value small { color: var(--pf-muted); font-size: 13px; font-weight: 500; }
    .ek-pf-summary__value--sm { font-size: 19px; text-align: start; }

    /* ---------- Tables ---------- */
    .ek-pf-table-wrap { margin: 0 -24px -22px; overflow-x: auto; }

    .ek-pf-table,
    .ek-profile .orders-table {
        width: 100%;
        margin: 0 !important;
        border-collapse: collapse;
        font-size: 14.5px;
    }

    .ek-pf-table th,
    .ek-profile .orders-table th {
        padding: 10px 24px !important;
        border-top: 1px solid var(--pf-line);
        border-bottom: 1px solid var(--pf-line) !important;
        background: var(--pf-bg-soft) !important;
        color: var(--pf-muted) !important;
        font-size: 13px;
        font-weight: 600;
        text-align: start;
        white-space: nowrap;
    }

    .ek-pf-table td,
    .ek-profile .orders-table td,
    .ek-profile .orders-table tbody th {
        padding: 13px 24px !important;
        border-bottom: 1px solid var(--pf-line) !important;
        background: #fff !important;
        color: var(--pf-text) !important;
        text-align: start;
        vertical-align: middle;
        white-space: nowrap;
    }

    .ek-pf-table tbody tr:last-child td { border-bottom: 0 !important; }
    .ek-pf-table td small, .ek-profile .orders-table td small { color: var(--pf-muted); font-size: 12px; }
    .ek-pf-table__strong { font-weight: 700; }

    /* ---------- Status badge (shared with the order popup) ---------- */
    .ek-od__status {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 6px;
        font-size: 12.5px;
        font-weight: 600;
        line-height: 1.5;
        white-space: nowrap;
    }

    .ek-od__status--ok { background: #ECFDF3; color: #067647; }
    .ek-od__status--wait { background: #FFFAEB; color: #B54708; }
    .ek-od__status--info { background: #EFF8FF; color: #175CD3; }
    .ek-od__status--bad { background: #FEF3F2; color: #B42318; }

    /* ---------- Personal info ---------- */
    .ek-pf-info { margin: 0; }

    .ek-pf-info > div {
        display: grid;
        grid-template-columns: 160px minmax(0, 1fr);
        gap: 12px;
        padding: 12px 0;
        border-top: 1px solid var(--pf-line);
    }

    .ek-pf-info dt { color: var(--pf-muted); font-size: 14px; font-weight: 500; }
    .ek-pf-info dd { margin: 0; color: var(--pf-text); font-size: 15px; font-weight: 600; overflow-wrap: anywhere; text-align: start; }

    .ek-pf-empty { padding: 8px 0 4px; color: var(--pf-muted); }
    .ek-pf-empty p { margin: 0 0 12px; }

    /* ---------- Orders page (livewire content) ---------- */
    .ek-pf-card--content { overflow-x: auto; }
    .ek-pf-card--content .container { max-width: none !important; padding: 0 !important; }

    .ek-profile .section-title {
        margin: 0 0 16px !important;
        padding: 0 !important;
        color: var(--pf-text) !important;
        font-size: 22px !important;
        font-weight: 800;
    }

    .ek-profile .section-title::after,
    .ek-profile .section-title::before { display: none !important; }

    .ek-profile .statistics-container {
        display: grid !important;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0 !important;
        margin: 0 0 18px !important;
        padding: 0 !important;
        border: 1px solid var(--pf-line);
        border-radius: 10px;
        background: #fff !important;
    }

    .ek-profile .statistics-container .statistic {
        display: flex !important;
        flex-direction: column;
        align-items: flex-start !important;
        gap: 4px;
        width: auto !important;
        height: auto !important;
        margin: 0 !important;
        padding: 14px 20px !important;
        border: 0 !important;
        border-radius: 0 !important;
        background: transparent !important;
        box-shadow: none !important;
        text-align: start !important;
    }

    .ek-profile .statistics-container .statistic + .statistic { border-inline-start: 1px solid var(--pf-line) !important; }
    .ek-profile .statistic-title { color: var(--pf-muted) !important; font-size: 13.5px !important; }
    .ek-profile .statistic-value { color: var(--pf-text) !important; font-size: 22px !important; font-weight: 800; }
    .ek-profile .statistic-currency { color: var(--pf-muted) !important; font-size: 12px !important; }

    .ek-profile .orders-filter { margin-bottom: 14px !important; }
    .ek-profile .filter-buttons { display: flex; flex-wrap: wrap; gap: 6px; }

    .ek-profile .filter-btn {
        height: 34px;
        padding: 0 14px !important;
        border: 1px solid var(--pf-line) !important;
        border-radius: 8px !important;
        background: #fff !important;
        color: var(--pf-text) !important;
        font-size: 14px !important;
        box-shadow: none !important;
    }

    .ek-profile .filter-btn.active { border-color: var(--pf-teal) !important; background: var(--pf-teal) !important; color: #fff !important; }

    .ek-profile .orders-table-container {
        margin: 0 -24px !important;
        padding: 0 !important;
        border: 0 !important;
        border-radius: 0 !important;
        background: transparent !important;
        box-shadow: none !important;
    }

    .ek-profile .orders-table-container .table-responsive { margin: 0 !important; padding: 0 !important; border: 0 !important; }
    .ek-profile .orders-table > :not(caption) > * > * { box-shadow: none !important; }
    .ek-profile .orders-table > :not(:first-child) { border-top: 0 !important; }

    /* edit page: the livewire form brings its own card - flatten it */
    .ek-profile .profile-info-card {
        margin: 0 !important;
        padding: 0 !important;
        border: 0 !important;
        background: transparent !important;
        box-shadow: none !important;
    }

    .ek-profile .profile-info-card .form-control { height: 46px; border-radius: 8px !important; background: #fff !important; }
    .ek-profile .profile-info-card .form-control:focus { border-color: var(--pf-teal) !important; box-shadow: 0 0 0 3px rgba(44, 95, 93, .12) !important; }
    .ek-profile .edit-profile-btn { height: 42px; padding: 0 28px !important; border: 0 !important; border-radius: 8px !important; font-weight: 600; }

    /* fixed-width badge so the "show" buttons line up */
    .ek-orders__status-cell .ek-od__status { min-width: 78px; text-align: center; }
    .ek-orders__status-cell { white-space: nowrap; }
    .ek-orders__status-cell > * { vertical-align: middle; }
    .ek-orders__status-cell .ek-od { display: inline-block; margin-inline-start: 8px; }

    /* ---------- Order details popup ---------- */
    .ek-od__open {
        display: inline-flex;
        align-items: center;
        height: 30px;
        padding: 0 12px;
        border: 1px solid var(--pf-line);
        border-radius: 6px;
        background: #fff;
        color: var(--pf-teal);
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: border-color .15s ease, background-color .15s ease;
    }

    .ek-od__open:hover { border-color: var(--pf-teal); background: var(--pf-bg-soft); }

    .ek-od__overlay {
        position: fixed;
        inset: 0;
        z-index: 2000;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
        background: rgba(16, 24, 24, .5);
        white-space: normal;
    }

    .ek-od__dialog {
        display: flex;
        flex-direction: column;
        width: 100%;
        max-width: 640px;
        max-height: calc(100vh - 32px);
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 24px 48px rgba(0, 0, 0, .18);
        color: var(--pf-text);
        text-align: start;
    }

    .ek-od__head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        padding: 18px 22px;
        border-bottom: 1px solid var(--pf-line);
    }

    .ek-od__eyebrow { color: var(--pf-muted); font-size: 13px; }
    .ek-od__title { margin: 2px 0 0; color: var(--pf-text); font-size: 20px !important; font-weight: 800; }
    .ek-od__head-end { display: flex; align-items: center; gap: 10px; }

    .ek-od__close {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border: 1px solid var(--pf-line);
        border-radius: 8px;
        background: #fff;
        color: var(--pf-muted);
        cursor: pointer;
    }

    .ek-od__close:hover { color: var(--pf-text); border-color: var(--pf-text); }

    .ek-od__body { padding: 18px 22px; overflow-y: auto; }

    .ek-od__summary {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        margin: 0 0 6px;
        border: 1px solid var(--pf-line);
        border-radius: 10px;
    }

    .ek-od__summary > div { padding: 12px 16px; }
    .ek-od__summary > div:nth-child(even) { border-inline-start: 1px solid var(--pf-line); }
    .ek-od__summary > div:nth-child(n+3) { border-top: 1px solid var(--pf-line); }
    .ek-od__summary dt { color: var(--pf-muted); font-size: 12.5px; font-weight: 500; }
    .ek-od__summary dd { margin: 2px 0 0; font-size: 15px; font-weight: 700; text-align: start; }
    .ek-od__summary dd small { color: var(--pf-muted); font-size: 12px; font-weight: 500; }

    .ek-od__link { display: inline-flex; align-items: center; gap: 6px; margin-top: 10px; color: var(--pf-teal) !important; font-size: 14px; font-weight: 600; }
    .ek-od__row-note { margin-top: 10px; color: var(--pf-muted); font-size: 14px; }

    .ek-od__section { margin: 20px 0 8px; color: var(--pf-text); font-size: 15px !important; font-weight: 700; }

    .ek-od__items { border: 1px solid var(--pf-line); border-radius: 10px; }

    .ek-od__item {
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        align-items: center;
        gap: 4px 12px;
        padding: 12px 16px;
    }

    .ek-od__item + .ek-od__item { border-top: 1px solid var(--pf-line); }
    .ek-od__item-name { font-size: 15px; font-weight: 700; }
    .ek-od__item-name a { color: var(--pf-text) !important; text-decoration: none; }
    .ek-od__item-name a:hover { color: var(--pf-teal) !important; text-decoration: underline; }
    .ek-od__item-meta { color: var(--pf-muted); font-size: 13px; }
    .ek-od__item-total { font-size: 15px; font-weight: 700; white-space: nowrap; }
    .ek-od__item-total small { color: var(--pf-muted); font-size: 12px; font-weight: 500; }

    .ek-od__gift-toggle {
        grid-column: 1 / -1;
        justify-self: start;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 4px;
        padding: 0;
        border: 0;
        background: none;
        color: var(--pf-teal);
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
    }

    .ek-od__gift-toggle i { font-size: 10px; }

    .ek-od__gift {
        grid-column: 1 / -1;
        display: flex;
        gap: 14px;
        margin-top: 6px;
        padding: 12px;
        border-radius: 8px;
        background: var(--pf-bg-soft);
    }

    .ek-od__gift-img img { width: 72px; height: 54px; border-radius: 6px; object-fit: cover; }
    .ek-od__gift dl { flex: 1; margin: 0; }
    .ek-od__gift dl > div { display: flex; gap: 8px; font-size: 13.5px; line-height: 1.8; }
    .ek-od__gift dt { min-width: 90px; color: var(--pf-muted); font-weight: 500; }
    .ek-od__gift dd { margin: 0; font-weight: 600; }

    .ek-od__foot {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        padding: 14px 22px;
        border-top: 1px solid var(--pf-line);
    }

    .ek-od__btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        height: 38px;
        padding: 0 16px;
        border: 1px solid var(--pf-line);
        border-radius: 8px;
        background: #fff;
        color: var(--pf-text) !important;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
    }

    .ek-od__btn--primary { border-color: var(--pf-teal); background: var(--pf-teal); color: #fff !important; }

    /* ---------- Delete account modal ---------- */
    .ek-pf-modal .modal-content { border: 0; border-radius: 12px; box-shadow: 0 24px 48px rgba(0, 0, 0, .18); }
    .ek-pf-modal .modal-body { padding: 24px 24px 8px; text-align: start; }
    .ek-pf-modal .modal-title { margin: 0 0 6px; color: var(--pf-text); font-size: 18px; font-weight: 800; }
    .ek-pf-modal .modal-body p { margin: 0; color: var(--pf-muted); font-size: 15px; }
    .ek-pf-modal .modal-footer { padding: 16px 24px 20px; border: 0; }
    .ek-pf-modal .modal-footer form { display: flex; justify-content: flex-end; gap: 8px; width: 100%; }

    /* ---------- Responsive ---------- */
    @media (max-width: 991.98px) {
        .ek-profile__wrap { grid-template-columns: minmax(0, 1fr); gap: 18px; }

        .ek-pf-side { padding: 0 !important; }
        .ek-pf-user { padding: 14px 16px; }
        .ek-pf-nav { flex-direction: row; padding: 0; overflow-x: auto; border-bottom: 1px solid var(--pf-line); scrollbar-width: none; }
        .ek-pf-nav::-webkit-scrollbar { display: none; }
        .ek-pf-nav__item { flex: none; padding: 12px 16px; border-inline-start: 0; border-bottom: 2px solid transparent; }
        .ek-pf-nav__item.active { border-bottom-color: var(--pf-teal); background: transparent; }
        .ek-pf-side__foot { flex-direction: row; gap: 18px; padding: 10px 16px; border-top: 0; }
    }

    @media (max-width: 575.98px) {
        .ek-profile { padding: 18px 12px 40px; }
        .ek-profile .ek-pf-card { padding: 16px; }
        .ek-pf-pagehead { flex-direction: column; align-items: stretch; }
        .ek-profile .ek-pf-pagehead__title { font-size: 24px !important; }
        .ek-pf-summary { grid-template-columns: minmax(0, 1fr); }
        .ek-pf-summary__item { padding: 14px 16px; }
        .ek-pf-summary__item + .ek-pf-summary__item { border-inline-start: 0; border-top: 1px solid var(--pf-line); }
        .ek-pf-table-wrap { margin: 0 -16px -16px; }
        .ek-pf-table th, .ek-pf-table td { padding-inline: 16px !important; }
        .ek-pf-info > div { grid-template-columns: minmax(0, 1fr); gap: 2px; }
        .ek-profile .orders-table-container { margin: 0 -16px; }
        .ek-od__summary { grid-template-columns: minmax(0, 1fr); }
        .ek-od__summary > div:nth-child(even) { border-inline-start: 0; }
        .ek-od__summary > div + div { border-top: 1px solid var(--pf-line); }
        .ek-od__gift { flex-direction: column; }
    }
    /* =====================================================================
       Brand layer: site identity colours (teal / dark teal / amber / orange)
       ===================================================================== */
    .ek-profile {
        --pf-teal: #04525A;
        --pf-teal-2: #469e8d;
        --pf-amber: #faa440;
        --pf-orange: #ee5a34;
        --pf-cream: #FCF4EC;
        --pf-tint: #EEF6F4;
    }

    /* four-colour identity strip (same as the receipt) */
    .ek-pf-strip { display: flex; height: 5px; }
    .ek-pf-strip span { flex: 1; }
    .ek-pf-strip span:nth-child(1) { background: #04525A; }
    .ek-pf-strip span:nth-child(2) { background: #469e8d; }
    .ek-pf-strip span:nth-child(3) { background: #faa440; }
    .ek-pf-strip span:nth-child(4) { background: #ee5a34; }

    /* ---- side ---- */
    .ek-profile .ek-pf-side { padding: 0 !important; overflow: hidden; }

    .ek-pf-user { padding: 22px 20px 18px; text-align: center; background: var(--pf-cream); }
    .ek-pf-user__logo { display: inline-block; margin-bottom: 14px; }
    .ek-pf-user__logo img { display: block; height: 64px; width: auto; }
    .ek-pf-user__name { color: var(--pf-teal); font-size: 17px; }
    .ek-pf-user__meta { text-align: center; }

    .ek-pf-nav { padding: 10px; gap: 2px; }

    .ek-pf-nav__item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 11px 14px;
        border-inline-start: 0;
        border-radius: 8px;
        color: var(--pf-text) !important;
    }

    .ek-pf-nav__item i { width: 18px; color: var(--pf-teal-2); text-align: center; }
    .ek-pf-nav__item:hover { background: var(--pf-tint); }
    .ek-pf-nav__item.active { background: var(--pf-teal); color: #fff !important; }
    .ek-pf-nav__item.active i { color: var(--pf-amber); }

    .ek-pf-side__foot { gap: 6px; padding: 12px 10px 14px; }

    .ek-pf-side__logout {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        height: 40px;
        border: 1px solid #F5C7B9;
        border-radius: 8px;
        background: #FFF5F1;
        color: var(--pf-orange) !important;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: background-color .15s ease, color .15s ease;
    }

    .ek-pf-side__logout:hover { background: var(--pf-orange); color: #fff !important; }
    .ek-pf-side__action { text-align: center; font-size: 13px; }

    /* ---- page head ---- */
    .ek-profile .ek-pf-pagehead__title { color: var(--pf-teal); }

    .ek-profile .ek-pf-pagehead__title::after {
        content: "";
        display: block;
        width: 48px;
        height: 4px;
        margin-top: 8px;
        border-radius: 2px;
        background: linear-gradient(90deg, var(--pf-amber) 50%, var(--pf-orange) 50%);
    }

    .ek-pf-btn--primary { background: var(--pf-orange); }
    .ek-pf-btn--primary:hover { background: #d94c28; }

    /* ---- summary ---- */
    .ek-pf-summary { overflow: hidden; }
    .ek-pf-summary__item { border-top: 3px solid transparent; }
    .ek-pf-summary__item:nth-child(1) { border-top-color: var(--pf-orange); }
    .ek-pf-summary__item:nth-child(2) { border-top-color: var(--pf-teal-2); }
    .ek-pf-summary__item:nth-child(3) { border-top-color: var(--pf-amber); }
    .ek-pf-summary__item:nth-child(1) .ek-pf-summary__value { color: var(--pf-orange); }
    .ek-pf-summary__item:nth-child(2) .ek-pf-summary__value { color: var(--pf-teal); }

    /* ---- cards / tables ---- */
    .ek-profile .ek-pf-card__title { color: var(--pf-teal); }
    .ek-pf-link { color: var(--pf-orange) !important; }

    .ek-pf-table th,
    .ek-profile .orders-table th {
        background: var(--pf-tint) !important;
        color: var(--pf-teal) !important;
    }

    .ek-pf-btn--outline:hover { border-color: var(--pf-orange); color: var(--pf-orange) !important; }
    .ek-profile .filter-btn.active { border-color: var(--pf-teal) !important; background: var(--pf-teal) !important; }
    .ek-od__open { color: var(--pf-teal); }
    .ek-od__open:hover { border-color: var(--pf-teal-2); background: var(--pf-tint); }
    .ek-profile .section-title { color: var(--pf-teal) !important; }
    .ek-profile .statistic-value { color: var(--pf-teal) !important; }
    .ek-od__title { color: var(--pf-teal); }
    .ek-od__btn--primary { border-color: var(--pf-teal); background: var(--pf-teal); }

    @media (max-width: 991.98px) {
        .ek-pf-user { display: flex; align-items: center; gap: 14px; padding: 14px 16px; text-align: start; }
        .ek-pf-user__logo { margin: 0; }
        .ek-pf-user__logo img { height: 46px; }
        .ek-pf-user__meta { text-align: start; }
        .ek-pf-nav { padding: 6px 8px; }
        .ek-pf-nav__item { border-radius: 8px; border-bottom: 0; }
        .ek-pf-nav__item.active { background: var(--pf-teal); }
        .ek-pf-side__foot { flex-direction: row; align-items: center; justify-content: space-between; padding: 10px 12px 12px; }
        .ek-pf-side__logout { flex: 1; }
        .ek-pf-side__action { padding: 0 6px; }
    }
</style>
