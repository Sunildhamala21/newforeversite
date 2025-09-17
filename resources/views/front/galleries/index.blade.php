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
@section('title', 'Gallery')
@push('styles')
    <script src="https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit"
            async
            defer></script>
@endpush
@section('content')

    <x-hero title="Gallery" />

    <section class="py-20">
        <div class="container">
            <div class="grid gap-10 lg:gap-20 lg:grid-cols-3">
                <div class="lg:col-span-2">
                    <div class="grid grid-cols-2 gap-4 lg:gap-10 lg:grid-cols-3">
                        <?php foreach ($trips as $trip) : ?>
                        <div class="relative album">
                            <a href="{{ $trip->galleryLink }}">
                                <div class="relative mb-2">
                                    <img class="object-cover mb-2 rounded-lg aspect-square"
                                         src="{{ $trip->mediumImageUrl }}"
                                         alt="{{ $trip->name }}">
                                    <div class="text-sm lg:text-md text-primary">
                                        {{ $trip->name }}
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php endforeach; ?>
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
