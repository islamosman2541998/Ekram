  @extends('site.app')

@php
    $settings = App\Charity\Settings\SettingSingleton::getInstance();
@endphp
@section('content')
  
  <!-- our story -->
  <section class="story-section">
    <div class="container">
      <div class="row align-items-center g-4">
        <!-- Image -->
        <div class="col-lg-6 col-md-6 col-sm-12">
          <img class="storyImg" src="{{ asset('img/4 (2).png') }}" alt="عن الجمعية">
        </div>

        <!-- Text -->
        <div class="col-lg-6 col-md-6 col-sm-12">
          <div class="storyTop" style="background-color:  #ee5a34;">
            <h1 class="storyTitle">عن الجمعيه</h1>
            <p>
              هي منظمة خيرية غير ربحية تهدف الي دعم و مساعدة اهالي الاحياء الاكثر احتياجا.
              من خلال تقديم حلول مستدامه تعزز جودة الحياة و تلبي الاحتياجات الاساسية.
            </p>
          </div>

          <div class="row storybottom g-3">
            <div class="col-md-6 col-sm-6 col-12">
              <div class="MissionStory" style="background-color: #469e8d;">
                <h4 class="storyTitle">مهمتنا</h4>
                <p>
                  مؤسسة متخصصة في تنمية الفرد والمجتمع عن طريق دعم العوامل المساعدة
                  و إزالة العوائق التي تحول دون ذلك.
                </p>
              </div>
            </div>

            <div class="col-md-6 col-sm-6 col-12">
              <div class="MissionStory" style="background-color:#faa440 ;">
                <h4 class="storyTitle">رؤيتنا</h4>
                <p>
                  تسعى مؤسسة اكرام الخيرية لاستمرار العمل الخيري، من خلال برامجها ومشاريعها
                  الخيرية والمجتمعية لتحقيق مستقبل زاهر للمجتمع وخطط الدولة التنموية.
                </p>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>
  <!--  -->
  <!-- ============ مجالات عملنا ============ -->
  <section class="about-fields py-5">
    <div class="container">
      <div class="row justify-content-center mb-4">
        <div class="col-lg-8 text-center">
          <h1 class="fw-bold main-font mb-3 text-center">
            <span style="color:#469e8d ;">مجالات</span>
            <span style="color:#faa440 ;">عملنا </span>
          </h1>
          <p class="about-fields-subtitle mb-0">
            تعمل مؤسسة إكرام الخيرية من خلال برامج متنوعة تهدف إلى تحسين جودة حياة كبار السن
            ودعمهم نفسيًا واجتماعيًا وصحيًا، مع تعزيز مشاركة المجتمع في خدمة هذه الفئة العزيزة.
          </p>
        </div>
      </div>

      <div class="row g-4">

        <!-- المجال 1 -->
        <div class="col-md-6 col-lg-3">
          <div class="about-field-card field-orange h-100">
            <div class="about-field-icon">
              <i class="fa-solid fa-heart"></i>
            </div>
            <h3 class="about-field-title">الرعاية اليومية</h3>
            <p class="about-field-text">
              تقديم برامج وأنشطة يومية ترفيهية واجتماعية تساعد كبار السن على الشعور
              بالاندماج والراحة النفسية.
            </p>
          </div>
        </div>

        <!-- المجال 2 -->
        <div class="col-md-6 col-lg-3">
          <div class="about-field-card field-yellow h-100">
            <div class="about-field-icon">
              <i class="fa-solid fa-stethoscope"></i>
            </div>
            <h3 class="about-field-title">الدعم الصحي</h3>
            <p class="about-field-text">
              التنسيق مع الجهات الصحية لتقديم التوعية والمتابعة الطبية الأساسية
              والمحافظة على سلامة كبار السن.
            </p>
          </div>
        </div>

        <!-- المجال 3 -->
        <div class="col-md-6 col-lg-3">
          <div class="about-field-card field-green h-100">
            <div class="about-field-icon">
              <i class="fa-solid fa-people-roof"></i>
            </div>
            <h3 class="about-field-title">الدعم الأسري والاجتماعي</h3>
            <p class="about-field-text">
              مساندة الأسر في رعاية كبار السن، وتعزيز الروابط الأسرية من خلال مبادرات
              مجتمعية وشراكات فعّالة.
            </p>
          </div>
        </div>

        <!-- المجال 4 -->
        <div class="col-md-6 col-lg-3">
          <div class="about-field-card field-dark h-100">
            <div class="about-field-icon">
              <i class="fa-solid fa-hand-holding-heart"></i>
            </div>
            <h3 class="about-field-title">المبادرات التطوعية</h3>
            <p class="about-field-text">
              فتح المجال للمتطوعين للمشاركة في خدمة ورعاية كبار السن، وبناء روح المسؤولية
              الاجتماعية لدى أفراد المجتمع.
            </p>
          </div>
        </div>

      </div>
    </div>
  </section>
    <!--  -->
@endsection