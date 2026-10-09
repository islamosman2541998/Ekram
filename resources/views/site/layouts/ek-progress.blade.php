{{-- Donation progress bar used by the project cards (home, categories, external pages) --}}
<style>
    .ek-progress {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 6px 0 2px;
        direction: rtl;
    }

    .ek-progress .custom-card-progress,
    .ek-progress .progress {
        flex: 1;
        height: 8px !important;
        margin: 0 !important;
        overflow: hidden;
        border-radius: 999px !important;
        background: #E3ECEA !important;
        box-shadow: none !important;
    }

    .ek-progress .custom-card-progress-bar,
    .ek-progress .progress-bar {
        min-width: 8px;
        height: 100%;
        border-radius: 999px !important;
        background: linear-gradient(90deg, #faa440 0%, #ee5a34 100%) !important;
        font-size: 0 !important;
        transition: width .6s ease;
    }

    /* fully funded projects turn green */
    .ek-progress.is-complete .custom-card-progress-bar,
    .ek-progress.is-complete .progress-bar {
        background: linear-gradient(90deg, #469e8d 0%, #2C5F5D 100%) !important;
    }

    .ek-progress__pct {
        flex: none;
        min-width: 44px;
        padding: 2px 8px;
        border-radius: 999px;
        background: #FFF1EA;
        color: #ee5a34;
        font-size: 12.5px;
        font-weight: 700;
        line-height: 1.5;
        text-align: center;
        direction: ltr;
    }

    .ek-progress.is-complete .ek-progress__pct { background: #E6F4F1; color: #2C5F5D; }
</style>
