
@if($showSection)
    <section class="RamdanProjects high-sales-projects mt-5">
        <div class="container pb-2 text-center">
            {{-- <p class="title">المشاريع الأكثر طلبا</p> --}}
            <h2> المشاريع الأكثر طلبا </h2>
            </br>
            <div class="Ramdan position-relative">
                <div class="swiper  projectsSlider">
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper">
                        @forelse ($projects as $key => $project)
                        <div class="swiper-slide">
                            <!-- Card with input for amount only -->
                            <livewire:site.home.requested-project :project="$project" :wire:key="$project['id']" />
                        </div>
                        @empty
                        @endforelse
                    </div>
                </div>
                <div class="swiper-button-next projectSwiper-button-next"></div>
                <div class="swiper-button-prev projectSwiper-button-prev"></div>
            </div>
        </div>
    </section>
@endif
 <!-- المركز الاعلامى -->
  <section class="media-center-section media-section " dir="rtl">
    <div class="container">
      <h2 class="media-title">
        <span class="t2 main-font">المركز</span> <span class="t1 main-font">الإعلامي</span>
      </h2>

      <div class="media-grid swiper">
        <div class="swiper-wrapper">
          <!-- Card 1 -->
          <article class=" swiper-slide media-card">
            <a href="./activities.html" class="media-link">
              <div class="media-img">
                <img src="./img/6 (1).png" alt="خبر">

              </div>

              <div class="media-body">
                <div class="media-meta">
                  <span class="media-date">2025 / 01 / 15</span>
                  <span class="media-dot"></span>
                  <span class="media-read">3 دقائق</span>
                </div>

                <h3 class="media-heading">
                  إطلاق مشروع كسوة الشتاء للعام الجديد 2025
                </h3>


              </div>
            </a>
          </article>

          <!-- Card 2 -->
          <article class="swiper-slide media-card">
            <a href="./activities.html" class="media-link">
              <div class="media-img">
                <img src="./img/3.png" alt="خبر">
              </div>

              <div class="media-body">
                <div class="media-meta">
                  <span class="media-date">2025 / 02 / 01</span>
                  <span class="media-dot"></span>
                  <span class="media-read">4 دقائق</span>
                </div>

                <h3 class="media-heading">
                  إنجازات الجمعية في شهر رمضان لأكثر من 120 ألف مستفيد
                </h3>


              </div>
            </a>
          </article>

          <!-- Card 3 -->
          <article class="swiper-slide media-card">
            <a href="./activities.html" class="media-link">
              <div class="media-img">
                <img src="./img/4 (2).png" alt="خبر">
              </div>

              <div class="media-body">
                <div class="media-meta">
                  <span class="media-date">2025 / 03 / 10</span>
                  <span class="media-dot"></span>
                  <span class="media-read">2 دقائق</span>
                </div>

                <h3 class="media-heading">
                  تقرير بالحملات الخيرية خلال النصف الأول من 2025
                </h3>

              </div>
            </a>
          </article>

          <!-- Card 1 -->
          <article class="swiper-slide media-card">
            <a href="./activities.html" class="media-link">
              <div class="media-img">
                <img src="./img/6 (1).png" alt="خبر">

              </div>

              <div class="media-body">
                <div class="media-meta">
                  <span class="media-date">2025 / 01 / 15</span>
                  <span class="media-dot"></span>
                  <span class="media-read">3 دقائق</span>
                </div>

                <h3 class="media-heading">
                  إطلاق مشروع كسوة الشتاء للعام الجديد 2025
                </h3>


              </div>
            </a>
          </article>

          <!-- Card 2 -->
          <article class="swiper-slide media-card">
            <a href="./activities.html" class="media-link">
              <div class="media-img">
                <img src="./img/3.png" alt="خبر">
              </div>

              <div class="media-body">
                <div class="media-meta">
                  <span class="media-date">2025 / 02 / 01</span>
                  <span class="media-dot"></span>
                  <span class="media-read">4 دقائق</span>
                </div>

                <h3 class="media-heading">
                  إنجازات الجمعية في شهر رمضان لأكثر من 120 ألف مستفيد
                </h3>


              </div>
            </a>
          </article>

          <!-- Card 3 -->
          <article class="swiper-slide media-card">
            <a href="./activities.html" class="media-link">
              <div class="media-img">
                <img src="./img/4 (2).png" alt="خبر">
              </div>

              <div class="media-body">
                <div class="media-meta">
                  <span class="media-date">2025 / 03 / 10</span>
                  <span class="media-dot"></span>
                  <span class="media-read">2 دقائق</span>
                </div>

                <h3 class="media-heading">
                  تقرير بالحملات الخيرية خلال النصف الأول من 2025
                </h3>

              </div>
            </a>
          </article>
        </div>

      </div>
      <div class="swiper-button-next media-section-button-next"></div>
      <div class="swiper-button-prev media-section-button-prev"></div>

      <div class="media-more-wrap">
        <a href="./activities.html" class="media-more-btn">المزيد</a>
      </div>
    </div>
  </section>