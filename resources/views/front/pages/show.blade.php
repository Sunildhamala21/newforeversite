@extends('layouts.front_inner')
@section('title', $page->name)

@section('content')
    <x-hero :title="$page->name" :image_url="$page->largeImageUrl" />

    @if ($contents)
        <section class="container grid gap-10 py-20 lg:grid-cols-3">
            <div>
                <div class="sticky p-6 rounded-lg top-32 bg-light">
                    <h2 class="mb-4 text-lg font-semibold text-primary font-display">In this article</h2>
                    <div class="prose prose-a:no-underline">
                        {!! $contents !!}
                    </div>
                </div>
            </div>
            <div class="lg:col-span-2">
                <div class="prose prose-headings:text-primary">
                    {!! $body !!}
                </div>
            </div>
        </section>
    @else
        <div class="container py-20">
            <div class="mx-auto prose">
                {!! $page->description !!}
            </div>
        </div>
    @endif

    <!--<section class="hero-second">-->
    <!--  <div class="slide" style="background-image: url({{ $page->imageUrl ?? '' }})">-->
    <!--  </div>-->
    <!--  <div class="hero-bottom">-->
    <!--    <div class="container">-->
    <!--      <h1>{{ $page->name ?? '' }}</h1>-->
    <!--      <nav aria-label="breadcrumb">-->
    <!--        <ol class="breadcrumb">-->
    <!--          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>-->
    <!--          <li class="breadcrumb-item active" aria-current="page">{{ $page->name }}</li>-->
    <!--        </ol>-->
    <!--      </nav>-->
    <!--    </div>-->
    <!--</section>-->

    <!--<section class="tour-details">-->
    <!--  <div class="container mt-2">-->
    <!--    <div class="row">-->
    <!--      <div class="col-md-8 col-lg-9">-->
    <!--        <div class="tour-details-section">-->
    <!--        	<div>-->
    <!--        		<?= $page->description ?? '' ?>-->
    <!--        	</div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--      <div class="col-md-4 col-lg-3">-->
    <!--        <aside>-->
    <!-- enquiry block -->
    <!--          @include('front.elements.enquiry')-->
    <!-- end of enquiry block -->
    <!--        </aside>-->
    <!--      </div>-->
    <!--    </div>-->
    <!--</section>-->
@endsection
