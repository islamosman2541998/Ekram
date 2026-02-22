@extends('site.app')

@php
    $settings = App\Charity\Settings\SettingSingleton::getInstance();
@endphp
@section('content')
    <div class="contact-page py-5" dir="rtl">
        <div class="container">
            <h2 class="contact-main-title text-center mb-5">تواصل معنا</h2>

            <div class="row g-4 justify-content-center align-items-stretch">

                {{-- Contact Info --}}
                <div class="col-lg-5 col-md-6">
                    <div class="contact-info-card h-100">
                        {{-- Logo --}}
                        <div class="contact-logo-wrapper text-center mb-4">
                            <img src="{{ asset(getImage($settings->getItem('logo')) ?? site_path('img/logo.png')) }}"
                                class="contact-logo" alt="Logo" />
                        </div>

                        {{-- Phone & WhatsApp --}}
                        <div class="contact-details">
                            @if ($settings->getContactInformationData('mobile'))
                                <a href="tel:{{ $settings->getContactInformationData('mobile') }}" class="contact-detail-item">
                                    <div class="contact-detail-icon">
                                        <i class="fa-solid fa-phone"></i>
                                    </div>
                                    <span>{{ $settings->getContactInformationData('mobile') }}</span>
                                </a>
                            @endif

                            @if ($settings->getContactInformationData('whatsapp'))
                                <a href="https://wa.me/{{ $settings->getContactInformationData('whatsapp') }}" class="contact-detail-item">
                                    <div class="contact-detail-icon whatsapp">
                                        <i class="fa-brands fa-whatsapp"></i>
                                    </div>
                                    <span>{{ $settings->getContactInformationData('whatsapp') }}</span>
                                </a>
                            @endif

                            @if ($settings->getContactInformationData('email'))
                                <a href="mailto:{{ $settings->getContactInformationData('email') }}" class="contact-detail-item">
                                    <div class="contact-detail-icon email">
                                        <i class="fa-solid fa-envelope"></i>
                                    </div>
                                    <span>{{ $settings->getContactInformationData('email') }}</span>
                                </a>
                            @endif
                        </div>

                        {{-- Social Icons --}}
                        <div class="contact-social">
                            @if ($settings->getContactInformationData('instagram'))
                                <a href="{{ $settings->getContactInformationData('instagram') }}"><i class="fa-brands fa-instagram"></i></a>
                            @endif
                            @if ($settings->getContactInformationData('facebook'))
                                <a href="{{ $settings->getContactInformationData('facebook') }}"><i class="fa-brands fa-facebook"></i></a>
                            @endif
                            @if ($settings->getContactInformationData('youtube'))
                                <a href="{{ $settings->getContactInformationData('youtube') }}"><i class="fa-brands fa-youtube"></i></a>
                            @endif
                            @if ($settings->getContactInformationData('twitter'))
                                <a href="{{ $settings->getContactInformationData('twitter') }}"><i class="fa-brands fa-x-twitter"></i></a>
                            @endif
                            @if ($settings->getContactInformationData('snapchat'))
                                <a href="{{ $settings->getContactInformationData('snapchat') }}"><i class="fa-brands fa-snapchat"></i></a>
                            @endif
                        </div>

                        <p class="contact-copyright">
                            جميع الحقوق محفوظة {{ date('Y') }} &copy;
                        </p>
                    </div>
                </div>

                {{-- Form --}}
                <div class="col-lg-7 col-md-6">
                    <div class="contact-form-card h-100">
                        <h3 class="contact-form-title">أرسل لنا رسالة</h3>
                        <p class="contact-form-subtitle">يسعدنا تواصلك معنا، سنقوم بالرد في أقرب وقت</p>

                        <form action="{{ route('site.contact-us.store') }}" method="POST">
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="contact-input-group">
                                        <label for="full_name">الاسم الكامل</label>
                                        <div class="input-wrapper">
                                            <i class="fa-solid fa-user"></i>
                                            <input type="text" name="full_name" id="full_name"
                                                class="@error('full_name') is-invalid @enderror"
                                                value="{{ old('full_name') }}" placeholder="ادخل اسمك الكامل">
                                        </div>
                                        @error('full_name')
                                            <div class="error-msg">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="contact-input-group">
                                        <label for="email">البريد الإلكتروني</label>
                                        <div class="input-wrapper">
                                            <i class="fa-solid fa-envelope"></i>
                                            <input type="email" name="email" id="email"
                                                class="@error('email') is-invalid @enderror"
                                                value="{{ old('email') }}" placeholder="example@email.com">
                                        </div>
                                        @error('email')
                                            <div class="error-msg">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="contact-input-group">
                                        <label for="phone">الهاتف</label>
                                        <div class="input-wrapper">
                                            <i class="fa-solid fa-phone"></i>
                                            <input type="text" name="phone" id="phone"
                                                class="@error('phone') is-invalid @enderror"
                                                value="{{ old('phone') }}" placeholder="05xxxxxxxx">
                                        </div>
                                        @error('phone')
                                            <div class="error-msg">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="contact-input-group">
                                        <label for="city">المدينة</label>
                                        <div class="input-wrapper">
                                            <i class="fa-solid fa-location-dot"></i>
                                            <input type="text" name="city" id="city"
                                                class="@error('city') is-invalid @enderror"
                                                value="{{ old('city') }}" placeholder="اسم المدينة">
                                        </div>
                                        @error('city')
                                            <div class="error-msg">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="contact-input-group">
                                        <label for="title">عنوان الرسالة</label>
                                        <div class="input-wrapper">
                                            <i class="fa-solid fa-heading"></i>
                                            <input type="text" name="title" id="title"
                                                class="@error('title') is-invalid @enderror"
                                                value="{{ old('title') }}" placeholder="موضوع رسالتك">
                                        </div>
                                        @error('title')
                                            <div class="error-msg">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="contact-input-group">
                                        <label for="message">الرسالة</label>
                                        <div class="input-wrapper textarea-wrapper">
                                            <i class="fa-solid fa-message"></i>
                                            <textarea name="message" id="message" rows="4"
                                                class="@error('message') is-invalid @enderror"
                                                placeholder="اكتب رسالتك هنا...">{{ old('message') }}</textarea>
                                        </div>
                                        @error('message')
                                            <div class="error-msg">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="contact-submit-btn">
                                        <i class="fa-solid fa-paper-plane"></i>
                                        إرسال الرسالة
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

<style>
    /* ========== Contact Page ========== */
    .contact-page {
        background: #faf8f5;
        min-height: 80vh;
    }

    .contact-main-title {
        font-size: 2rem;
        font-weight: 800;
        color: #2d6a5a;
        position: relative;
        padding-bottom: 12px;
    }
    .contact-main-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 4px;
        background: linear-gradient(90deg, #faa440, #ee5a34);
        border-radius: 4px;
    }

    /* ===== Info Card ===== */
    .contact-info-card {
        background: linear-gradient(160deg, #ffffff 0%, #f0faf7 100%);
        border-radius: 20px;
        padding: 30px 24px;
        box-shadow: 0 4px 24px rgba(45, 106, 90, 0.08);
        border: 1px solid #e0efe9;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .contact-logo {
        max-width: 140px;
        height: auto;
    }

    .contact-details {
        width: 100%;
        margin-bottom: 20px;
    }

    .contact-detail-item {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        padding: 12px 16px;
        margin-bottom: 10px;
        background: #fff;
        border-radius: 12px;
        text-decoration: none;
        color: #333;
        font-size: 15px;
        font-weight: 600;
        transition: all 0.2s ease;
        border: 1px solid #eee;
        direction: ltr;
    }
    .contact-detail-item:hover {
        background: #f0faf7;
        border-color: #2d6a5a;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(45, 106, 90, 0.1);
    }

    .contact-detail-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: linear-gradient(135deg, #2d6a5a, #3a8f7a);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }
    .contact-detail-icon.whatsapp {
        background: linear-gradient(135deg, #25d366, #128c7e);
    }
    .contact-detail-icon.email {
        background: linear-gradient(135deg, #faa440, #ee5a34);
    }

    /* Social */
    .contact-social {
        display: flex;
        gap: 12px;
        justify-content: center;
        margin-bottom: 16px;
    }
    .contact-social a {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: #fff;
        border: 1.5px solid #e0efe9;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2d6a5a;
        font-size: 18px;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .contact-social a:hover {
        background: #2d6a5a;
        color: #fff;
        border-color: #2d6a5a;
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(45, 106, 90, 0.25);
    }

    .contact-copyright {
        color: #999;
        font-size: 13px;
        margin: 0;
    }

    /* ===== Form Card ===== */
    .contact-form-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 32px 28px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
        border: 1px solid #eee;
    }

    .contact-form-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: #2d6a5a;
        margin-bottom: 4px;
    }

    .contact-form-subtitle {
        color: #888;
        font-size: 14px;
        margin-bottom: 24px;
    }

    /* Input Groups */
    .contact-input-group {
        margin-bottom: 4px;
    }
    .contact-input-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #444;
        margin-bottom: 6px;
    }

    .input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }
    .input-wrapper i {
        position: absolute;
        right: 14px;
        color: #2d6a5a;
        font-size: 14px;
        z-index: 1;
    }
    .input-wrapper input,
    .input-wrapper textarea {
        width: 100%;
        padding: 12px 42px 12px 14px;
        border: 1.5px solid #e0e0e0;
        border-radius: 12px;
        font-size: 14px;
        color: #333;
        background: #fafafa;
        transition: all 0.2s ease;
        direction: rtl;
        outline: none;
    }
    .input-wrapper input:focus,
    .input-wrapper textarea:focus {
        border-color: #2d6a5a;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(45, 106, 90, 0.08);
    }
    .input-wrapper input::placeholder,
    .input-wrapper textarea::placeholder {
        color: #bbb;
        font-size: 13px;
    }
    .input-wrapper input.is-invalid,
    .input-wrapper textarea.is-invalid {
        border-color: #dc3545;
    }

    .textarea-wrapper {
        align-items: flex-start;
    }
    .textarea-wrapper i {
        top: 14px;
    }
    .textarea-wrapper textarea {
        resize: vertical;
        min-height: 100px;
    }

    .error-msg {
        color: #dc3545;
        font-size: 12px;
        margin-top: 4px;
    }

    /* Submit Button */
    .contact-submit-btn {
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #2d6a5a 0%, #3a8f7a 100%);
        color: #fff;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    .contact-submit-btn:hover {
        background: linear-gradient(135deg, #245a4c 0%, #2f7a66 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(45, 106, 90, 0.3);
    }

    /* ===== Responsive ===== */
    @media (max-width: 767.98px) {
        .contact-form-card,
        .contact-info-card {
            padding: 24px 18px;
        }
        .contact-logo {
            max-width: 110px;
        }
    }
</style>