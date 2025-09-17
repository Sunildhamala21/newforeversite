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
@push('styles')
    <meta name="robots" content="noindex" />
@endpush
@extends('layouts.front_inner')
@section('content')
    <section class="py-20 bg-gray-50" x-data="{ noOfTravellers: 1, rate: {{ isset($trip->offer_price) && !empty($trip->offer_price) ? $trip->offer_price : $trip->cost }}, paymentType: 'half' }">
        <div class="container">
            <form id="captcha-form" action="{{ route('front.trips.departure-booking.store') }}" method="POST">
                @csrf
                @if ($errors->any())
                    @dd($errors->all())
                @endif
                <div class="grid gap-10 lg:grid-cols-3 lg:gap-20">
                    <div class="lg:col-span-2">
                        <h1 class="mb-6 text-xl font-semibold lg:text-3xl font-display">Book {{ $trip->name }}</h1>

                        <div class="mb-6">
                            @include('front.elements.breadcrumb', [
                                'navs' => [['link' => route('front.trips.show', $trip), 'title' => $trip->name]],
                                'current' => 'Book',
                            ])
                        </div>

                        <div style="margin-bottom: 5px; padding-bottom: 7px;">
                            <h3>Departure</h3>
                            <div class="mt-2">
                                <strong>From </strong> {{ formatDate($trip_departure?->from_date) }} <strong>To </strong>
                                {{ formatDate($trip_departure?->to_date) }}
                            </div>
                            <hr>
                        </div>

                        <input type="hidden" name="departure_id" value="{{ $trip_departure->id }}">
                        <input type="hidden" name="id" value="{{ $trip->id }}">
                        <h2 class="mb-2 text-xl font-semibold text-primary">Personal details</h2>
                        <div class="grid gap-6 mb-6 lg:grid-cols-3">
                            <div class="form-group">
                                <label for="">First name *</label>
                                <input type="text" class="form-control" name="first_name" placeholder="First name"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="">Middle name</label>
                                <input type="text" class="form-control" name="middle_name" placeholder="Middle name">
                            </div>
                            <div class="form-group">
                                <label for="">Last name *</label>
                                <input type="text" class="form-control" name="last_name" placeholder="Last name"
                                    required>
                            </div>
                        </div>
                        <div class="grid gap-6 mb-10 lg:grid-cols-2">
                            <div class="form-group">
                                <label for="">Country *</label>
                                @include('front.elements.country')
                            </div>
                            <div class="form-group">
                                <label for="">Email *</label>
                                <input type="email" name="email" class="form-control" placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <label for="">Contact no. *</label>
                                <input type="tel" name="phone" class="form-control" placeholder="Contact no."
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="">Gender </label>
                                <select name="gender" id="" class="form-control">
                                    <option value="" selected disabled>Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>

                        <h2 class="mb-2 text-xl font-bold text-primary">Trip details</h2>
                        <div class="grid gap-6 mb-6 lg:grid-cols-2">
                            <div class="form-group">
                                <label for="">No. of travellers </label>
                                <input type="number" name="no_of_travelers" class="form-control" min="1"
                                    x-model="noOfTravellers" placeholder="No. of travellers">
                            </div>
                            <div class="form-group lg:col-span-2">
                                <label for="">Message </label>
                                <textarea name="message" id="" cols="60" rows="3" class="form-control" placeholder="Message"></textarea>
                            </div>
                        </div>
                        <div class="flex gap-2 mb-6 form-group">
                            <input type="checkbox" name="tnc" id="tnc" class="border-gray-400 rounded-xs"
                                required>
                            <label for="tnc">I agree with the company's booking <a
                                    href="{{ url('booking-terms-and-conditions') }}" class="text-secondary">terms and
                                    conditions</a>.</label>
                        </div>

                        @error('tnc')
                            <div class="mb-6 text-sm text-red-500">{{ $message }}</div>
                        @enderror
                        <input type="hidden" id="recaptcha" name="g-recaptcha-response">
                        @include('front.elements.recaptcha')
                        <button id="make_a_payment_btn" class="btn btn-primary">Submit</button>
                    </div>

                    <aside>
                        <img src="{{ $trip->imageUrl }}" alt="" class="rounded-t-lg">
                        <div class="p-10 bg-light">

                            <h2 class="text-2xl font-bold text-primary font-display">Book {{ $trip->name }}</h2>
                            <div class="mt-4 text-sm text-gray-500">
                                <p class="flex mb-2"><span
                                        class="inline-block w-36">Duration:</span>{{ $trip->duration }} days</p>
                                <p class="flex mb-2"><span class="inline-block w-36">Package price:</span>US$
                                    {{ number_format($trip->cost) }}</p>
                                <p class="flex mb-2"><span class="inline-block w-36">Discount:</span>US$
                                    {{ number_format($trip->offer_price ? $trip->cost - $trip->offer_price : 0) }}</p>
                                <p class="flex mb-2"><span class="inline-block w-36">Offer price:</span>US$
                                    {{ number_format($trip->offer_price ?? $trip->cost) }}</p>
                                <p class="flex mb-2"><span class="inline-block w-36">No of Travellers:</span><span><span
                                            x-text="noOfTravellers"></span> people</span></p>
                                <hr class="mb-6">
                                <div class="flex gap-4 mb-2">
                                    <div class="flex items-center gap-2">
                                        <input class="w-4 h-4" type="radio" name="pay" id="payment_full"
                                            value="full" x-model="paymentType">
                                        <label for="payment_full">
                                            Pay full
                                        </label>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <input class="w-4 h-4" checked type="radio" name="pay"
                                            id="payment_deposit" valud="25%" x-model="paymentType">
                                        <label for="payment_deposit">
                                            Pay 25% advance
                                        </label>
                                    </div>
                                </div>
                                <p class="flex mb-2"><span class="inline-block w-36 text-md">Total amount:</span><span
                                        class="text-xl font-bold text-primary font-display">US$ <span
                                            x-text="(noOfTravellers * rate).toLocaleString()"></span></span></p>

                                <p class="flex mb-2"><span class="inline-block w-36 text-md">Payable Now:</span><span
                                        class="text-xl font-bold font-display">US$ <span
                                            x-text="(noOfTravellers * rate * ((paymentType === 'half')? 0.25: 1)).toLocaleString()"></span></span>
                                </p>
                            </div>
                        </div>
                        <div class="p-10 rounded-b-lg bg-light">

                            <div class="mb-2 text-sm text-center text-gray-500">We accept</div>
                            <div class="flex justify-center gap-2">
                                <img src="{{ asset('assets/front/img/card_visa.svg') }}" width="780" height="500"
                                    alt="Visa" class="w-auto h-10">
                                <img src="{{ asset('assets/front/img/card_mastercard.svg') }}" width="780"
                                    height="500" alt="Mastercard" class="w-auto h-10">
                                <img src="{{ asset('assets/front/img/card_americanexpress.svg') }}" width="780"
                                    height="500" alt="American Express" class="w-auto h-10">
                                <img src="{{ asset('assets/front/img/card_unionpay.svg') }}" width="780"
                                    height="500" alt="UnionPay" class="w-auto h-10">
                            </div>
                        </div>
                    </aside>
                </div>

            </form>
        </div>
    </section>
@endsection
@push('scripts')
    <script type="text/javascript">
        $(function() {
            var session_success_message = '{{ $session_success_message ?? '' }}';
            var session_error_message = '{{ $session_error_message ?? '' }}';
            if (session_success_message) {
                toastr.success(session_success_message);
            }

            if (session_error_message) {
                toastr.error(session_error_message);
            }
        });
    </script>
@endpush
