@php
$settings = App\Charity\Settings\SettingSingleton::getInstance();
@endphp
@if ($settings->getItem('show_slider'))


  <!-- Header Section -->
  <header class="hero-section" dir="ltr">
    <div class="pattern-section d-none d-lg-block">
      <img src="./img/1.png" alt="زخارف" class="pattern-img">
    </div>

    <div class="container-fluid">
      <div class="row align-items-center hero-row">

        <div class="col-lg-2 col-md-1 d-none d-md-block"></div>
         @forelse ($slides as $key => $slide)

        <div class="col-lg-6 col-md-5 col-12 hero-img-col text-center">
          <img src="{{ asset(getImage($slide->image) ?? 'site/img/bannerBG.png') }}" alt="كبار السن" class="img-fluid rounded-4 main-image">
        </div>
            @empty
            @endforelse

        <div class="col-lg-4 col-md-6 col-12 content-section">
          <div class="content-wrapper">

            <div class="logo-container mb-4 d-none d-lg-block">
              <img src="{{ asset(getImage($settings->getItem('logo')) ?? site_path('img/logo.png')) }}" alt="جمعية إكرام المسنين" class="logo-img">
            </div>

            <p class="description second-font">
              @if (@$slide->trans?->where('locale', $current_lang)->first()->description)
                                    {{ @$slide->trans?->where('locale', $current_lang)->first()->description }}
                                @endif
            </p> 

            <a href="{{ route('site.about-us.index') }}" class="btn btn-outline-light btn-lg second-font cta-button">
              ماذا قالوا عنا ؟؟
            </a>

            <div class="stars-decoration">
              <span class="star star-1">✦</span>
              <span class="star star-2">✦</span>
            </div>

          </div>
        </div>

      </div>
    </div>
  </header>
  


@endif

