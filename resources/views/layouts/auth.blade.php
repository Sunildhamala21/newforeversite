<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>

    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    {{-- fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,600;1,400&family=Roboto+Condensed:wght@600&family=Solitreo&display=swap"
        rel="stylesheet">
    {{-- Css files --}}
    @vite('resources/css/app.css')

    @stack('styles')
    @if (Setting::get('thirdParty'))
        {!! Setting::get('thirdParty')['google_analytics'] !!}
    @endif

</head>

<body class="font-body" x-data="{ searchboxOpen: false, mobilenavOpen: false }">

    @include('front.elements.header')

    <div id="topIO"></div>

    @yield('content')

    {{-- Scripts --}}
    @stack('scripts')
    @vite(['resources/js/app.js'])
</body>

</html>
