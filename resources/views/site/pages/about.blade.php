@extends('site.app')

@section('content')

  <!-- ============ من نحن ============ -->
  <section class="story-section">
    <div class="container">
      <div class="row align-items-center g-4">
        <!-- Image -->
        <div class="col-lg-6 col-md-6 col-sm-12">
          @if(@$about?->image)
            <img class="storyImg" src="{{ getImage($about->image) }}" alt="{{ @$about?->title }}">
          @else
            <img class="storyImg" src="{{ asset('img/4 (2).png') }}" alt="عن الجمعية">
          @endif
        </div>

        <!-- Text -->
        <div class="col-lg-6 col-md-6 col-sm-12">
          <div class="storyTop" style="background-color: #ee5a34;">
            <h1 class="storyTitle">{{ @$about?->title ?? 'عن الجمعية' }}</h1>
            <p>{!! @$about?->description ?? '' !!}</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="about-mvv py-5">
    <div class="container">
      <div class="row g-4">

        <div class="col-md-4">
          <div class="mvv-card h-100" style="background-color: #469e8d;">
            <div class="mvv-icon">
              <i class="fa-solid fa-bullseye"></i>
            </div>
            <h4 class="mvv-title">{{ @$about?->mission_title ?? 'مهمتنا' }}</h4>
            <p class="mvv-text">{!! @$about?->mission_description ?? '' !!}</p>
          </div>
        </div>

        <div class="col-md-4">
          <div class="mvv-card h-100" style="background-color: #faa440;">
            <div class="mvv-icon">
              <i class="fa-solid fa-eye"></i>
            </div>
            <h4 class="mvv-title">{{ @$about?->vision_title ?? 'رؤيتنا' }}</h4>
            <p class="mvv-text">{!! @$about?->vision_description ?? '' !!}</p>
          </div>
        </div>

        <div class="col-md-4">
          <div class="mvv-card h-100" style="background-color: #ee5a34;">
            <div class="mvv-icon">
              <i class="fa-solid fa-gem"></i>
            </div>
            <h4 class="mvv-title">{{ @$about?->values_title ?? 'قيمنا' }}</h4>
            <p class="mvv-text">{!! @$about?->values_description ?? '' !!}</p>
          </div>
        </div>

      </div>
    </div>
  </section>

@endsection


<style>
  
  .story-section {
    padding: 60px 0;
  }
  .storyImg {
    width: 100%;
    border-radius: 15px;
    object-fit: cover;
    max-height: 400px;
  }
  .storyTop {
    padding: 30px;
    border-radius: 15px;
    color: #fff;
  }
  .storyTop .storyTitle {
    font-size: 28px;
    font-weight: bold;
    margin-bottom: 15px;
  }
  .storyTop p {
    font-size: 16px;
    line-height: 1.8;
  }

  .about-mvv {
    background-color: #f9f9f9;
  }
  .mvv-card {
    padding: 35px 25px;
    border-radius: 15px;
    color: #fff;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  .mvv-card p {
     color: #fff;
  }
  .mvv-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
  }
  .mvv-icon {
    width: 70px;
    height: 70px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    font-size: 28px;
  }
  .mvv-title {
    font-size: 22px;
    font-weight: bold;
    margin-bottom: 15px;
  }
  .mvv-text {
    font-size: 15px;
    line-height: 1.8;
    opacity: 0.95;
  }

  /* ========== Responsive ========== */
  @media (max-width: 767px) {
    .storyTop {
      margin-top: 20px;
    }
    .storyTop .storyTitle {
      font-size: 22px;
    }
    .mvv-card {
      padding: 25px 20px;
    }
  }
</style>
