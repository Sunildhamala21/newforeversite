<?php
if (session()->has('success_message')) {
    $session_success_message = session('success_message');
    session()->forget('success_message');
}

if (session()->has('error_message')) {
    $session_error_message = session('error_message');
    session()->forget('error_message');
}
?>
@extends('layouts.front_inner')
@section('title', $trip->name . ' Gallery')
@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <script src="https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit"
            async
            defer></script>
@endpush
@section('content')

    <x-hero :title="$trip->name . ' Gallery'" :breadcrumbs="[['url' => route('front.trips.all-gallery'), 'name' => 'Gallery']]" />

    <section class="py-20">
        <div class="container">
            <div class="grid gap-10 lg:grid-cols-3">
                <div class="lg:col-span-2">
                    <div class="grid grid-cols-2 gap-4 lg:gap-10 gallery md:grid-cols-3">

                        @forelse($trip->trip_galleries as $key => $gallery)
                            <a data-fancybox="gallery"
                               href="{{ $gallery->imageUrl }}"
                               class="item"
                               data-caption="{{ $gallery->name }} {{ $key + 1 }}">
                                <div class="relative">
                                    <img class="object-cover w-full rounded-sm aspect-square"
                                         src="{{ $gallery->mediumImageUrl }}"
                                         alt="{{ $gallery->alt_tag }}">
                                    <div class="absolute flex items-center justify-center w-full h-full overlay">
                                    </div>
                                    <svg class="absolute w-6 h-6 text-white"
                                         fill="none"
                                         stroke="currentColor"
                                         viewBox="0 0 24 24"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                    </svg>
                                </div>
                            </a>
                        @empty
                            <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                                <p>No gallery to show.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
                <aside>
                    @include('front.elements.enquiry')
                </aside>
            </div>
        </div>

    </section>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    <script>
        $(function() {
            var session_success_message = '{{ $session_success_message ?? '' }}';
            var session_error_message = '{{ $session_error_message ?? '' }}';
            if (session_success_message) {
                toastr.success(session_success_message);
            }

            if (session_error_message) {
                toastr.danger(session_error_message);
            }

            var enquiry_validator = $("#enquiry-form").validate({
                ignore: "",
                rules: {
                    'name': 'required',
                    'email': 'required',
                    'country': 'required',
                    'phone': 'required',
                    'message': 'required',
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element.closest('.flex'));
                    // error.append(element.closest('.form-group'));
                },
                submitHandler: function(form, event) {
                    event.preventDefault();
                    if (grecaptcha.getResponse(0)) {
                        var btn = $(form).find('button[type=submit]').attr('disabled', true).html('Sending...');
                        setTimeout(() => {
                            form.submit();
                        }, 500);
                    } else {
                        grecaptcha.reset(enquiry_captcha);
                        grecaptcha.execute(enquiry_captcha);
                    }
                },
            });
        });

        function onSubmitEnquiry(token) {
            $("#enquiry-form").submit();
            return true;
        }

        let enquiry_captcha;
        var CaptchaCallback = function() {
            enquiry_captcha = grecaptcha.render('inquiry-g-recaptcha', {
                'sitekey': '{!! config('constants.recaptcha.sitekey') !!}'
            });
            // review_captcha = grecaptcha.render('review-g-recaptcha', {'sitekey' : '{!! config('constants.recaptcha.sitekey') !!}'});
        };
    </script>
@endpush
