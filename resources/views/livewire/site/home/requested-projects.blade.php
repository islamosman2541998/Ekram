
@if($showSection)
    <section class="RamdanProjects high-sales-projects mt-5">
        <div class="container pb-2 text-center">
            <h2 class="fs-1 fw-bold main-font"> 
                <span style="color:#469e8d ;"> المشاريع</span>
                <span style="color:#faa440 ;"> الأكثر طلبا</span>
            </h2>
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
