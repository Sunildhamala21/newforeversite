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
@section('content')
<!-- Hero -->
<section class="hero hero-alt relative">
    <img src="{{ asset('assets/front/img/hero.jpg') }}" alt="">
    <div class="overlay absolute">
        <div class="container ">
            <h1>Customize {{ $trip->name }}</h1>
            <div class="breadcrumb-wrapper">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb fs-sm wrap">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Customize Form</li>
                    </ol>
                </nav>
            </div>
        </div>
</section>

<section class="py-5" style="padding-top: 25px;">
    <div class="container">
<div class="grid lg:grid-cols-3 xl:grid-cols-4 gap-4 xl:gap-3">
            <div class="lg:col-span-2 xl:col-span-3">
                <form id="captcha-form" action="{{ route('front.trips.customize.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $trip->id }}">
                    <h2 class="fs-lg bold text-primary mb-2" style="font-size: 25px;">Custom trip details</h2>
                    <div class="grid lg:grid-cols-3 gap-2 mb-2">
                        <div class="form-group">
                            <label for="">Trip duration *</label>
                            <input type="number" class="form-control" min="1" name="duration" placeholder="Trip duration" required>
                        </div>
                        <div class="form-group">
                            <label for="">No. of travellers *</label>
                            <input type="number" class="form-control" min="1" name="no_of_travellers" placeholder="No. of travellers" required>
                        </div>
                        <div class="form-group">
                            <label for="">Departure date*</label>
                            <input type="date" name="departure_date" id="" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="">Price range*</label>
                            <select name="" id="" class="form-control" required>
                                <option value="" selected>$5,000 - $8,000</option>
                                <option value="">$3,000 - $5,000</option>
                                <option value="">$2,000 - $3,000</option>
                                <option value="">$1,000 - $2,000</option>
                                <option value="">$800 - $1,000</option>
                                <option value="">$500 - $800</option>
                                <option value="">$300 - $500</option>
                                <option value="">Less than $300</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Difficulty</label>
                            <select name="" id="" class="form-control">
                                <option value="" selected>Easy</option>
                                <option value="">Moderate</option>
                                <option value="">Difficult</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid lg:grid-cols-3">
                        <div class="form-group lg:col-2">
                            <label for="">Message</label>
                            <textarea name="message" id="" class="form-control" cols="90" rows="6" placeholder="Message"></textarea>
                        </div>
                    </div>
                    <br>
                    <hr class="mb-2">
                    <h2 class="fs-lg bold text-primary mb-2">Personal details</h2>
                    <div class="grid lg:grid-cols-3 gap-2 mb-2">
                        <div class="form-group">
                            <label for="">Name *</label>
                            <input type="text" name="name" class="form-control" placeholder="Name" required>
                        </div>
                        <div class="form-group">
                            <label for="">Email *</label>
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <label for="">Contact No. *</label>
                            <input type="tel" name="contact_no" class="form-control" placeholder="Contact no." required>
                        </div>
                        <div class="form-group">
                            <label for="">Country *</label>
                            @include('front.elements.country')
                        </div>
                        <div class="form-group lg:col-2">
                            <label for="">Address *</label>
                            <textarea name="address" id="" cols="30" rows="3" class="form-control" placeholder="Address"
                            required></textarea>
                        </div>
                    </div>

                    @include('front.elements.recaptcha')
                    <button class="btn btn-theme">Submit</button>
                </form>
            </div>

            <aside>
                <div class="border-light p-2">
                    <h2 class="fs-lg text-primary bold">{{ $trip->name }}</h2>
                    <div class="card-body">
                        <p>{{ $trip->duration }} Days</p>
                        <!-- <b>Earliest Fixed Depature Date</b>
                        <p>1 Jan 2020</p> -->
                        @if($trip->offer_price)
                        <b>USD {{ $trip->offer_price }}</b> per person
                        @endif
                    </div>
                </div>
            </aside>
        </div>
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
  });
</script>
@endpush