<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" @if( app()->isLocale('ar') ) dir="ltr" @endif >

<x-site.layouts.header />

<body>

    @include('site.external.layouts.menus')


    @include('site.layouts.message')

    @yield('content')

    {{-- <x-site.layouts.footer /> --}}

    <footer class="custom-footer">
      <div class="row">
        <div class="col-12 text-center py-3">
          جميع الحقوق محفوظة 2025 &#169; <a href="https://www.hololnet.com/">Hulul</a>
        </div>
      </div>
    </footer>

    @include('site.layouts.script')

</body>
</html>
