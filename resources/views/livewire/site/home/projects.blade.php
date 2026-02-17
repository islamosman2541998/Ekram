@if ($showSection)
    <section class="RamdanProjects mt-5">
        <div class="container pb-2 text-center">
            <h1 class="fw-bold main-font mb-3">
                <span style="color:#469e8d ;">مشاريع </span>
                <span style="color:#faa440 ;"> متنوعة</span>
            </h1>
            </br>
            <div class="Ramdan position-relative">
                <div class="swiper RamdanProjectSwiper">
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper">
                        @forelse ($projects as $key => $project)
                            <div class="swiper-slide swiperMargin">
                                <!-- Card with input for amount only -->
                                <livewire:site.home.project :project="$project" :wire:key="$project['id']" />
                            </div>
                        @empty
                        @endforelse
                    </div>

                </div>
                <div class="swiper-button-next RamdanProject-button-next"></div>
                <div class="swiper-button-prev RamdanProject-button-prev"></div>
            </div>
        </div>
        @livewire('site.carts.add-modal')
    </section>
@endif



