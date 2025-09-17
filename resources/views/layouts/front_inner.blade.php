<!DOCTYPE html>
<html lang="en-US" class="scroll-pt-40">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        @hasSection('meta_og_title')
            @yield('meta_og_title')
        @else
            @yield('title')
        @endif
    </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- meta tags --}}
    <meta name="description" content="@yield('meta_description')" />
    <meta name="keywords" content="@yield('meta_keywords')" />
    <link rel="canonical"
        href="{{ request()->routeIs('home') ? config('app.url') : config('app.url') . '/' . request()->path() }}" />
    <meta property="og:title" content="@yield('meta_og_title')" />
    <meta property="og:url" content="@yield('meta_og_url')" />
    <meta property="og:site_name" content="@yield('meta_og_site_name', Setting::get('site_name') ?? '')" />
    <meta property="og:image" content="@yield('meta_og_image')" />
    <meta property="og:description" content="@yield('meta_og_description')" />

    {{-- end of meta tags --}}
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    {{-- fonts --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,600;1,400&family=Roboto+Condensed:wght@600&family=Solitreo&display=swap"
        rel="stylesheet">

    @vite('resources/css/app.css')

    @stack('styles')

    @if (Setting::get('thirdParty'))
        {!! Setting::get('thirdParty')['google_analytics'] !!}
    @endif
    @stack('schema')
</head>

<body class="text-gray-700 font-body" x-data="{ showModal: false, searchboxOpen: false, mobilenavOpen: false }">

    <!-- Header -- Topbar & Navbar-->
    @include('front.elements.header')
    {{-- end of header --}}

    <div id="topIO"></div>

    @yield('content')

    <!-- Footer -->
    @include('front.elements.footer')
    {{-- end of footer --}}

    @vite(['resources/js/app.js'])
    <script src="{{ asset('assets/vendors/jquery-validation/dist/jquery.validate.min.js') }}" defer></script>
    <script src="{{ asset('assets/vendors/jquery-validation/dist/additional-methods.min.js') }}" defer></script>

    @stack('scripts')

</body>

</html>
