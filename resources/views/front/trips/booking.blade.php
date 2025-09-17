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
@section('title', 'Book ' . $trip->name)
@section('content')

    <section class="py-20 bg-gray-50" x-data="{
        noOfTravellers: 1,
        paymentType: '25%',
        price_ranges: {{ json_encode($price_ranges) }},
        get calculateRate() {
            let rate = {{ $trip->offer_price ?? $trip->cost }};
            if (this.price_ranges) {
                Object.entries(this.price_ranges).forEach(([key, range]) => {
                    if (this.noOfTravellers >= Number(range.from) && this.noOfTravellers <= Number(range.to)) {
                        rate = Number(range.price);
                    }
                });
            }
            return rate;
        },
        get calculateAmount() {
            return this.calculateRate * this.noOfTravellers;
        },
        get payableAmount() {
            if (this.paymentType == 'full') {
                return this.calculateAmount;
            }
            return this.calculateAmount * .25;
        }
    }">
        <div class="container">
            <form id="captcha-form" action="{{ route('front.trips.booking.store', $trip) }}" method="POST">
                <div class="grid gap-10 lg:grid-cols-3 lg:gap-20">
                    <div class="lg:col-span-2">
                        <h1 class="mb-6 text-xl font-semibold lg:text-3xl font-display">Book {{ $trip->name }}</h1>

                        <div class="mb-6">
                            @include('front.elements.breadcrumb', [
                                'navs' => [['link' => route('front.trips.show', $trip), 'title' => $trip->name]],
                                'current' => 'Book',
                            ])
                        </div>

                        @csrf

                        <h2 class="mb-2 text-xl font-semibold text-primary">Personal details</h2>
                        <div class="grid gap-6 mb-6 lg:grid-cols-3">
                            <div class="form-group">
                                <label for="">First name *</label>
                                <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}"
                                    placeholder="First name" required>
                                @error('first_name')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Middle name</label>
                                <input type="text" class="form-control" name="middle_name"
                                    value="{{ old('middle_name') }}" placeholder="Middle name">
                            </div>
                            <div class="form-group">
                                <label for="">Last name *</label>
                                <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}"
                                    placeholder="Last name" required>
                                @error('last_name')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="grid gap-6 mb-10 lg:grid-cols-2">
                            <div class="form-group">
                                <label for="">Country *</label>
                                @include('front.elements.country')
                            </div>
                            <div class="form-group">

                                <label for="">Email *</label>
                                <input id="email" class="form-control" placeholder="Email" value="{{ old('email') }}"
                                    name="email" type="email" required>
                                @error('email')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror

                            </div>
                            <div class="form-group">
                                <label for="">Contact no. *</label>
                                <input type="tel" name="phone" class="form-control" value="{{ old('phone') }}"
                                    placeholder="Contact no." required>
                                @error('phone')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Gender </label>
                                <select name="gender" id="" class="form-control" value="{{ old('gender') }}">
                                    <option value="" selected>Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>

                        <h2 class="mb-10 text-xl font-bold text-primary">Trip details</h2>
                        <div class="grid gap-6 mb-6 lg:grid-cols-2">
                            <div class="form-group">
                                <label for="">No. of travellers *</label>
                                <input type="number" name="no_of_travelers" class="form-control" min="1"
                                    x-model="noOfTravellers" placeholder="No. of travelers" required>
                                @error('no_of_travelers')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Preferred departure date *</label>
                                <input type="date" name="start_date" id="" class="form-control"
                                    min="<?php echo date('Y-m-d'); ?>" value="{{ $date }}">
                                @error('start_date')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group lg:col-span-2">
                                <label for="">Message </label>
                                <textarea name="message" id="" cols="60" rows="3" class="form-control" placeholder="Message">{{ old('message') }}</textarea>
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
                                <p class="flex mb-2"><span class="inline-block w-36">No of Travellers:</span><span><span
                                            x-text="noOfTravellers"></span>
                                        people</span></p>
                                <p class="flex mb-2"><span class="inline-block w-36">Group price:</span><span
                                        x-text="`US$ ${calculateRate}`"></span></p>
                                {{-- <p class="flex mb-2"><span class="inline-block w-36">Discount:</span>US$ {{ number_format($trip->offer_price ? $trip->cost - $trip->offer_price : 0) }}</p> --}}
                                {{-- <p class="flex mb-2"><span class="inline-block w-36">Offer price:</span>US$ {{ number_format($trip->offer_price ?? $trip->cost) }}</p> --}}
                                <hr class="mb-6">
                                <div class="flex gap-6">
                                    <div class="flex items-center gap-2">
                                        <input class="w-4 h-4" type="radio" name="pay" id="payment_full"
                                            value="full" x-model="paymentType">
                                        <label class="text-md" for="payment_full">
                                            Pay full
                                        </label>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <input class="w-4 h-4" checked type="radio" name="pay"
                                            id="payment_deposit" value="25%" x-model="paymentType">
                                        <label class="text-md" for="payment_deposit">
                                            Pay 25%
                                        </label>
                                    </div>
                                </div>
                                <p class="flex mt-2 mb-2"><span class="inline-block w-36 text-md">Total
                                        amount:</span><span class="text-xl font-bold text-primary font-display">US$ <span
                                            x-text="calculateAmount"></span></span></p>

                                <p class="flex mb-2"><span class="inline-block w-36 text-md">Payable Now:</span><span
                                        class="text-xl font-bold font-display">US$
                                        <span x-text="payableAmount"></span></span></p>
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
                toastr.danger(session_error_message);
            }

            $(document).on('click', '#make_a_payment_btn', function(ev) {
                ev.preventDefault();
                let btn = $(this);
                btn.prop('disabled', true);
                btn.html('submitting...');
                setTimeout(() => {
                    $("#captcha-form").submit();
                }, 1000);
            });
        });
    </script>
    <script type="text/javascript">
        $(function() {
            $('input[type="text"], input[type="email"], input[type="tel"], select').on('focus', function() {
                $(this).siblings('.text-red-500').text('');
                $(this).removeClass('is-invalid');
                $(this).closest('.form-group').find('.text-red-500').text('');
                $(this).closest('.form-group').removeClass('is-invalid');
                $(this).closest('.form-group').find('.invalid-feedback').text('');
            });
        });
    </script>
@endpush
