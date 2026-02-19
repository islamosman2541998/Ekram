
 
  <footer>
    <div class="row">

      <!-- عن الجمعية -->
      <div class="col-12 col-lg-4 p-0">
        <div class="first p-3 h-100">
          <div class="footer-text">
            <div class="ImgContainer d-flex justify-content-between align-items-center">
              <img src="{{ asset(getImage($settings->getItem('logo'))) }}" class="img-fluid footerimg" alt="" />

            </div>
            <h2 class="first-title">عــن الجمعية</h2>
            <p class="first-text">
              {{ $settings->getItem('footer_description') }}
            </p>
          </div>

          <div class="socialIncons d-flex justify-content-center align-items-center mt-4">
             @if( $settings->getContactInformationData('instagram'))
                    <a class="icon" href="{{ $settings->getContactInformationData('instagram') }}">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    @endif

                    @if( $settings->getContactInformationData('instagram'))
                    <a class="icon" href="{{ $settings->getContactInformationData('facebook') }}">
                        <i class="fa-brands fa-facebook"></i>
                    </a>
                    @endif

                    @if( $settings->getContactInformationData('youtube'))
                    <a class="icon" href="{{ $settings->getContactInformationData('youtube') }}">
                        <i class="fa-brands fa-youtube"></i>
                    </a>
                    @endif

                    @if( $settings->getContactInformationData('twitter'))
                    <a class="icon" href="{{ $settings->getContactInformationData('twitter') }}">
                        <i class="fa-brands fa-x-twitter"></i>
                    </a>
                    @endif

                    @if( $settings->getContactInformationData('snapchat'))
                    <a class="icon" href="{{ $settings->getContactInformationData('snapchat') }}">
                        <i class="fa-brands fa-snapchat"></i>
                    </a>
                    @endif

                    @if( $settings->getContactInformationData('whatsapp'))
                    <a class="icon" href="{{ $settings->getContactInformationData('whatsapp') }}">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                    @endif
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-4 p-0">
        <div class="secand p-3 h-100 text-center">
          <h5>أهم الروابط :</h5>
          <ul class="list-unstyled mt-3">
              @forelse($menus as $key => $menu)
                    @if ($menu->type == App\Enums\MunesEnum::DYNAMIC)
                    <li> <a class="title_footer" href="{{ App::make('url')->to($menu->dynamic_url) }}">{{ $menu->title }}</a> </li>

                    @elseif ($menu->type == App\Enums\MunesEnum::STATIC)
                    <li> <a class="title_footer" href="{{ App::make('url')->to($menu->url) }}">{{ $menu->title }}</a></li>
                    @endif
                    @empty
                    @endforelse
          </ul>
        </div>
      </div>

      <!-- معلومات الاتصال -->
      <div class="col-12 col-lg-4 p-0 four">
        <div class="fourth d-flex flex-column align-items-center h-100 p-3">
          <h2 class="fourth-title mb-3">معلومات الاتصال</h2>

          <div class="fristrow d-flex justify-content-center gap-3">
               @if ($settings->getContactInformationData('mobile'))
                    <a class="contact" href="tel:{{ $settings->getContactInformationData('mobile') }}">
                        <span>{{ $settings->getContactInformationData('mobile') }}</span>
                        <i class="fa-solid fa-phone"></i>
                    </a>
                    @endif
                    @if ($settings->getContactInformationData('phone'))
                    <a class="contact" href="https://wa.me/{{ $settings->getContactInformationData('phone') }}">
                        <span>{{ $settings->getContactInformationData('phone') }}</span>
                        <i class="fa-solid  fa-blender-phone"></i>
                    </a>
                    @endif
          </div>

          <div class="Secandrow my-3">
                  <a class="contact" href="mailto:{{ $settings->getContactInformationData('email') }}" class="d-inline-block">
                        <span>
                            {{ $settings->getContactInformationData('email') }}
                        </span>
                        <i id="email-icon" class="fa-solid fa-envelope"></i>
                    </a>
          </div>

          <div class="ImgContainer2 d-flex justify-content-center align-items-center mt-2" style="    display: flex !important;
            gap: 2rem;">
            <img src="{{ asset('img/pay-1.png') }}" class="img-fluid imgg" alt="" />
            <img src="{{ asset('img/pay-2.png') }}" class="img-fluid imgg" alt="" />
            <img src="{{ asset('img/pay-4.png') }}" class="img-fluid imgg" alt="" />
          </div>
        </div>
      </div>

    </div>

    <img src="{{ asset('img/1.jpg') }}" style="height:4rem;width:100%;object-fit:cover;">
  </footer>