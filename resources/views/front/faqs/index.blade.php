@extends('layouts.front_inner')
@section('title', 'Frequently Asked Questions')
@section('content')
    <x-hero title="Frequently Asked Questions" />

    <section class="py-20 bg-gray-50">
        <div class="container">
            <div class="grid gap-10 lg:grid-cols-3">
                <div class="lg:col-span-2">
                    @foreach ($faq_categories as $category)
                        @if (iterator_count($category->faqs))
                            <div class="mb-8" x-data="{ active: 'none' }">
                                <h2 class="mb-2 text-2xl uppercase font-display text-primary">{{ $category->name }}</h2>
                                @foreach ($category->faqs as $key => $faq)
                                    <div class="px-2 py-3 mb-1 bg-white border-2 border-gray-100 rounded-sm lg:px-4">
                                        <button class="flex items-center justify-between w-full text-left" @click="active = (active === {{ $key }} ? 'none' : {{ $key }})">
                                            <h3 class="text-gray-500 lg:text-lg">{{ $faq->title }}</h3>

                                            <svg class="w-6 h-6 shrink-0 text-primary" x-show="active!=={{ $key }}">
                                                <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#plus" />
                                            </svg>
                                            <svg class="w-6 h-6 shrink-0 text-primary" x-show="active==={{ $key }}">
                                                <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#minus" />
                                            </svg>
                                        </button>
                                        <div class="mt-4"
                                             x-cloak
                                             x-show.transition="active==={{ $key }}">
                                            <p>
                                                <?= $faq->content ?>
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                </div>
                {{-- <aside>
                    @include('partials.enquiry')
                </aside> --}}
            </div>
        </div>

    </section>
@endsection
