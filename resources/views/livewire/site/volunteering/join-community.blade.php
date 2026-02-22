<main>
    <div class="registration-container">
        <div class="registration-content">
            <h1 class="registration-title">تسجيل متطوع جديد</h1>

            <div class="registration-notice">
                <p>لايمكنك التسجيل لأكثر من مرة. ولابد أن تتحرى الدقة في تسجيل البيانات. لا يمكن اتمامنا بيانات مغلوطة
                    أو غير دقيقة. ولا تستعن بأحد في ذلك. في حالة إذا استخدمت بيانات غير دقيقة أو مغلوطة فإنك تعرض نفسك
                    للجزاء القانوني. استخدامك بيانات غير صحيحة يعتبر تضليل.</p>
            </div>

            <form wire:submit.prevent="submit">
                <!-- Personal Information Section -->
                <div class="form-section personal-info">
                    <h2 class="section-title">المعلومات الشخصية</h2>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="form-group labeled-input">
                                <span class="field-label">الاسم الكامل</span>
                                <input type="text" class="form-control" wire:model="name">


                            </div>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group labeled-input">
                                <span class="field-label">البريد الإلكتروني</span>
                                <input type="email" class="form-control" wire:model="email">


                            </div>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group labeled-input">
                                <span class="field-label">رقم الجوال</span>
                                <input type="tel" class="form-control" wire:model="mobile">


                            </div>
                            @error('mobile')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="form-group labeled-input">
                                <span class="field-label">تاريخ الميلاد</span>
                                <input type="date" class="form-control" wire:model="date_of_birth">


                            </div>
                            @error('date_of_birth')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group labeled-input">
                                <span class="field-label">الجنس</span>
                                <select class="form-select" wire:model="gender">
                                    <option value="">اختر</option>
                                    <option value="ذكر">ذكر</option>
                                    <option value="أنثى">أنثى</option>
                                </select>


                            </div>
                            @error('gender')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group labeled-input">
                                <span class="field-label">الجنسية</span>
                                <select class="form-select" wire:model="nationality">
                                    <option value="">اختر</option>
                                    <option value="السعودية">السعودية</option>
                                    <option value="مصر">مصر</option>
                                    <option value="الأردن">الأردن</option>
                                    <option value="الإمارات">الإمارات</option>
                                </select>


                            </div>
                            @error('nationality')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <div class="form-group labeled-input">
                                <span class="field-label">المؤهل الدراسي</span>
                                <select class="form-select" wire:model="educational_qualification">
                                    <option value="">اختر</option>
                                    <option value="متوسطة">متوسطة</option>
                                    <option value="ثانوية">ثانوية</option>
                                    <option value="بكالوريوس">بكالوريوس</option>
                                    <option value="ماجستير">ماجستير</option>
                                    <option value="دكتوراه">دكتوراه</option>
                                </select>


                            </div>
                            @error('educational_qualification')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group labeled-input">
                                <span class="field-label">رقم السجل المدني</span>
                                <input type="text" class="form-control" wire:model="identity">

                            </div>
                            @error('identity')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>

                    </div>

                    <div class="row">

                        {{-- <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <div class="labeled-input">
                                    <span class="field-label">الصورة الشخصية</span>
                                    <input type="file" class="form-control" wire:model="image">
                                </div>
                                @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>
                        </div> --}}
                    </div>
                </div>

                <!-- Preferences Section -->
                <div class="form-section preferences">
                    <h2 class="section-title">التفضيلات</h2>

                    <div class="row g-4">
                        {{-- المجالات --}}
                        <div class="col-lg-4 col-md-6">
                            <div class="pref-card">
                                <div class="pref-card-header">
                                    <i class="fa-solid fa-briefcase"></i>
                                    <h5>المجالات التي ترغب بالتطوع فيها</h5>
                                </div>
                                <div class="pref-card-body">
                                    @foreach (['ميداني', 'اداري', 'اعلامي', 'علاقات عامة', 'تقني', 'تسويق رقمي', 'تصميم', 'خدمة المستفيدين', 'أخرى'] as $field)
                                        <label class="pref-checkbox" for="field-{{ $loop->index }}">
                                            <input class="form-check-input" type="checkbox"
                                                wire:model="preferred_fields" value="{{ $field }}"
                                                id="field-{{ $loop->index }}">
                                            <span>{{ $field }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('preferred_fields')
                                    <span class="text-danger d-block mt-2 px-3">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- الفترة المفضلة --}}
                        <div class="col-lg-4 col-md-6">
                            <div class="pref-card">
                                <div class="pref-card-header">
                                    <i class="fa-solid fa-clock"></i>
                                    <h5>الفترة المفضلة</h5>
                                </div>
                                <div class="pref-card-body">
                                    @foreach (['صباحية', 'مسائية', 'نهاية الأسبوع', 'خلال موسم معين مثل رمضان أو الحج أو غيره'] as $time)
                                        <label class="pref-checkbox" for="time-{{ $loop->index }}">
                                            <input class="form-check-input" type="checkbox"
                                                wire:model="preferred_times" value="{{ $time }}"
                                                id="time-{{ $loop->index }}">
                                            <span>{{ $time }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('preferred_times')
                                    <span class="text-danger d-block mt-2 px-3">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- الهدف --}}
                        <div class="col-lg-4 col-md-12">
                            <div class="pref-card">
                                <div class="pref-card-header">
                                    <i class="fa-solid fa-bullseye"></i>
                                    <h5>الهدف من التطوع</h5>
                                </div>
                                <div class="pref-card-body">
                                    <textarea class="pref-textarea" rows="8" wire:model="goal" placeholder="سجل ملاحظاتك هنا..."></textarea>
                                </div>
                                @error('goal')
                                    <span class="text-danger d-block mt-2 px-3">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" wire:model="agreement" id="agreement">
                        <label class="form-check-label" for="agreement">
                            أتعهد بأن جميع البيانات للخدمة صحيحة ودقيقة وغير مغلوطة
                        </label>
                    </div>
                    @error('agreement')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="submit-btn">الاستمرار</button>
                </div>
            </form>

            @if (session()->has('success'))
                <div class="alert alert-success mt-3">
                    {{ session('success') }}
                </div>
            @endif
        </div>
    </div>
</main>
<style>
    /* ===== Preferences Section ===== */
.preferences {
    direction: rtl;
}

.pref-card {
    background: #fff;
    border-radius: 16px;
    border: 1.5px solid #e0efe9;
    overflow: hidden;
    height: 100%;
    display: flex;
    flex-direction: column;
    transition: box-shadow 0.2s ease;
}
.pref-card:hover {
    box-shadow: 0 4px 16px rgba(45, 106, 90, 0.1);
}

.pref-card-header {
    background: linear-gradient(135deg, #2d6a5a 0%, #3a8f7a 100%);
    padding: 14px 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.pref-card-header i {
    color: #fff;
    font-size: 18px;
}
.pref-card-header h5 {
    color: #fff;
    font-size: 15px;
    font-weight: 700;
    margin: 0;
}

.pref-card-body {
    padding: 16px;
    flex: 1;
}

/* Checkbox Items */
.pref-checkbox {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 14px;
    margin-bottom: 6px;
    border-radius: 10px;
    cursor: pointer;
    transition: background 0.15s ease;
    border: 1.5px solid transparent;
}
.pref-checkbox:hover {
    background: #f0faf7;
    border-color: #d0e8e0;
}

.pref-checkbox .form-check-input {
    width: 20px;
    height: 20px;
    margin: 0;
    border: 2px solid #ccc;
    border-radius: 6px;
    cursor: pointer;
    flex-shrink: 0;
}
.pref-checkbox .form-check-input:checked {
    background-color: #2d6a5a;
    border-color: #2d6a5a;
}

.pref-checkbox span {
    font-size: 14px;
    color: #444;
    font-weight: 500;
    line-height: 1.4;
}

/* Textarea */
.pref-textarea {
    width: 100%;
    border: 1.5px solid #e0e0e0;
    border-radius: 12px;
    padding: 14px;
    font-size: 14px;
    color: #333;
    background: #fafafa;
    resize: vertical;
    min-height: 200px;
    direction: rtl;
    outline: none;
    transition: all 0.2s ease;
}
.pref-textarea:focus {
    border-color: #2d6a5a;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(45, 106, 90, 0.08);
}
.pref-textarea::placeholder {
    color: #bbb;
}

/* ===== Responsive ===== */
@media (max-width: 767.98px) {
    .pref-card-header {
        padding: 12px 16px;
    }
    .pref-card-body {
        padding: 12px;
    }
    .pref-checkbox {
        padding: 8px 10px;
    }
}
</style>