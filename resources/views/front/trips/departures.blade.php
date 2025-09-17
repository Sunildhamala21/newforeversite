@extends('layouts.front_inner')
@section('title', 'Upcoming Fixed Departures')
@section('content')

    <x-hero title="Upcoming Fixed Departures" :image="asset('images/hero/hero.jpg')" />

    <section class="pt-20">
        <div class="container">
            <div class="mb-10 prose md:prose-2xl text-balance">
                <p><b>This is our agenda for the next few months. Find the perfect trip for you and, if you have any
                        questions, just get in touch with us!</b></p>
            </div>
            <div class="grid gap-10 mb-20 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4">

                @foreach ($departures as $departure)
                    <div class="p-4 border border-gray-200 rounded-md hover:shadow-md">
                        <img class="object-cover w-full rounded-sm aspect-4/3" src="{{ $departure->trip->mediumImageUrl }}"
                            alt="">
                        <div class="mt-6 text-xl font-semibold">{{ $departure->trip->name }}</div>
                        <div class="flex justify-between py-3 border-b border-gray-200">
                            <div>Start date</div>
                            {{ formatDate($departure->from_date) }}
                        </div>
                        <div class="flex justify-between py-3 border-b border-gray-200">
                            <div>End date</div>
                            {{ formatDate($departure->to_date) }}
                        </div>
                        <div class="flex justify-between py-3">
                            <div>Seats available</div>
                            {{ $departure->seats }}
                        </div>
                        <div class="flex justify-center py-3">
                            <a href="{{ route('front.trips.show', $departure->trip) }}"
                                class="flex px-6 py-3 uppercase border rounded-full border-primary">Know more</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="py-20 bg-gray-50">
            <div class="container">

                <div class="grid gap-10 md:grid-cols-2">
                    <div class="mb-10 prose md:prose-2xl text-balance">
                        <p><b>Get in touch with us and schedule your trip!</b></p>
                    </div>
                    <form id="enquiry-form" action="{{ route('front.contact.store') }}" method="POST" class="w-full">
                        @csrf
                        <input type="hidden" id="redirect-url" name="redirect_url">
                        <div class="grid gap-4">
                            <div class="mb-2 form-group">
                                <label class="sr-only" for="">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Name" required>
                            </div>
                            <div class="mb-2 form-group">
                                <label class="sr-only" for="email">E-mail</label>
                                <input type="email" name="email" class="form-control" placeholder="Email">
                            </div>
                            <div class="mb-2 form-group">
                                <label class="sr-only" for="country">Country</label>
                                <input type="text" name="country" id="" class="form-control" list="countries"
                                    placeholder="Country">
                            </div>
                            <div class="mb-2 form-group">
                                <label class="sr-only" for="phone">Phone Number</label>
                                <input type="tel" name="phone" class="form-control" placeholder="Phone No.">
                            </div>
                            <div class="mb-2 form-group">
                                <label class="sr-only" for="">Message</label>
                                <textarea name="message" class="form-control" placeholder="Message" required></textarea>
                            </div>
                        </div>
                        <div class="mb-2 form-group">
                            <input type="hidden" id="enquiry-recaptcha" name="enquiry-recaptcha">
                            <button type="submit" class="btn btn-primary">Submit Enquiry</button>
                        </div>
                    </form>
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
