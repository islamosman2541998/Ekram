<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'إتمام الدفع')</title>
    
    {{-- CSS بتاع السايت --}}
    <link rel="stylesheet" href="{{ asset('site/css/app.css') }}">
    
    {{-- Moyasar CSS --}}
    <link rel="stylesheet" href="https://cdn.moyasar.com/mpf/1.7.3/moyasar.css">
    
    @stack('css')
</head>
<body>
    {{-- Header بسيط بدون Livewire --}}
    <div style="padding:15px; background:#fff; border-bottom:1px solid #eee; text-align:center;">
        <img src="{{ site_path('img/logo.png') }}" height="50" alt="Logo">
    </div>

    @yield('content')


<    
    @stack('js')
</body>
</html>