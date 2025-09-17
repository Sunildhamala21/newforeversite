<!-- Newsletter -->

<div class="pt-10 bg-gray-100 border-t border-gray-200">
    <div class="container pb-10">
        <div class="grid gap-8 lg:grid-cols-2">
            <div>
                <h2 class="mb-2 text-3xl font-display text-primary">Join our Newsletter</h2>
                <div class="text-sm">Sign up to stay updated with latest offers, recent events and more news.</div>
            </div>
            <div>
                <form class="flex flex-wrap gap-2" id="email-subscribe-form"
                    action="{{ route('front.email-subscribers.store') }}" method="POST">
                    <label for="emailsub" class="sr-only">Email</label>
                    <input type="email" name="email" id="emailsub" class="p-4 rounded-lg lg:text-lg border-accent"
                        placeholder="Enter your email" required>
                    <button type="submit"
                        class="inline-block px-4 py-4 tracking-wide text-white no-underline uppercase bg-green-600 rounded-lg hover:bg-green-700 font-display">Subscribe</button>
                </form>
            </div>
        </div>
    </div>
    <img src="{{ asset('assets/front/img/webpage_art.webp') }}" width="1920" height="209"
        alt="Art representing various natural and cultutal heritages of Nepal"
        class="object-cover w-full h-auto min-h-20" loading="lazy">
</div><!-- Newsletter -->
<!-- Footer -->

<footer class="text-white/70 bg-primary">
    {{-- <div class="container" style="margin-bottom: 15px;">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <a href="{{ route('front.makeapayment') }}" class="btn btn-accent">Make a Payment</a>
        </div>
    </div> --}}

    <div class="container">
        <div class="grid gap-4 sm:gap-10 sm:grid-cols-2 lg:grid-cols-4">
            <div class="mb-4">
                <h2 class="text-2xl text-white font-display">Trekking Destination</h2>
                <ul>
                    @if ($footer1)
                    @foreach ($footer1 as $menu)
                      <li class="text-sm">
                        <a href="{!! ($menu->link)?$menu->link:'javascript:;' !!}">{{ $menu->name }}</a>
                      </li>
                    @endforeach
                    @endif
                </ul>
            </div>
            <div class="mb-4">
                <h2 class="text-2xl text-white font-display">Trekking Activities</h2>
                <ul>
                    @if ($footer2)
                    @foreach ($footer2 as $menu)
                      <li class="text-sm">
                        <a href="{!! ($menu->link)?$menu->link:'javascript:;' !!}">{{ $menu->name }}</a>
                      </li>
                    @endforeach
                    @endif
                </ul>
            </div>
            <div class="mb-4">
                <h2 class="text-2xl text-white font-display">Trekking Regions</h2>
                <ul>
                    @if ($footer3)
                    @foreach ($footer3 as $menu)
                      <li class="text-sm">
                        <a href="{!! ($menu->link)?$menu->link:'javascript:;' !!}">{{ $menu->name }}</a>
                      </li>
                    @endforeach
                    @endif
                </ul>
            </div>
            
            <!-- <div class="p-6 bg-primary-dark rounded-xl">
                <h2 class="flex gap-2 text-xl text-white/80 font-display">
                    <img src="{{ asset('assets/front/img/flag-th.webp') }}" alt="Thailand"
                        class="object-cover object-left w-8 h-6 rounded">
                    Thailand Contact
                </h2>
                <ul class="icon-list">
                    <li class="flex">
                        <svg class="flex-shrink-0 w-5 h-5 mr-1 ">
                            <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#locationmarker" />
                        </svg>
                        <span class="text-sm">59 Village No. 7, Bong Tai Subdistrict, Sawang Daen Din District, Sakon
                            Nakhon Province 47110</span>
                    </li>
                    <li class="flex">
                        <svg class="flex-shrink-0 w-5 h-5 mr-1 ">
                            <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#phone" />
                        </svg>
                        <a class="text-sm" href="tel:+66986947488">+66986947488 Titirat Ounnawong (ฐิติรัตน์
                            อุณวงค์)</a>
                    </li>
                    <li class="flex">
                        <svg class="flex-shrink-0 w-5 h-5 mr-1 ">
                            <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#mail" />
                        </svg>
                        <a class="text-sm" href="mailto:info@hftreks.com">info@hftreks.com</a>
                    </li>
                </ul>
            </div>
            <div class="p-6 bg-primary-dark rounded-xl">
                <h2 class="flex gap-2 text-xl text-white/80 font-display">
                    <img src="{{ asset('assets/front/img/flag-ae.webp') }}" alt="Dubai"
                        class="object-cover object-left w-8 h-6 rounded">
                    Dubai Contact
                </h2>
                <ul class="icon-list">
                    <li class="flex">
                        <svg class="flex-shrink-0 w-5 h-5 mr-1 ">
                            <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#locationmarker" />
                        </svg>
                        <span class="text-sm">Mohamed bin zayed city Zone 8, villa 116/ D5 Abudhabi, UAE</span>
                    </li>
                    <li class="flex">
                        <svg class="flex-shrink-0 w-5 h-5 mr-1 ">
                            <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#phone" />
                        </svg>
                        <a class="text-sm" href="tel:971502876885">971502876885 (Dhruba Lamichhane)</a>
                    </li>
                    <li class="flex">
                        <svg class="flex-shrink-0 w-5 h-5 mr-1 ">
                            <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#mail" />
                        </svg>
                        <a class="text-sm" href="mailto:{{ Setting::get('email') }}">{{ Setting::get('email') }}</a>
                    </li>
                </ul>
            </div>
            <div class="p-6 bg-primary-dark rounded-xl">
                <h2 class="flex gap-2 text-xl text-white/80 font-display">
                    <img src="{{ asset('assets/front/img/flag-eu.webp') }}" alt="Europe"
                        class="object-cover object-left w-8 h-6 rounded">
                    Europe contact
                </h2>
                <ul class="icon-list">
                    <li class="flex">
                        <svg class="flex-shrink-0 w-5 h-5 mr-1 ">
                            <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#locationmarker" />
                        </svg>
                        <span class="text-sm">Kegelhofstraße 38, 20251 Hamburg Eppendorf, Germany</span>
                    </li>
                    <li class="flex">
                        <svg class="flex-shrink-0 w-5 h-5 mr-1 ">
                            <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#phone" />
                        </svg>
                        <a class="text-sm" href="tel:+4915732285145">+4915732285145 (Pratikshya Bhatta)</a>
                    </li>
                    <li class="flex">
                        <svg class="flex-shrink-0 w-5 h-5 mr-1 ">
                            <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#mail" />
                        </svg>
                        <a class="text-sm" href="mailto:{{ Setting::get('email') }}">{{ Setting::get('email') }}</a>
                    </li>
                </ul>
            </div> -->

            <div class="p-6 bg-primary-dark rounded-xl">
                <h2 class="flex gap-2 text-xl text-white/80 font-display">
                    <img src="{{ asset('assets/front/img/flag-np.webp') }}" alt="Nepal"
                        class="object-contain object-left w-8 h-8 rounded">
                    Head Office, Nepal
                </h2>
                <ul class="icon-list">
                    <li class="flex">
                        <svg class="flex-shrink-0 w-5 h-5 mr-1">
                            <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#locationmarker" />
                        </svg>
                        <span class="text-sm">{{ Setting::get('address') }}</span>
                    </li>
                    <li class="flex">
                        <svg class="flex-shrink-0 w-5 h-5 mr-1">
                            <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#phone" />
                        </svg>
                        <a class="text-sm"
                            href="tel:{{ Setting::get('mobile1') }}">{{ Setting::get('mobile1') }}</a>
                    </li>
                    <li class="flex">
                        <svg class="flex-shrink-0 w-5 h-5 mr-1">
                            <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#mail" />
                        </svg>
                        <a class="text-sm" href="mailto:{{ Setting::get('email') }}">{{ Setting::get('email') }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="bottom">
        <div class="container">
            <ul class="flex gap-2 mb-4">
                <li>
                    <a href="{{ Setting::get('facebook') }}"
                        class="inline-block p-2 rounded-lg text-white/80 hover:text-white bg-primary-dark hover:bg-accent"
                        aria-label="Facebook">
                        <svg class="w-6 h-6">
                            <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#facebook" />
                        </svg>
                    </a>
                </li>
                <li>
                    <a href="{{ Setting::get('twitter') }}"
                        class="inline-block p-2 rounded-lg text-white/80 hover:text-white bg-primary-dark hover:bg-accent"
                        aria-label="Twitter">
                        <svg class="w-6 h-6">
                            <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#twitter" />
                        </svg>
                    </a>
                </li>
                <li>
                    <a href="{{ Setting::get('instagram') }}"
                        class="inline-block p-2 rounded-lg text-white/80 hover:text-white bg-primary-dark hover:bg-accent"
                        aria-label="Instagram">
                        <svg class="w-6 h-6">
                            <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#instagram" />
                        </svg>
                    </a>
                </li>
                <li>
                    <a href="{{ Setting::get('whatsapp') }}"
                        class="inline-block p-2 rounded-lg text-white/80 hover:text-white bg-primary-dark hover:bg-accent"
                        aria-label="Whatsapp">
                        <svg class="w-6 h-6">
                            <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#whatsapp" />
                        </svg>
                    </a>
                </li>
                <li>
                    <a href="{{ Setting::get('viber') }}"
                        class="inline-block p-2 rounded-lg text-white/80 hover:text-white bg-primary-dark hover:bg-accent"
                        aria-label="Viber">
                        <svg class="w-6 h-6">
                            <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#viber" />
                        </svg>
                    </a>
                </li>
            </ul>

            <div>
                <ul>
                    <div id="TA_certificateOfExcellence725" class="TA_certificateOfExcellence">
                        <ul id="B8xbvF" class="TA_links OGHQJX">
                            <li id="AVxLlBOd5" class="gJ4aJZp">
                                <a target="_blank"
                                    href="https://www.tripadvisor.com/Attraction_Review-g293890-d8702133-Reviews-Himalayan_Friends_Trekking_Day_Tours-Kathmandu_Kathmandu_Valley_Bagmati_Zone_Cent.html">
                                    <img src="https://static.tacdn.com/img2/travelers_choice/widgets/tchotel_2025_L.png"
                                        alt="TripAdvisor" class="widCOEImg" id="CDSWIDCOELOGO" />
                                </a>
                            </li>
                        </ul>
                    </div>
                    <script async
                        src="https://www.jscache.com/wejs?wtype=certificateOfExcellence&amp;uniq=725&amp;locationId=25250532&amp;lang=en_US&amp;year=2025&amp;display_version=2"
                        data-loadtrk onload="this.loadtrk=true"></script>
                </ul>
            </div>


            <div class="flex justify-end gap-2">
                <img src="{{ asset('assets/front/img/card_visa.svg') }}" width="780" height="500"
                    alt="Visa" class="w-auto h-6 bg-white rounded">
                <img src="{{ asset('assets/front/img/card_mastercard.svg') }}" width="780" height="500"
                    alt="Mastercard" class="w-auto h-6 bg-white rounded">
                <img src="{{ asset('assets/front/img/card_americanexpress.svg') }}" width="780" height="500"
                    alt="American Express" class="w-auto h-6 bg-white rounded">
                <img src="{{ asset('assets/front/img/card_unionpay.svg') }}" width="780" height="500"
                    alt="UnionPay" class="w-auto h-6 bg-white rounded">
            </div>

        </div>
    </div>
    <div class="pb-20 text-xs text-center bg-primary">
        <div class="container justify-between md:flex">
            <div class="mb-2">
                All Contents &copy; 2017 to {{ date('Y') }}. All right Reserved.
            </div>
            <div class="mb-4">
                Powered by
                <a href="https://thirdeyesystem.com">Third Eye Systems</a>
            </div>
            <div class="mb-2">
                Compare <a href="https://www.kayak.co.uk/flights" target="_blank">flights</a> on 100s of sites on
                KAYAK.
            </div>

        </div>
    </div>
</footer>

<div class="py-10 bg-light">
    <div class="container">
        <ul class="flex justify-center gap-4">
            <li>
                <a href="#">
                    <img loading="lazy" src="{{ asset('assets/front/img/ng.svg') }}"
                        class="object-contain w-auto h-12 grayscale"
                        alt="Nepal Government Ministry of Culture, Tourism & Civil Aviation" width="179"
                        height="150">
                </a>
            </li>
            <li>
                <a href="#">
                    <img loading="lazy" src="{{ asset('assets/front/img/ntb.svg') }}"
                        class="object-contain w-auto h-12 grayscale" alt="Nepal Tourism Board" width="148"
                        height="150">
                </a>
            </li>
            <li>
                <a href="https://www.taan.org.np/">
                    <img loading="lazy" src="{{ asset('assets/front/img/taan.svg') }}"
                        class="object-contain w-auto h-12 grayscale" alt="Trekking Agencies' Association of Nepal"
                        width="112" height="150">
                </a>
            </li>
            <li>
                <a href="#">
                    <img loading="lazy" src="{{ asset('assets/front/img/nma.svg') }}"
                        class="object-contain w-auto h-12 grayscale" alt="Nepal Mountaineering Association"
                        width="180" height="150">
                </a>
            </li>
        </ul>
    </div>
</div>

@include('front.elements.scroll-to-top')
@include('front.elements.mobile-bottom-navigation')
<livewire:cookie-consent-banner />
