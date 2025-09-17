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
@push('styles')
    <style>
    </style>
@endpush

@section('content')
    <!-- Hero -->
    <section class="relative hero hero-alt">
        <div class="absolute overlay">
            <div class="container pb-8">
                <h1 style="text-align: center;">Thank you</h1>
            </div>
        </div>
    </section>

    <section class="py-20">
        <div class="container" style="padding-top: 20px;max-width: 1100px;">
            <div class="mb-4">
                <div class="relative mb-4 tour-details-section">
                    <div class="mb-10 text-center">
                        <svg class="w-20 h-20 mx-auto text-primary"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.5"
                             viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg"
                             aria-hidden="true">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75A2.25 2.25 0 0116.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23H5.904M14.25 9h2.25M5.904 18.75c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 01-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 10.203 4.167 9.75 5 9.75h1.053c.472 0 .745.556.5.96a8.958 8.958 0 00-1.302 4.665c0 1.194.232 2.333.654 3.375z">
                            </path>
                        </svg>
                    </div>
                    <div class="mx-auto mb-4 prose text-center">
                        <p class="mb-4 font-bold lead">Thank you so much for your travel interest with {{ config('app.name') }}.</p>
                        <p>We have received your travel inquiry. After reviewing, one of our travel consultants will get back to you within 24 hours. If it is
                            urgent, please call us at one of our global
                            direct lines provided on our website that matches your time zone or schedule a call.</p>

                        <p class="mb-4 font-bold lead">Haven’t heard from us yet?</p>
                        <p>We have replied to your travel query in your email address. If you haven’t seen our email in your inbox within 24 hours, kindly check
                            your SPAM or JUNK FOLDER to trace our reply
                            and make sure to add our e-mail to your address book. This will avoid our future emails being filtered as SPAM or JUNK.</p>

                        <hr>

                        <p class="mb-4 lead">Keep in touch</p>
                        <p>Remain in constant touch with us to get plenty of attractive deals and offers including exclusive travel packages at various
                            destinations.</p>
                    </div>
                    <p class="flex justify-center gap-8 text-accent">
                        <a href="{{ Setting::get('facebook') }}"
                           class="inline-flex items-center gap-2"
                           target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="currentColor"
                                 class="w-4 h-4"
                                 viewBox="0 0 16 16">
                                <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z" />
                            </svg>
                            Facebook
                        </a>
                        <a href=""
                           class="inline-flex items-center gap-2"
                           target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="currentColor"
                                 class="w-4 h-4"
                                 viewBox="0 0 16 16">
                                <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146zm4.943 12.248V6.169H2.542v7.225h2.401zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248-.822 0-1.359.54-1.359 1.248 0 .694.521 1.248 1.327 1.248h.016zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016a5.54 5.54 0 0 1 .016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225h2.4z" />
                            </svg>
                            Linkedin
                        </a>
                        <a href="{{ Setting::get('twitter') }}"
                           class="inline-flex items-center gap-2"
                           target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="currentColor"
                                 class="w-4 h-4"
                                 viewBox="0 0 16 16">
                                <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z" />
                            </svg>
                            Twitter
                        </a>
                        <a href="{{ Setting::get('instagram') }}"
                           class="inline-flex items-center gap-2"
                           target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="currentColor"
                                 class="w-4 h-4"
                                 viewBox="0 0 16 16">
                                <path
                                      d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z" />
                            </svg>
                            Instagram
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
