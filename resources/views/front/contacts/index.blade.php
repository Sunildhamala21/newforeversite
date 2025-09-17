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
@section('title', 'Contact Us')
@section('content')
    <x-hero title="Contact Us" />

    <section class="py-20 bg-gray-50">
        <div class="container">
            <div class="grid gap-10 md:grid-cols-2">
                <div>
                    <p class="mb-4">Tell us more about your interest and we will respond your query within 12 hours !
                    </p>
                    <div class="mb-8">
                        <form id="captcha-form"
                              action="{{ route('front.contact.store') }}"
                              method="POST">
                            @csrf
                            <div class="mb-4 form-group">
                                <label for="name" class="text-sm">Name</label>
                                {{-- <div class="flex">
                                <div class="flex items-center justify-center px-2 bg-primary">
                                    <svg class="w-4 h-4 text-white">
                                        <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#users" />
                                    </svg>
                                </div> --}}
                                <input type="text"
                                       name="name"
                                       required
                                       class="form-control"
                                       id="name"
                                       placeholder="Name">
                                {{-- </div> --}}
                            </div>
                            <div class="mb-4 form-group">
                                <label for="email" class="text-sm">E-mail</label>
                                {{-- <div class="flex">
                                <div class="flex items-center justify-center px-2 bg-primary">
                                    <svg class="w-4 h-4 text-white">
                                        <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#mail" />
                                    </svg>
                                </div> --}}
                                <input type="email"
                                       name="email"
                                       required
                                       class="form-control"
                                       id="email"
                                       placeholder="Email">
                                {{-- </div> --}}
                            </div>
                            <div class="mb-4 form-group">
                                <label for="country" class="text-sm">Country</label>
                                {{-- <div class="flex">
                                <div class="flex items-center justify-center px-2 bg-primary">
                                    <svg class="w-4 h-4 text-white">
                                        <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#flag" />
                                    </svg>
                                </div> --}}
                                <input type="text"
                                       name="country"
                                       id="country"
                                       required
                                       name="country"
                                       class="form-control"
                                       list="countries"
                                       placeholder="Country">
                                {{-- </div> --}}
                            </div>
                            <div class="mb-4 form-group">
                                <label for="phone" class="text-sm">Phone Number</label>
                                {{-- <div class="flex">
                                <div class="flex items-center justify-center px-2 bg-primary">
                                    <svg class="w-4 h-4 text-white">
                                        <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#phone" />
                                    </svg>
                                </div> --}}
                                <input type="tel"
                                       name="phone"
                                       required
                                       class="block form-control"
                                       id="phone"
                                       placeholder="Phone No.">
                                {{-- </div> --}}
                            </div>
                            <div class="mb-4 form-group">
                                <label for="" class="text-sm">Message</label>
                                <textarea class="block form-control"
                                          required
                                          name="message"
                                          id="message"
                                          rows="5"
                                          placeholder="Message"></textarea>
                            </div>
                            <div class="mb-4 form-group">
                                <input type="hidden"
                                       id="recaptcha"
                                       name="g-recaptcha-response">
                                @include('front.elements.recaptcha')
                                <button type="submit" class="btn btn-primary">Send</button>
                            </div>
                        </form>
                    </div>

                    <datalist id="countries">
                        <option value="Afghanistan">
                        <option value="Albania">
                        <option value="Algeria">
                        <option value="American Samoa">
                        <option value="Andorra">
                        <option value="Angola">
                        <option value="Anguilla">
                        <option value="Antarctica">
                        <option value="Antigua and Barbuda">
                        <option value="Argentina">
                        <option value="Armenia">
                        <option value="Aruba">
                        <option value="Australia">
                        <option value="Austria">
                        <option value="Azerbaijan">
                        <option value="Bahamas">
                        <option value="Bahrain">
                        <option value="Bangladesh">
                        <option value="Barbados">
                        <option value="Belarus">
                        <option value="Belgium">
                        <option value="Belize">
                        <option value="Benin">
                        <option value="Bermuda">
                        <option value="Bhutan">
                        <option value="Bolivia">
                        <option value="Bosnia and Herzegovina">
                        <option value="Botswana">
                        <option value="Bouvet Island">
                        <option value="Brazil">
                        <option value="British Indian Ocean Territory">
                        <option value="Brunei Darussalam">
                        <option value="Bulgaria">
                        <option value="Burkina Faso">
                        <option value="Burundi">
                        <option value="Cambodia">
                        <option value="Cameroon">
                        <option value="Canada">
                        <option value="Cape Verde">
                        <option value="Cayman Islands">
                        <option value="Central African Republic">
                        <option value="Chad">
                        <option value="Chile">
                        <option value="China">
                        <option value="Christmas Island">
                        <option value="Cocos (Keeling) Islands">
                        <option value="Colombia">
                        <option value="Comoros">
                        <option value="Congo">
                        <option value="Congo, The Democratic Republic of The">
                        <option value="Cook Islands">
                        <option value="Costa Rica">
                        <option value="Cote D'ivoire">
                        <option value="Croatia">
                        <option value="Cuba">
                        <option value="Cyprus">
                        <option value="Czech Republic">
                        <option value="Denmark">
                        <option value="Djibouti">
                        <option value="Dominica">
                        <option value="Dominican Republic">
                        <option value="Ecuador">
                        <option value="Egypt">
                        <option value="El Salvador">
                        <option value="Equatorial Guinea">
                        <option value="Eritrea">
                        <option value="Estonia">
                        <option value="Ethiopia">
                        <option value="Falkland Islands (Malvinas)">
                        <option value="Faroe Islands">
                        <option value="Fiji">
                        <option value="Finland">
                        <option value="France">
                        <option value="French Guiana">
                        <option value="French Polynesia">
                        <option value="French Southern Territories">
                        <option value="Gabon">
                        <option value="Gambia">
                        <option value="Georgia">
                        <option value="Germany">
                        <option value="Ghana">
                        <option value="Gibraltar">
                        <option value="Greece">
                        <option value="Greenland">
                        <option value="Grenada">
                        <option value="Guadeloupe">
                        <option value="Guam">
                        <option value="Guatemala">
                        <option value="Guinea">
                        <option value="Guinea-bissau">
                        <option value="Guyana">
                        <option value="Haiti">
                        <option value="Heard Island and Mcdonald Islands">
                        <option value="Holy See (Vatican City State)">
                        <option value="Honduras">
                        <option value="Hong Kong">
                        <option value="Hungary">
                        <option value="Iceland">
                        <option value="India">
                        <option value="Indonesia">
                        <option value="Iran, Islamic Republic of">
                        <option value="Iraq">
                        <option value="Ireland">
                        <option value="Israel">
                        <option value="Italy">
                        <option value="Jamaica">
                        <option value="Japan">
                        <option value="Jordan">
                        <option value="Kazakhstan">
                        <option value="Kenya">
                        <option value="Kiribati">
                        <option value="Korea, Democratic People's Republic of">
                        <option value="Korea, Republic of">
                        <option value="Kuwait">
                        <option value="Kyrgyzstan">
                        <option value="Lao People's Democratic Republic">
                        <option value="Latvia">
                        <option value="Lebanon">
                        <option value="Lesotho">
                        <option value="Liberia">
                        <option value="Libyan Arab Jamahiriya">
                        <option value="Liechtenstein">
                        <option value="Lithuania">
                        <option value="Luxembourg">
                        <option value="Macao">
                        <option value="Macedonia, The Former Yugoslav Republic of">
                        <option value="Madagascar">
                        <option value="Malawi">
                        <option value="Malaysia">
                        <option value="Maldives">
                        <option value="Mali">
                        <option value="Malta">
                        <option value="Marshall Islands">
                        <option value="Martinique">
                        <option value="Mauritania">
                        <option value="Mauritius">
                        <option value="Mayotte">
                        <option value="Mexico">
                        <option value="Micronesia, Federated States of">
                        <option value="Moldova, Republic of">
                        <option value="Monaco">
                        <option value="Mongolia">
                        <option value="Montserrat">
                        <option value="Morocco">
                        <option value="Mozambique">
                        <option value="Myanmar">
                        <option value="Namibia">
                        <option value="Nauru">
                        <option value="Nepal">
                        <option value="Netherlands">
                        <option value="Netherlands Antilles">
                        <option value="New Caledonia">
                        <option value="New Zealand">
                        <option value="Nicaragua">
                        <option value="Niger">
                        <option value="Nigeria">
                        <option value="Niue">
                        <option value="Norfolk Island">
                        <option value="Northern Mariana Islands">
                        <option value="Norway">
                        <option value="Oman">
                        <option value="Pakistan">
                        <option value="Palau">
                        <option value="Palestinian Territory, Occupied">
                        <option value="Panama">
                        <option value="Papua New Guinea">
                        <option value="Paraguay">
                        <option value="Peru">
                        <option value="Philippines">
                        <option value="Pitcairn">
                        <option value="Poland">
                        <option value="Portugal">
                        <option value="Puerto Rico">
                        <option value="Qatar">
                        <option value="Reunion">
                        <option value="Romania">
                        <option value="Russian Federation">
                        <option value="Rwanda">
                        <option value="Saint Helena">
                        <option value="Saint Kitts and Nevis">
                        <option value="Saint Lucia">
                        <option value="Saint Pierre and Miquelon">
                        <option value="Saint Vincent and The Grenadines">
                        <option value="Samoa">
                        <option value="San Marino">
                        <option value="Sao Tome and Principe">
                        <option value="Saudi Arabia">
                        <option value="Senegal">
                        <option value="Serbia and Montenegro">
                        <option value="Seychelles">
                        <option value="Sierra Leone">
                        <option value="Singapore">
                        <option value="Slovakia">
                        <option value="Slovenia">
                        <option value="Solomon Islands">
                        <option value="Somalia">
                        <option value="South Africa">
                        <option value="South Georgia and The South Sandwich Islands">
                        <option value="Spain">
                        <option value="Sri Lanka">
                        <option value="Sudan">
                        <option value="Suriname">
                        <option value="Svalbard and Jan Mayen">
                        <option value="Swaziland">
                        <option value="Sweden">
                        <option value="Switzerland">
                        <option value="Syrian Arab Republic">
                        <option value="Taiwan, Province of China">
                        <option value="Tajikistan">
                        <option value="Tanzania, United Republic of">
                        <option value="Thailand">
                        <option value="Timor-leste">
                        <option value="Togo">
                        <option value="Tokelau">
                        <option value="Tonga">
                        <option value="Trinidad and Tobago">
                        <option value="Tunisia">
                        <option value="Turkey">
                        <option value="Turkmenistan">
                        <option value="Turks and Caicos Islands">
                        <option value="Tuvalu">
                        <option value="Uganda">
                        <option value="Ukraine">
                        <option value="United Arab Emirates">
                        <option value="United Kingdom">
                        <option value="United States">
                        <option value="United States Minor Outlying Islands">
                        <option value="Uruguay">
                        <option value="Uzbekistan">
                        <option value="Vanuatu">
                        <option value="Venezuela">
                        <option value="Viet Nam">
                        <option value="Virgin Islands, British">
                        <option value="Virgin Islands, U.S">
                        <option value="Wallis and Futuna">
                        <option value="Western Sahara">
                        <option value="Yemen">
                        <option value="Zambia">
                        <option value="Zimbabwe">
                    </datalist>
                </div>
                <aside>
                    {{-- Left --}}
                    <div>
                        <h2 class="mb-8 text-2xl font-semibold font-display">Where are we?</h2>
                        <div class="flex flex-col gap-4 mb-10">
                            <div class="flex gap-4">
                                <div class="flex items-center justify-center w-12 h-12 rounded-lg shrink-0 bg-gray">
                                    <svg class="w-6 h-6 text-primary"
                                         fill="currentColor"
                                         viewBox="0 0 24 24"
                                         xmlns="http://www.w3.org/2000/svg"
                                         aria-hidden="true">
                                        <path clip-rule="evenodd"
                                              fill-rule="evenodd"
                                              d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="mb-2 text-lg font-semibold text-gray-600">Location</h3>
                                    <p>Our strategic location in the heart of Thamel, Kathmandu ensures easy access to the city's amenities, making it convenient for you to explore local markets, cultural
                                        sites, and prepare for your upcoming trek in the majestic Himalayas.
                                    </p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="flex items-center justify-center w-12 h-12 rounded-lg shrink-0 bg-gray">
                                    <svg class="w-6 h-6 text-primary"
                                         fill="currentColor"
                                         viewBox="0 0 24 24"
                                         xmlns="http://www.w3.org/2000/svg"
                                         aria-hidden="true">
                                        <path clip-rule="evenodd"
                                              fill-rule="evenodd"
                                              d="M8.161 2.58a1.875 1.875 0 011.678 0l4.993 2.498c.106.052.23.052.336 0l3.869-1.935A1.875 1.875 0 0121.75 4.82v12.485c0 .71-.401 1.36-1.037 1.677l-4.875 2.437a1.875 1.875 0 01-1.676 0l-4.994-2.497a.375.375 0 00-.336 0l-3.868 1.935A1.875 1.875 0 012.25 19.18V6.695c0-.71.401-1.36 1.036-1.677l4.875-2.437zM9 6a.75.75 0 01.75.75V15a.75.75 0 01-1.5 0V6.75A.75.75 0 019 6zm6.75 3a.75.75 0 00-1.5 0v8.25a.75.75 0 001.5 0V9z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="mb-2 text-lg font-semibold text-gray-600">Accessibility</h3>
                                    <p> Situated just a short distance from Tribhuvan International Airport, reaching our office is a hassle-free experience. For those coming from within Kathmandu, our
                                        central location means you can easily access our office by taxi, public transportation, or even on foot.</p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="flex items-center justify-center w-12 h-12 rounded-lg shrink-0 bg-gray">
                                    <svg class="w-6 h-6 text-primary"
                                         fill="currentColor"
                                         xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 512 512">
                                        <path d="M135.2 117.4L109.1 192H402.9l-26.1-74.6C372.3 104.6 360.2 96 346.6 96H165.4c-13.6 0-25.7 8.6-30.2 21.4zM39.6 196.8L74.8 96.3C88.3 57.8 124.6 32 165.4 32H346.6c40.8 0 77.1 25.8 90.6 64.3l35.2 100.5c23.2 9.6 39.6 32.5 39.6 59.2V400v48c0 17.7-14.3 32-32 32H448c-17.7 0-32-14.3-32-32V400H96v48c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32V400 256c0-26.7 16.4-49.6 39.6-59.2zM128 288a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm288 32a32 32 0 1 0 0-64 32 32 0 1 0 0 64z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="mb-2 text-lg font-semibold text-gray-600">Driving directions</h3>
                                    <p></p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="flex items-center justify-center w-12 h-12 rounded-lg shrink-0 bg-gray">
                                    <svg class="w-6 h-6 text-primary"
                                         fill="currentColor"
                                         xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 320 512"
                                         aria-hidden="true">
                                        <path d="M208 96c26.5 0 48-21.5 48-48S234.5 0 208 0s-48 21.5-48 48 21.5 48 48 48zm94.5 149.1l-23.3-11.8-9.7-29.4c-14.7-44.6-55.7-75.8-102.2-75.9-36-.1-55.9 10.1-93.3 25.2-21.6 8.7-39.3 25.2-49.7 46.2L17.6 213c-7.8 15.8-1.5 35 14.2 42.9 15.6 7.9 34.6 1.5 42.5-14.3L81 228c3.5-7 9.3-12.5 16.5-15.4l26.8-10.8-15.2 60.7c-5.2 20.8.4 42.9 14.9 58.8l59.9 65.4c7.2 7.9 12.3 17.4 14.9 27.7l18.3 73.3c4.3 17.1 21.7 27.6 38.8 23.3 17.1-4.3 27.6-21.7 23.3-38.8l-22.2-89c-2.6-10.3-7.7-19.9-14.9-27.7l-45.5-49.7 17.2-68.7 5.5 16.5c5.3 16.1 16.7 29.4 31.7 37l23.3 11.8c15.6 7.9 34.6 1.5 42.5-14.3 7.7-15.7 1.4-35.1-14.3-43zM73.6 385.8c-3.2 8.1-8 15.4-14.2 21.5l-50 50.1c-12.5 12.5-12.5 32.8 0 45.3s32.7 12.5 45.2 0l59.4-59.4c6.1-6.1 10.9-13.4 14.2-21.5l13.5-33.8c-55.3-60.3-38.7-41.8-47.4-53.7l-20.7 51.5z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="mb-2 text-lg font-semibold text-gray-600">Walking directions</h3>
                                    <p>If you're walking from Kathmandu or any hotel, please follow google map given in our website.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 border rounded-t-lg lg:p-10 bg-light border-primary">
                        <p class="mb-6 text-xl text-primary">{{ config('app.name') }}</p>
                        <div class="flex mb-2 experts-phone">
                            <a href="tel:+977 9851046017" class="flex aic">
                                <svg class="w-6 h-6 mr-2 text-primary">
                                    <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#locationmarker" />
                                </svg>
                                </svg>
                                {{ Setting::get('address') ?? '' }}
                            </a>
                        </div>
                        <div class="flex mb-2 experts-phone">
                            <a href="tel:{{ Setting::get('moblie1') ?? '' }}" class="flex aic">
                                <svg class="w-6 h-6 mr-2 text-primary">
                                    <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#phone" />
                                </svg>
                                {{ Setting::get('mobile1') ?? '' }}
                            </a>
                        </div>
                        <div class="flex experts-phone">
                            <a href="mailto:{{ Setting::get('email') ?? '' }}" class="flex aic">
                                <svg class="w-6 h-6 mr-2 text-primary">
                                    <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#mail" />
                                </svg>
                                {!! str_replace(['@', '.'], ['<wbr>@', '<wbr>.'], Setting::get('email') ?? '') !!}
                            </a>
                        </div>
                    </div>
                    <div class="flex justify-center gap-4 p-4 mb-8 text-white rounded-b-lg bg-primary">
                        <a href="{{ Setting::get('facebook') ?? '' }}" class="hover:text-accent">
                            <svg class="w-6 h-6">
                                <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#facebookmessenger" />
                            </svg>
                        </a>
                        <a href="{{ Setting::get('viber') ?? '' }}" class="hover:text-accent">
                            <svg class="w-6 h-6">
                                <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#viber" />
                            </svg>
                        </a>
                        <a href="{{ Setting::get('whatsapp') ?? '' }}" class="hover:text-accent">
                            <svg class="w-6 h-6">
                                <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#whatsapp" />
                            </svg>
                        </a>
                        @if (Setting::get('skype'))
                            <a href="{{ Setting::get('skype') }}" class="hover:text-accent">
                                <svg class="w-6 h-6">
                                    <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#skype" />
                                </svg>
                            </a>
                        @endif
                        @if (Setting::get('weixin'))
                            <a href="{{ Setting::get('weixin') ?? '' }}" class="hover:text-accent">
                                <svg class="w-6 h-6">
                                    <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#weixin" />
                                </svg>
                            </a>
                        @endif
                    </div>
                </aside>
            </div>
        </div>
    </section>

    {!! Setting::get('contactUs') ? Setting::get('contactUs')['map'] : '' !!}
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
