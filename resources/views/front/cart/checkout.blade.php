@extends('layouts.front_inner')

@section('title', 'Checkout')
@section('content')
    <section class="py-20 bg-gray-50">
        <div class="container">

            @if($errors->any())
            @dd($errors->all())
            @endif

            <form id="captcha-form" action="{{ route('cart.storeCheckout') }}" method="POST">
                @csrf
                <div class="grid gap-10 lg:grid-cols-3">
                    <div class="lg:col-span-2">
                        <h1 class="mb-6 text-xl font-semibold lg:text-3xl font-display">Checkout</h1>

                        <div class="mb-6">
                            @include('front.elements.breadcrumb', [
                                'navs' => [['link' => route('cart.index'), 'title' => 'Cart']],
                                'current' => 'Checkout',
                            ])
                        </div>

                        <h2 class="mb-2 text-xl font-semibold text-primary">Personal details</h2>
                        <div class="grid gap-6 mb-6 lg:grid-cols-3">
                            <div class="form-group">
                                <label for="">First name *</label>
                                <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" placeholder="First name" required>
                                @error('first_name')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Middle name</label>
                                <input type="text" class="form-control" name="middle_name" value="{{ old('middle_name') }}" placeholder="Middle name">
                            </div>
                            <div class="form-group">
                                <label for="">Last name *</label>
                                <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" placeholder="Last name" required>
                                @error('last_name')
                                    <span class="text-red-500">{{ $message }}</span>
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
                                <input id="email" class="form-control" placeholder="Email" value="{{ old('email') }}" name="email" type="email" required>
                                @error('email')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror

                            </div>
                            <div class="form-group">
                                <label for="phone">Phone *</label>
                                <input type="tel" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" placeholder="Contact no."
                                       required>
                                @error('phone')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Gender </label>
                                <select name="gender" id="" class="form-control" value="{{ old('gender') }}">
                                    <option value="" @if(!old('gender')) selected @endif disabled>Gender</option>
                                    <option value="male" @if(old('gender') == "male") selected @endif>Male</option>
                                    <option value="female" @if(old('gender') == "female") selected @endif>Female</option>
                                    <option value="other" @if(old('gender') == "other") selected @endif>Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid gap-6 mb-6">
                            <div class="form-group">
                                <label for="">Message </label>
                                <textarea name="message" id="" cols="60" rows="3" class="form-control" placeholder="Message">{{ old('message') }}</textarea>
                            </div>

                            <div class="flex gap-2 form-group">
                                <input type="checkbox" name="tnc" id="tnc" class="border-gray-400 rounded-xs">
                                <label for="tnc">I agree with the company's booking <a href="{{ url('booking-terms-and-conditions') }}"
                                       class="text-secondary">terms and conditions</a>.</label>
                            </div>
                            @error('tnc')
                                <div class="mb-6 text-sm text-red-500">{{ $message }}</div>
                            @enderror
                        </div>

                        @include('front.elements.recaptcha')

                        <button id="make_a_payment_btn" class="btn btn-primary">Submit</button>
                    </div>

                    <aside>
                        <div class="overflow-hidden border rounded-lg">
                            <div class="p-4 space-y-3 bg-white" x-data="{ payment: 'full', get payable() { return this.payment === 'full' ? '{{ number_format($cartTotal) }}' : '{{ number_format($cartTotal * 0.25) }}' } }">
                                <div class="flex justify-between">
                                    <span class="text-lg font-semibold text-primary">Trips</span>
                                    <a href="{{ route('cart.index') }}" class="text-xs text-gray-600">Edit</a>
                                </div>
                                @foreach ($cart as $item)
                                    <div class="flex items-start gap-4 text-gray-500">
                                        <img src="{{ $item['trip']->thumbImageUrl }}" alt="" class="rounded-sm">
                                        <div>
                                            <div>
                                                <a href="{{ $item['trip']->link }}" class="font-semibold text-primary">
                                                    {{ $item['trip']->name }}
                                                </a>
                                                <span class="text-sm">- {{ $item['trip']->duration }} days</span>
                                            </div>
                                            <div class="flex items-center gap-2 mt-2 text-sm">
                                                <svg class="w-4 h-3 text-gray-300" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                     fill="currentColor" viewBox="0 0 16 16">
                                                    <path
                                                          d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V5h16V4H0V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5">
                                                    </path>
                                                </svg>
                                                <div>{{ $item['start_date'] }} to {{ $item['end_date'] }}</div>
                                            </div>
                                            <div class="flex items-center gap-2 mt-2 text-sm">
                                                <svg class="text-gray-300 size-4" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                                                    <path
                                                          d="M192 256c61.9 0 112-50.1 112-112S253.9 32 192 32 80 82.1 80 144s50.1 112 112 112zm76.8 32h-8.3c-20.8 10-43.9 16-68.5 16s-47.6-6-68.5-16h-8.3C51.6 288 0 339.6 0 403.2V432c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48v-28.8c0-63.6-51.6-115.2-115.2-115.2zM480 256c53 0 96-43 96-96s-43-96-96-96-96 43-96 96 43 96 96 96zm48 32h-3.8c-13.9 4.8-28.6 8-44.2 8s-30.3-3.2-44.2-8H432c-20.4 0-39.2 5.9-55.7 15.4 24.4 26.3 39.7 61.2 39.7 99.8v38.4c0 2.2-.5 4.3-.6 6.4H592c26.5 0 48-21.5 48-48 0-61.9-50.1-112-112-112z">
                                                    </path>
                                                </svg>
                                                <div>{{ $item['no_of_travelers'] }} pax</div>
                                            </div>
                                            <div class="mt-2 font-semibold">US$ {{ number_format($item['price']) }}</div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="pt-2 text-lg text-center border-t">
                                    Total: <span class="font-semibold text-primary">US$ {{ number_format($cartTotal) }}</span>
                                </div>
                                <div class="flex justify-center gap-6 pt-2 border-t">
                                    <div class="flex items-center gap-2">
                                        <input class="w-4 h-4" type="radio" name="pay" id="payment_full" x-model="payment" value="full" checked>
                                        <label class="text-md" for="payment_full">
                                            Pay full
                                        </label>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <input class="w-4 h-4" type="radio" name="pay" id="payment_deposit" x-model="payment" value="25%">
                                        <label class="text-md" for="payment_deposit">
                                            Pay 25%
                                        </label>
                                    </div>
                                </div>
                                <div class="pt-2 text-lg text-center border-t">
                                    Payable: <span class="font-semibold text-primary">US$ <span x-text="payable"></span></span>
                                </div>
                            </div>
                            <div class="p-10 bg-light">
                                <div class="mb-2 text-sm text-center text-gray-500">We accept</div>
                                <div class="flex justify-center gap-2">
                                    <img src="{{ asset('assets/front/img/card_visa.svg') }}" width="780" height="500" alt="Visa" class="w-auto h-10">
                                    <img src="{{ asset('assets/front/img/card_mastercard.svg') }}" width="780" height="500" alt="Mastercard"
                                         class="w-auto h-10">
                                    <img src="{{ asset('assets/front/img/card_americanexpress.svg') }}" width="780" height="500" alt="American Express"
                                         class="w-auto h-10">
                                    <img src="{{ asset('assets/front/img/card_unionpay.svg') }}" width="780" height="500" alt="UnionPay"
                                         class="w-auto h-10">
                                </div>
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
            var session_success_message = '{{ session()->has('success_message') ? session()->get('success_message') : '' }}';
            var session_error_message = '{{ session()->has('error_message') ? session()->get('error_message') : '' }}';
            if (session_success_message) {
                toastr.success(session_success_message);
            }
            if (session_error_message) {
                toastr.danger(session_error_message);
            }
        });
    </script>
@endpush
