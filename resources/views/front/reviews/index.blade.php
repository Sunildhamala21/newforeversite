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
@section('title', 'Reviews')
@push('styles')
    <script src="https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit" async defer></script>
@endpush
@section('content')
    <x-hero title="Reviews" />

    <section class="py-20 bg-gray-50">
        <div class="container">
            <div class="grid gap-10 lg:grid-cols-3 xl:gap-20">
                <div class="lg:col-span-2">
                    <div class="grid gap-4 mb-6">
                        @forelse ($reviews as $review)
                            <div class="p-6 bg-white border-2 border-gray-100 rounded-lg review">
                                <div class="mb-4 review__content">
                                    <h3 class="mb-4 text-2xl font-display text-primary">{{ $review->title }}</h3>
                                    <p>{{ $review->review }}</p>
                                </div>
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center gap-4">
                                        @if ($review->thumbImageUrl)
                                            <img src="{{ $review->thumbImageUrl }}" alt="{{ $review->review_name }}"
                                                loading="lazy">
                                        @else
                                            <div
                                                class="flex items-center justify-center w-16 h-16 text-xl rounded-full bg-light text-primary">
                                                {{ $review->review_name[0] }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-bold">{{ ucfirst($review->review_name) }}</div>
                                            <div class="text-sm text-gray">{{ $review->review_country }}</div>
                                            <div class="flex gap-1">
                                                @for ($i = 0; $i < 5; $i++)
                                                    <svg class="w-5 h-5 text-accent">
                                                        <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#star" />
                                                    </svg>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <p class="text-sm text-center text-gray-400">Review for <a
                                        href="{{ route('front.trips.show', $review->trip) }}">{{ $review->trip->duration }}
                                        days
                                        {{ $review->trip->name }}</a>
                                </p>
                            </div>
                        @empty
                        @endforelse
                    </div>
                    {{ $reviews->links('pagination.default') }}
                </div>
                <aside>
                    <a href="{{ route('front.reviews.create') }}"
                        class="inline-block px-4 py-4 tracking-wide text-white no-underline uppercase bg-green-600 rounded-lg font-display hover:bg-green-700">Write
                        a review</a>
                    @include('front.elements.enquiry')
                </aside>
            </div>
        </div>

    </section>
@endsection
@push('scripts')
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
                        var btn = $(form).find('button[type=submit]').attr('disabled', true).html(
                            'Sending...');
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
