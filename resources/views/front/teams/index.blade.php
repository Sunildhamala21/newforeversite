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
@section('title', 'Our Team')
@push('styles')
    <script src="https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit"
            async
            defer></script>
@endpush
@section('content')
    <x-hero title="Our Team" />

    <section class="py-20 bg-gray-50">
        <div class="container" x-data="{ active: 'administration' }">
            <div class="flex flex-wrap gap-2 mb-10">
                @if ($administrations->isNotEmpty())
                    <button class="px-3 py-2 text-white rounded-lg":class="{ 'bg-green-600 hover:bg-green-700': active === 'administration', 'bg-primary hover:bg-primary-dark': active !== 'administration' }" x-on:click="active='administration'">Administration</button>
                @endif
                @if ($representatives->isNotEmpty())
                    <button class="px-3 py-2 text-white rounded-lg":class="{ 'bg-green-600 hover:bg-green-700': active === 'representatives', 'bg-primary hover:bg-primary-dark': active !== 'representatives' }" x-on:click="active='representatives'">Representatives</button>
                @endif
                @if ($tour_guides->isNotEmpty())
                    <button class="px-3 py-2 text-white rounded-lg":class="{ 'bg-green-600 hover:bg-green-700': active === 'tourguides', 'bg-primary hover:bg-primary-dark': active !== 'tourguides' }" x-on:click="active='tourguides'">Tour Guides</button>
                @endif
            </div>
            <div class="grid gap-10 lg:gap-20 lg:grid-cols-3">
                <div class="lg:col-span-2">
                    <div x-show="active==='administration'">
                        <div class="grid gap-2 lg:gap-10">
                            @if ($administrations)
                                @foreach ($administrations as $item)
                                    @include('front.elements.team_card')
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div x-show="active==='representatives'">
                        <div class="grid gap-2 lg:gap-10">
                            @if ($representatives)
                                @foreach ($representatives as $item)
                                    @include('front.elements.team_card')
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div x-show="active==='tourguides'">
                        <div class="grid gap-2 lg:gap-10">
                            @if ($tour_guides)
                                @foreach ($tour_guides as $item)
                                    @include('front.elements.team_card')
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div>

                </div>
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
