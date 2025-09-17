<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ Setting::get('homePageSeo')['meta_title'] ?? '' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- meta tags --}}
    <meta name="description" content="{{ Setting::get('homePageSeo')['og_description'] ?? '' }}" />
    <meta name="keywords" content="{{ Setting::get('homePageSeo')['meta_keywords'] ?? '' }}" />
    <link rel="canonical" href="{{ url('/') }}" />
    <meta property="og:title" content="{{ Setting::get('homePageSeo')['og_title'] ?? '' }}" />
    <meta property="og:url" content="" />
    <meta property="og:site_name" content="@yield('meta_og_site_name', Setting::get('site_name') ?? '')" />
    <meta property="og:image"
        content="{{ Setting::getSiteSettingImage(Setting::get('homePageSeo')['og_image'] ?? null) }}" />
    <meta property="og:description" content="{{ Setting::get('homePageSeo')['og_description'] ?? '' }}" />
    <meta property="og:image" content="@yield('meta_og_image')" />
    <meta property="og:description" content="@yield('meta_og_description')" />
    <meta name="IndexType" content="trekking in Nepal" />
    <meta name="language" content="EN-US" />
    <meta name="type" content="Trekking" />
    <meta name="company" content="{{ config('app.name') }}" />
    <meta name="author" content="{{ config('app.name') }}" />
    <meta name="contact person" content="{{ config('app.name') }}" />
    <meta name="copyright" content="{{ config('app.name') }}" />
    <meta name="security" content="public" />
    <meta content="all" name="robots" />
    <meta name="document-type" content="Public" />
    <meta name="category" content="Trekking in Nepal" />
    <meta name="robots" content="all,index" />
    <meta name="googlebot" content="INDEX, FOLLOW" />
    <meta name="YahooSeeker" content="INDEX, FOLLOW" />
    <meta name="msnbot" content="INDEX, FOLLOW" />
    <meta name="allow-search" content="Yes" />
    {{-- end of meta tags --}}

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

    {{-- Css files --}}
    @vite('resources/css/app.css')

    @stack('styles')

    @if (Setting::get('thirdParty'))
        {!! Setting::get('thirdParty')['google_analytics'] !!}
    @endif

    {{-- Schema --}}
    @php
        $orgReviews = [];
        foreach ($reviews as $review) {
            $orgReviews[] = Spatie\SchemaOrg\Schema::review()
                ->author(Spatie\SchemaOrg\Schema::person()->name($review->review_name))
                ->reviewBody($review->review)
                ->reviewRating(
                    Spatie\SchemaOrg\Schema::rating()
                        ->ratingValue(strip_tags($review->rating))
                        ->bestRating(5)
                        ->worstRating(1),
                );
        }
    @endphp
    <?php
    $organization = Spatie\SchemaOrg\Schema::Organization()->name(Setting::get('site_name'))->url(url('/'))->logo(asset('assets/front/img/logo.webp'))->email(Setting::get('email'))->telephone(Setting::get('telephone'))->address(Setting::get('address'));
    $lb = Spatie\SchemaOrg\Schema::LocalBusiness()
        ->name(Setting::get('site_name'))
        ->url(url('/'))
        ->email(Setting::get('email'))
        ->telephone(Setting::get('telephone'))
        ->address(Setting::get('address'))
        ->aggregateRating(
            Spatie\SchemaOrg\Schema::aggregateRating()
                ->ratingValue($avg_rating ?? 5)
                ->reviewCount($reviews_count ?? 1),
        )
        ->review($orgReviews);
    
    if (isset($banners[0])) {
        $organization->image($banners[0]->imageUrl);
        $lb->image($banners[0]->imageUrl);
    }
    if (Setting::get('homePageSeo')) {
        $organization->description(Setting::get('homePageSeo')['og_description']);
    }
    ?>
    {!! $organization->toScript() !!}
    {!! $lb->toScript() !!}

</head>

<body class="text-gray-700 font-body" x-data="{ searchboxOpen: false, mobilenavOpen: false }">

    @include('front.elements.header')

    <div id="topIO"></div>

    @yield('content')

    @include('front.elements.footer')

    {{-- Scripts --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    @stack('scripts')
    @vite(['resources/js/app.js'])

</body>

</html>
