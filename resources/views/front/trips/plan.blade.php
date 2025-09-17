<?php
if (session()->has('success_message')) {
    $session_success_message = session('success_message');
    session()->forget('success_message');
}

if (session()->has('error_message')) {
    $session_error_message = session('error_message');
    session()->forget('error_message');
}
$all_selected_destinations = '';

if (isset($selected_destinations) && !empty($selected_destinations)) {
    $all_selected_destinations = $selected_destinations;
}

$selected_trip_id = '';
$selected_trip_name = '';
$selected_trip_duration = '';
if (isset($trip) && !empty($trip)) {
    $selected_trip_id = $trip->id;
    $selected_trip_name = $trip->name;
    $selected_trip_duration = $trip->duration;
}
?>

@push('styles')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('assets/front/css/front-search-slider.css') }}">
    <style>
        .step {
            flex-basis: 120px;
        }

        .step:not(:first-child)::before {
            content: '';
            position: absolute;
            top: 1.3rem;
            right: 50%;
            width: 100%;
            height: .5rem;
            background-color: #f0f8ff;
            z-index: -1;
        }

        .step.active:not(:first-child)::before {
            background-color: var(--color-accent);
        }

        .step .step-bg {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 3rem;
            height: 3rem;
            background-color: #f0f8ff;
            border-radius: 100%;
        }

        .step.active .step-bg {
            background-color: var(--color-primary);
        }

        .step.active img {
            filter: brightness(10);
        }

        .radio-input,
        .radio-input-compact,
        .check-input {
            opacity: 0;
            position: absolute;
        }

        .radio-input+label {
            position: relative;
            display: flex;
            gap: 1rem;
            align-items: center;
            padding: 1rem 1rem;
            background-color: #f0f8ff;
            cursor: pointer;
        }

        .radio-input+label.col {
            gap: .5rem;
            flex-direction: column;
        }

        .radio-input+label:hover {
            background-color: #d6e0f5;
        }

        .radio-input:checked+label {
            background-color: var(--color-primary);
            color: white;
        }

        .radio-input:checked+label img {
            filter: brightness(6);
        }

        .radio-input-compact+label {
            position: relative;
            display: flex;
            gap: 1rem;
            align-items: center;
            padding: 1rem;
            background-color: #f0f8ff;
            cursor: pointer;
        }

        .radio-input-compact+label svg {
            color: #8080e0;
        }

        .radio-input-compact+label.col {
            gap: .5rem;
            flex-direction: column;
        }

        .radio-input-compact+label:hover {
            background-color: #d6e0f5;
        }

        .radio-input-compact:checked+label {
            background-color: var(--color-primary);
            color: white;
        }

        .radio-input-compact+label .check {
            fill: #8080e0;
            opacity: 0;
        }

        .radio-input-compact:checked+label .check {
            opacity: 1;
        }

        .check-input+label {
            position: relative;
            display: flex;
            gap: 1rem;
            align-items: center;
            padding: 1rem;
            background-color: #f0f8ff;
            cursor: pointer;
            border-radius: 4px;
        }

        .check-input+label.label-sm {
            background-color: #ffffff;
            padding: 4px 10px;
            border: 1px solid #cbcbe9;
        }

        .check-input+label.col {
            gap: .5rem;
            flex-direction: column;
        }

        .check-input+label:hover {
            background-color: #d6e0f5;
        }

        .check-input:checked+label {
            background-color: var(--color-primary);
            color: white;
        }

        .check-input+label .check {
            fill: #8080e0;
            opacity: 0;
        }

        .check-input:checked+label .check {
            opacity: 1;
        }

        #stepForm>div {
            display: none;
        }

        #stepForm>div:first-of-type {
            display: block;
        }
    </style>
@endpush

@extends('layouts.front_inner')

@section('title', 'Plan My Trip')
@section('content')
    <!-- Hero -->
    <section class="relative">
        <img src="{{ asset('assets/front/img/hero.jpg') }}" alt="" class="object-cover w-full h-36">
        <div class="absolute bottom-0 w-full text-white bg-linear-to-t from-black/40 to-black/0">
            <div class="container py-4">
                <h1 class="mb-2 text-3xl font-semibold lg:text-4xl">Plan My Trip</h1>
                <nav aria-label="breadcrumb">
                    <ol class="flex flex-wrap gap-2">
                        <li class=""><a href="{{ url('/') }}">Home</a></li> /
                        <li class="active" aria-current="page">Plan My Trip</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    <section class="py-20" x-data="{ currentStep: 1 }">
        <div class="grid max-w-6xl gap-20 px-4 mx-auto">

            {{-- Progress --}}
            <div id="step-block" class="hidden max-w-4xl grid-cols-6 mx-auto text-sm text-gray-400 lg:grid">
                {{-- Mark each step as active if it is complete or current --}}
                <button id="step-where" class="relative flex flex-col items-center grow shrink-0 gap-2 step active">
                    <div class="step-bg"><img src="{{ asset('assets/front/img/where.svg') }}" alt=""
                            class="object-contain w-8 h-8"></div>Destination
                </button>
                <button id="step-when" class="relative flex flex-col items-center grow shrink-0 gap-2 step">
                    <div class="step-bg"><img src="{{ asset('assets/front/img/when.svg') }}" class="object-contain w-8 h-8"
                            alt="">
                    </div>Dates
                </button>
                <button id="step-who" class="relative flex flex-col items-center grow shrink-0 gap-2 step">
                    <div class="step-bg"><img src="{{ asset('assets/front/img/couple.svg') }}"
                            class="object-contain w-8 h-8" alt="">
                    </div>Travelers
                </button>
                <button id="step-accomodation" class="relative flex flex-col items-center grow shrink-0 gap-2 step">
                    <div class="step-bg"><img src="{{ asset('assets/front/img/accommodation.svg') }}" alt=""
                            class="object-contain w-8 h-8"></div>
                    Accommodation
                </button>
                <button id="step-budget" class="relative flex flex-col items-center grow shrink-0 gap-2 step">
                    <div class="step-bg"><img src="{{ asset('assets/front/img/budget.svg') }}" alt=""
                            class="object-contain w-8 h-8"></div>Budget
                </button>
                <button id="step-tailor-made" class="relative flex flex-col items-center grow shrink-0 gap-2 step">
                    <div class="step-bg"><img src="{{ asset('assets/front/img/tailor-made.svg') }}" alt=""
                            class="object-contain w-8 h-8"></div>Tailor-made
                    tour
                </button>
            </div>

            {{-- Form --}}
            <form id="stepForm">

                {{-- Where --}}
                <div id="step3" class="grid gap-8">
                    <fieldset>
                        <legend class="mb-8 text-lg text-center lg:text-xl">Where do you want to go? <span
                                class="text-red">*</span></legend>
                        <div class="grid gap-8 mb-8 sm:grid-cols-2 md:grid-cols-3">
                            @forelse ($destinations as $destination)
                                <div>
                                    <input type="checkbox" id="{{ $destination->name }}" name="destination[]"
                                        value="{{ $destination->id }}" class="check-input destination-checkbox">
                                    <label for="{{ $destination->name }}">
                                        <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                                            aria-hidden="true" class="w-6 h-6">
                                            <rect x="0" y="0" width="20" height="20" fill="white"
                                                stroke="currentColor" />
                                            <path class="check" clip-rule="evenodd" fill-rule="evenodd"
                                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z">
                                            </path>
                                        </svg>
                                        {{ $destination->name }}
                                    </label>
                                </div>
                            @empty
                            @endforelse
                        </div>

                        <div class="flex items-center gap-4">
                            <input type="checkbox" id="not-sure" name="destination[]" value="not-sure" class="rounded-xs">
                            <label for="not-sure">
                                I am not sure!
                            </label>
                        </div>
                        <div id="destination-error"></div>
                    </fieldset>

                    <fieldset class="mt-10" id="trip-interested-block">
                        <legend class="mb-10 text-center">Choose the trips you are interested in.</legend>
                        <div class="flex">
                            <div class="relative">
                                <input type="text" id="keyword" class="border border-primary rounded w-64"
                                    placeholder="Search Trips">
                                <x-icon-magnifying-glass-fill class="absolute right-2 size-6 top-2 text-primary/20" />
                            </div>
                        </div>
                        <div id="trips-block" class="grid gap-4 sm:grid-cols-2 md:grid-cols-4 mt-4">
                        </div>
                        <div id="trip-interested-error"></div>
                        <div class="flex items-center" style="justify-content: center; margin-top: 50px;">
                            <div id="spinner-block"></div>
                            <button id="show-more"
                                class="inline-block px-4 py-2 text-sm tracking-wide text-gray-700 rounded-lg bg-sky-200 hover:bg-sky-300"
                                style="display: none;">Show more</button>
                        </div>
                    </fieldset>
                </div>

                {{-- When --}}
                <div id="step2" class="grid gap-8" x-data="{ when: null }">
                    <fieldset>
                        <legend class="mb-8 text-lg text-center lg:text-xl">When are you planning to begin your trip? <span
                                class="text-red">*</span>
                        </legend>
                        <div class="grid gap-8 sm:grid-cols-2 md:grid-cols-3">
                            <div>
                                <input type="radio" id="exact-date" x-model="when" name="when" value="exact"
                                    class="radio-input">
                                <label for="exact-date">
                                    <img src="{{ asset('assets/front/img/exact-date.svg') }}" class="h-12"
                                        alt="">
                                    I have exact dates.
                                </label>
                            </div>

                            <div>
                                <input type="radio" id="approx-date" x-model="when" name="when" value="approx"
                                    class="radio-input">
                                <label for="approx-date">
                                    <img src="{{ asset('assets/front/img/approx-date.svg') }}" class="h-12"
                                        alt="">
                                    I have approximate dates.
                                </label>
                            </div>

                            <div>
                                <input type="radio" id="decide-later" x-model="when" name="when" value="later"
                                    class="radio-input">
                                <label for="decide-later">
                                    <img src="{{ asset('assets/front/img/decide-later.svg') }}" class="h-12"
                                        alt="">
                                    I will decide later.
                                </label>
                            </div>
                        </div>
                        <div id="when-error"></div>
                    </fieldset>

                    <div class="flex flex-wrap gap-8">
                        <div class="form-group" x-cloak x-show="when==='exact'">
                            <label for="arrival-date">
                                Arrival date <span class="text-red">*</span>
                            </label>
                            <input type="date" name="arrival_date" id="arrival-date">
                        </div>
                        {{-- <div class="form-group" x-cloak x-show="when ==='exact'">
                            <label for="departure-date">
                                Departure date <span class="text-red">*</span>
                            </label>
                            <input type="date" name="departure_date" id="departure-date">
                        </div> --}}
                        <div class="form-group" x-cloak x-show="when ==='approx'">
                            <label for="approx-month">
                                Select month <span class="text-red">*</span>
                            </label>
                            <input type="month" name="month" id="approx-month">
                        </div>
                    </div>
                </div>

                {{-- Who --}}
                <div id="step1" x-data="{ who: null }">
                    <div class="grid gap-8 py-10">
                        <fieldset>
                            <legend class="mb-8 text-lg text-center lg:text-xl">Who are you traveling with? <span
                                    class="text-red">*</span></legend>
                            <div class="grid grid-cols-2 gap-8 md:grid-cols-4">
                                <div>
                                    <input type="radio" id="solo" x-model="who" name="who" value="solo"
                                        class="radio-input">
                                    <label class="justify-center" for="solo">
                                        <img src="{{ asset('assets/front/img/single.svg') }}" class="h-12"
                                            alt="">
                                        Single
                                    </label>
                                </div>
                                <div>
                                    <input type="radio" id="couple" x-model="who" name="who" value="couple"
                                        class="radio-input">
                                    <label class="justify-center" for="couple">
                                        <img src="{{ asset('assets/front/img/couple.svg') }}" class="h-12"
                                            alt="">
                                        Couple
                                    </label>
                                </div>
                                <div>
                                    <input type="radio" id="family" x-model="who" name="who" value="family"
                                        class="radio-input">
                                    <label class="justify-center" for="family">
                                        <img src="{{ asset('assets/front/img/family.svg') }}" class="h-12"
                                            alt="">
                                        Family
                                    </label>
                                </div>
                                <div>
                                    <input type="radio" id="group" x-model="who" name="who" value="group"
                                        class="radio-input">
                                    <label class="justify-center" for="group">
                                        <img src="{{ asset('assets/front/img/group.svg') }}" class="h-12"
                                            alt="">
                                        Group
                                    </label>
                                </div>
                            </div>
                            <div id="who-error" class="mt-4 text-sm text-red-600"></div>
                        </fieldset>
                        <div class="flex flex-wrap justify-center gap-8" x-cloak
                            x-show="who==='family' || who ==='group'">
                            <div class="form-group">
                                <label for="adults">
                                    No. of adults
                                </label>
                                <select id="adults" name="no_of_adults" class="form-control">
                                    <option selected>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                    <option>7</option>
                                    <option>8</option>
                                    <option>9</option>
                                    <option>10</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="children">
                                    No. of children
                                </label>
                                <select id="children" name="no_of_children" class="form-control">
                                    <option selected>0</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                    <option>7</option>
                                    <option>8</option>
                                    <option>9</option>
                                    <option>10</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Accomodation --}}
                <div id="step4" class="grid gap-8 py-10">
                    <fieldset>
                        <legend class="mb-8 text-lg text-center lg:text-xl">What kind of accomodation do you want? <span
                                class="text-red">*</span></legend>
                        <div class="grid grid-cols-2 gap-8 md:grid-cols-4">
                            <div>
                                <input type="radio" id="basic" name="accomodation" value="solo"
                                    class="radio-input">
                                <label class="col" for="basic">
                                    <img src="{{ asset('assets/front/img/basic.svg') }}" class="h-12 " alt="">
                                    Basic
                                </label>
                            </div>

                            <div>
                                <input type="radio" id="luxury" name="accomodation" value="family"
                                    class="radio-input">
                                <label class="col" for="luxury"><img
                                        src="{{ asset('assets/front/img/luxury.svg') }}" class="h-12 " alt="">
                                    Luxury
                                </label>
                            </div>

                            <div>
                                <input type="radio" id="camping" name="accomodation" value="family"
                                    class="radio-input">
                                <label class="col" for="camping">
                                    <img src="{{ asset('assets/front/img/camping.svg') }}" class="h-12 "
                                        alt="">
                                    Camping
                                </label>
                            </div>

                            <div>
                                <input type="radio" id="self-booking" name="accomodation" value="family"
                                    class="radio-input">
                                <label class="col" for="self-booking">
                                    <img src="{{ asset('assets/front/img/self-booking.svg') }}" class="h-12 "
                                        alt="">
                                    Self booking
                                </label>
                            </div>
                        </div>
                        <div id="accomodation-error"></div>
                    </fieldset>
                </div>

                {{-- Budget --}}
                <div id="step5" class="grid gap-8 py-10">
                    <fieldset>
                        <legend class="mb-4 text-lg text-center">Budget range (per person) <span class="text-red">*</span>
                        </legend>
                        <div class="max-w-md mx-auto custom-slider-container">
                            <div id="slider-range"></div>
                            <input
                                class="block mx-auto text-lg font-semibold text-center border-0 price-range-input text-primary"
                                type="text" id="amount" name="amount" readonly value="$0 - $10,000">
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend class="mb-4 text-lg text-center">Is your budget flexible?
                            <span class="text-red">*</span>
                        </legend>
                        <div class="grid gap-8 lg:grid-cols-2">
                            <div>
                                <input type="radio" id="flexible" name="flexible" value="flexible"
                                    class="radio-input">
                                <label for="flexible">
                                    <img src="{{ asset('assets/front/img/flexible-budget.svg') }}" class="h-12"
                                        alt="">
                                    Yes, it is flexible. Plan the best trip for me.
                                </label>
                            </div>

                            <div>
                                <input type="radio" id="not-flexible" name="flexible" value="not_flexible"
                                    class="radio-input">
                                <label for="not-flexible">
                                    <img src="{{ asset('assets/front/img/fixed-budget.svg') }}" class="h-12"
                                        alt="">
                                    No, plan my trip according to my budget.
                                </label>
                            </div>
                        </div>
                        <div id="flexible-error"></div>
                    </fieldset>
                </div>

                {{-- Tailor-made tour --}}
                <div id="step6" class="grid gap-8 py-10">
                    <fieldset>
                        <legend class="mb-2">Trip type you are looking for<span class="text-red">*</span>
                        </legend>
                        <div class="flex gap-1">
                            <div>
                                <input type="radio" id="tailor-made" name="trip_type" value="tailor-made"
                                    class="radio-input-compact">
                                <label for="tailor-made">
                                    <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                                        aria-hidden="true" class="w-6 h-6">
                                        <circle cx="10" cy="10" r="9" fill="white"
                                            stroke="currentColor" />
                                        <circle cx="10" cy="10" r="6" class="check" />
                                    </svg>
                                    Personal tailor-made trip
                                </label>
                            </div>

                            <div>
                                <input type="radio" id="type-group" name="trip_type" value="group"
                                    class="radio-input-compact">
                                <label for="type-group">
                                    <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                                        aria-hidden="true" class="w-6 h-6">
                                        <circle cx="10" cy="10" r="9" fill="white"
                                            stroke="currentColor" />
                                        <circle cx="10" cy="10" r="6" class="check" />
                                    </svg>
                                    Group trips
                                </label>
                            </div>
                        </div>
                        <div id="trip-type-error"></div>
                    </fieldset>

                    <fieldset>
                        <legend class="mb-2">Current phase of trip planning<span class="text-red">*</span>
                        </legend>
                        <div class="flex flex-wrap gap-1">
                            <div>
                                <input type="radio" id="planning" name="plan_phase" value="planning"
                                    class="radio-input-compact">
                                <label for="planning">
                                    <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                                        aria-hidden="true" class="w-6 h-6">
                                        <circle cx="10" cy="10" r="9" fill="white"
                                            stroke="currentColor" />
                                        <circle cx="10" cy="10" r="6" class="check" />
                                    </svg>
                                    I am still planning on my trip.
                                </label>
                            </div>

                            <div>
                                <input type="radio" id="ready" name="plan_phase" value="ready"
                                    class="radio-input-compact">
                                <label for="ready">
                                    <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                                        aria-hidden="true" class="w-6 h-6">
                                        <circle cx="10" cy="10" r="9" fill="white"
                                            stroke="currentColor" />
                                        <circle cx="10" cy="10" r="6" class="check" />
                                    </svg>
                                    I am ready to start.
                                </label>
                            </div>
                        </div>
                        <div id="plan-phase-error"></div>
                    </fieldset>

                    <div class="grid gap-8 lg:grid-cols-2">
                        <div>
                            <label for="additional-queries" class="mb-2">
                                Do you have any additional queries?
                            </label>
                            <div class="form-group">
                                <textarea id="additional-queries" name="additional_queries" class="form-control"></textarea>
                            </div>
                        </div>
                        <div>
                            <label for="departure-date" class="mb-2">
                                How did you hear about us? <span class="text-red">*</span>
                            </label>
                            <div class="form-group">
                                <select id="departure-date" name="reached_by" class="form-control">
                                    <option value="">Select One</option>
                                    <option value="Internet Search">Internet Search</option>
                                    <option value="Blog">Blog</option>
                                    <option value="Facebook">Facebook</option>
                                    <option value="Instagram">Instagram</option>
                                    <option value="Twitter">Twitter</option>
                                    <option value="Trip Advisor">Trip Advisor</option>
                                    <option value="Friend Recommendation">Friend Recommendation</option>
                                    <option value="Newspaper Article">Newspaper Article</option>
                                    <option value="Club/Association">Club/Association</option>
                                    <option value="Lonely Planet Guides">Lonely Planet Guides</option>
                                    <option value="Online Advertising">Online Ads</option>
                                    <option value="Past Client">Past Client</option>
                                    <option value="Trek Leader/Staff Recommended">Trek Leader/Staff Recommended</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Personal Information --}}
                <div id="step7" class="grid gap-8 py-10">
                    <h2 class="text-lg lg:text-2xl">PERSONAL INFORMATION</h2>
                    <p>Please fill in the form below. Our customer support will get back to you as soon as possible.</p>
                    <div class="grid gap-8 lg:grid-cols-2">
                        <div>
                            <label for="first-name">First Name <span class="text-red">*</span></label>
                            <div class="form-group">
                                <input type="text" id="first-name" name="first_name" class="form-control">
                            </div>
                        </div>
                        <div>
                            <label for="last-name">Last Name <span class="text-red">*</span></label>
                            <div class="form-group">
                                <input type="text" id="last-name" name="last_name" class="form-control">
                            </div>
                        </div>
                        <div>
                            <label for="contact-no">Contact number <span class="text-red">*</span></label>
                            <div class="form-group">
                                <input type="tel" id="contact-no" name="contact_number" class="form-control">
                            </div>
                        </div>
                        <div>
                            <label for="email">Email <span class="text-red">*</span></label>
                            <div class="form-group">
                                <input type="email" id="email" name="email" class="form-control">
                            </div>
                        </div>
                        <div>
                            <label for="nationality">Nationality <span class="text-red">*</span></label>
                            <div class="form-group">
                                @include('front.elements.country')
                            </div>
                        </div>
                        <fieldset>
                            <legend>Preferred method of contact<span class="text-red">*</span></legend>
                            <div class="flex flex-wrap gap-1">
                                <div>
                                    <input type="radio" id="method-email" name="contact_method" value="email"
                                        class="radio-input-compact">
                                    <label for="method-email">
                                        <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                                            aria-hidden="true" class="w-6 h-6">
                                            <circle cx="10" cy="10" r="9" fill="white"
                                                stroke="currentColor" />
                                            <circle cx="10" cy="10" r="6" class="check" />
                                        </svg>
                                        Email
                                    </label>
                                </div>

                                <div>
                                    <input type="radio" id="method-phone" name="contact_method" value="phone"
                                        class="radio-input-compact">
                                    <label for="method-phone">
                                        <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                                            aria-hidden="true" class="w-6 h-6">
                                            <circle cx="10" cy="10" r="9" fill="white"
                                                stroke="currentColor" />
                                            <circle cx="10" cy="10" r="6" class="check" />
                                        </svg>
                                        Phone
                                    </label>
                                </div>

                                <div>
                                    <input type="radio" id="method-both" name="contact_method" value="both"
                                        class="radio-input-compact">
                                    <label for="method-both">
                                        <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                                            aria-hidden="true" class="w-6 h-6">
                                            <circle cx="10" cy="10" r="9" fill="white"
                                                stroke="currentColor" />
                                            <circle cx="10" cy="10" r="6" class="check" />
                                        </svg>
                                        Both
                                    </label>
                                </div>
                            </div>
                            <div id="contact-method-error"></div>
                        </fieldset>
                    </div>

                    <div>
                        <input type="checkbox" id="privacy-policy" name="privacy_policy">
                        <label for="privacy-policy">
                            I have read and accept the <a href="{{ url('/privacy-policy') }}" class="text-accent">Privacy
                                Policy</a>. <span class="text-red">*</span>
                        </label>
                        <div id="privacy-policy-error"></div>
                    </div>
                </div>
            </form>

            <div class="flex justify-center gap-8 px-10">
                <button type="button" class="btn btn-muted back" x-show="currentStep > 1"
                    x-on:click="currentStep-=1">Back</button>
                <button type="button" class="btn btn-secondary next" x-show="currentStep < 8"
                    x-on:click="currentStep+=1">Next</button>
                <button type="button" class="btn btn-secondary" id="finish-btn"
                    x-show="currentStep == 8">Finish</button>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" defer></script>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            var session_success_message = '{{ $session_success_message ?? '' }}';
            var session_error_message = '{{ $session_error_message ?? '' }}';
            if (session_success_message) {
                toastr.success(session_success_message);
            }
            if (session_error_message) {
                toastr.danger(session_error_message);
            }

            let currentPage = 1;
            let totalPage;
            let nextPage;
            var currentStep = 1;
            var form = $("#stepForm");
            var validator = form.validate();
            var formSteps = $("#stepForm>div");

            $("#slider-range").slider({
                classes: {
                    "ui-slider": "custom-slider"
                },
                range: true,
                min: 0,
                max: 10000,
                values: [0, 10000],
                change: function(event, ui) {
                    performSearch();
                },
                slide: function(event, ui) {
                    $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
                }
            });

            $(".destination-checkbox").on('change', async function(event) {
                currentPage = 1;
                $("#trips-block").html("");
                $("#not-sure").prop("checked", false);
                $("#trip-interested-block").show();
                const trips = await getTripsByDestinationID();
                addTripsToDiv(trips);
            });

            $("#keyword").on('input', function(event) {
                currentPage = 1;
                $("#trips-block").html("");

                if (window.debouncedGetTripsByDestinationID) {
                    window.debouncedGetTripsByDestinationID.cancel();
                }
                window.debouncedGetTripsByDestinationID = _.debounce(async function() {
                    const trips = await getTripsByDestinationID();
                    addTripsToDiv(trips);
                }, 300);
                window.debouncedGetTripsByDestinationID();
            });

            function addTripsToDiv(trips) {
                let html = "";
                const selected_trip_id = "{!! $selected_trip_id !!}";
                for (const trip of trips) {
                    html += `<div class="destination-trip">\
                                <input type="checkbox" id="trip${trip.id}" name="trip_interested[]" value="${trip.id}"\
                                    class="check-input">\
                                <label for="trip${trip.id}" class="h-full label-sm">\
                                    <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="shrink-0 w-5 h-5"\
                                        aria-hidden="true" class="w-6 h-6">\
                                        <rect x="0" y="0" width="20" height="20"\
                                            fill="white" stroke="currentColor" />\
                                        <path class="check" clip-rule="evenodd" fill-rule="evenodd"\
                                            d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z">\
                                        </path>\
                                    </svg>\
                                    <div><div class="text-sm">${trip.name}</div><div class="text-sm text-gray-400">${trip.duration} days</div></div>\
                                </label>\
                            </div>`;
                }
                $("#trips-block").append(html);
            }

            initDestination();

            function initDestination() {
                const selected_destinations = "{!! $all_selected_destinations !!}";
                if (selected_destinations.length > 0) {
                    const boxes = $(".destination-checkbox");
                    boxes.each(function(i, v) {
                        const dest_id = $(v).val();
                        if (selected_destinations.includes(dest_id)) {
                            $(v).prop('checked', true);
                        }
                    });
                    const selected_trip_id = "{!! $selected_trip_id !!}";
                    const trip_name = "{!! $selected_trip_name !!}";
                    const trip_duration = "{!! $selected_trip_duration !!}";
                    const html = `<div class="destination-trip">\
                                <input type="checkbox" id="trip${selected_trip_id}" checked name="trip_interested[]" value="${selected_trip_id}"\
                                    class="check-input">\
                                <label for="trip${selected_trip_id}">\
                                    <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"\
                                        aria-hidden="true" class="w-6 h-6">\
                                        <rect x="0" y="0" width="20" height="20"\
                                            fill="white" stroke="currentColor" />\
                                        <path class="check" clip-rule="evenodd" fill-rule="evenodd"\
                                            d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z">\
                                        </path>\
                                    </svg>\
                                    <div><div class="text-sm">${trip_name}</div><div class="text-sm text-gray-400">${trip_duration} days</div></div>\
                                </label>\
                            </div>`;
                    $("#trips-block").append(html);
                } else {
                    $(".destination-checkbox:first").click();
                }
            }

            $("#show-more").on('click', async function(event) {
                event.preventDefault();
                if (nextPage) {
                    currentPage++;
                    const trips = await getTripsByDestinationID(currentPage);
                    addTripsToDiv(trips);
                    if (!nextPage) {
                        $("#show-more").hide();
                    }
                }
            });

            function getTripsByDestinationID() {
                return new Promise((resolve, reject) => {
                    const keyword = document.querySelector('#keyword').value;
                    const selectedDestinationArr = [];
                    $('.destination-checkbox:checked').each(function() {
                        selectedDestinationArr.push($(this).val());
                    });
                    let url = '{!! route('front.destinations.gettrips') !!}' +
                        `?keyword=${keyword}&ids=${selectedDestinationArr.join(',')}&page=${currentPage}`;
                    let result = [];
                    $.ajax({
                        url: url,
                        type: "GET",
                        dataType: "json",
                        async: "false",
                        beforeSend: function(xhr) {
                            var spinner =
                                `<button style="margin:0 auto;" class="text-white btn btn-sm btn-primary" type="button" disabled>
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Loading Trips...
                                </button>`;
                            $("#spinner-block").html(spinner);
                            $("#show-more").hide();
                        },
                        success: function(res) {
                            if (res.success) {
                                result = res.data.data;
                                totalPage = res.data.total;
                                currentPage = res.data.current_page;
                                nextPage = (res.data.next_page_url) ? true : false;
                            }
                        }
                    }).done(function(data) {
                        $("#spinner-block").html('');
                        if (!nextPage) {
                            $("#show-more").hide();
                        } else {
                            $("#show-more").show();
                        }
                        resolve(result);
                    });
                });
            }

            $("#not-sure").on('change', function() {
                if ($(this).is(':checked')) {
                    $(".destination-checkbox").prop('checked', false);
                    $("#trip-interested-block").hide();
                }
            });

            const stepBlock = {
                step1: "step-where",
                step2: "step-when",
                step3: "step-who",
                step4: "step-accomodation",
                step5: "step-budget",
                step6: "step-tailor-made",
                step7: "step-tailor-made"
            };

            var validationRules = {
                step1: {
                    who: {
                        required: true
                    }
                },
                step2: {
                    when: {
                        required: true
                    },
                    arrival_date: {
                        required: true
                    },
                    month: {
                        required: true
                    }
                },
                step3: {
                    "destination[]": {
                        required: true
                    },
                },
                step4: {
                    accomodation: {
                        required: true
                    }
                },
                step5: {
                    flexible: {
                        required: true
                    }
                },
                step6: {
                    trip_type: {
                        required: true
                    },
                    plan_phase: {
                        required: true
                    },
                    reached_by: {
                        required: true
                    }
                },
                step7: {
                    first_name: {
                        required: true
                    },
                    last_name: {
                        required: true
                    },
                    contact_number: {
                        required: true
                    },
                    email: {
                        required: true
                    },
                    country: {
                        required: true
                    },
                    contact_method: {
                        required: true
                    },
                    privacy_policy: {
                        required: true
                    },
                }
            };

            function selectStep(name) {
                const step = $("#step-block>button");
                const index = $(`#${name}`).index();
                step.each(function(i, v) {
                    const el = $(v);
                    if (i <= index) {
                        el.addClass('active');
                    } else {
                        el.removeClass('active');
                    }
                });
            }

            function nextStep() {
                var currentFieldset = formSteps.eq(currentStep - 1);
                const validationGroup = validationRules["step" + currentStep];
                validator.destroy();
                form.validate({
                    rules: validationGroup,
                    errorPlacement: function(error, element) {
                        error = `<div class="mt-2 text-sm text-red-600">${error.text()}</div>`;
                        if (element.attr("name") == "who") {
                            $("#who-error").html(error);
                        } else if (element.attr("name") == "when") {
                            $("#when-error").html(error);
                        } else if (element.attr("name") == "destination[]") {
                            $("#destination-error").html(error);
                        } else if (element.attr("name") == "trip_interested[]") {
                            $("#trip-interested-error").html(error);
                        } else if (element.attr("name") == "accomodation") {
                            $("#accomodation-error").html(error);
                        } else if (element.attr("name") == "flexible") {
                            $("#flexible-error").html(error);
                        } else if (element.attr("name") == "trip_type") {
                            $("#trip-type-error").html(error);
                        } else if (element.attr("name") == "plan_phase") {
                            $("#plan-phase-error").html(error);
                        } else if (element.attr("name") == "contact_method") {
                            $("#contact-method-error").html(error);
                        } else if (element.attr("name") == "privacy_policy") {
                            $("#privacy-policy-error").html(error);
                        } else {
                            error.insertAfter(element);
                        }
                    },
                    submitHandler: function(form) {
                        var formData = new FormData($(form)[0]);
                        formData.append('amount', $("#slider-range").slider("values"));
                        $.ajax({
                            url: "{{ route('front.plantrip.create') }}",
                            type: 'POST',
                            data: formData,
                            dataType: 'json',
                            processData: false,
                            contentType: false,
                            async: false,
                            success: function(res) {
                                if (res.status === 1) {
                                    location.href =
                                        "{{ route('front.plantrip.thank-you') }}";
                                }
                            }
                        });
                    }
                });

                if (form.valid()) {
                    if (currentStep === 7) {
                        form.submit();
                        return;
                    }
                    currentFieldset.hide();
                    formSteps.eq(currentStep).css('display', 'grid');
                    currentStep++;
                } else {
                    form.validate().focusInvalid();
                }

                const currentStepName = `step${currentStep}`;
                selectStep(stepBlock[currentStepName]);
            }

            function prevStep() {

                if (currentStep > 1) {
                    formSteps.eq(currentStep - 1).hide();
                    formSteps.eq(currentStep - 2).show();
                    currentStep--;
                }
                const currentStepName = `step${currentStep}`;
                selectStep(stepBlock[currentStepName]);
            }

            $("button.next").on("click", function(e) {
                e.preventDefault();
                nextStep();
                window.scrollTo(0, 238);
            });

            $("button.back").on("click", function(e) {
                e.preventDefault();
                prevStep();
                window.scrollTo(0, 238);
            });

            $("#finish-btn").on('click', function(event) {
                event.preventDefault();
                nextStep();
            });
        });
    </script>
@endpush
