@extends('layouts.front_inner')
@section('title', 'Activities')
@section('content')
    <x-hero title="Activities" />

    <section>

        <div class="bg-light">
            <div class="container py-20">
                @if (isset($keyword) && !empty($keyword))
                    <p id="search-p" class="fs-sm">Search results for "<strong>{{ strtoupper($keyword) }}</strong>"</p>
                @endif

                <div id="activity-card-block" class="grid gap-8 mb-5 md:grid-cols-2 lg:grid-cols-4">
                    @forelse ($activities as $activity)
                        @include('front.elements.activity-card', ['activity' => $activity])
                    @empty
                    @endforelse
                </div>
                @if ($activities->nextPageUrl())
                    <div class="flex items-center" style="justify-content: center; margin-top: 50px;">
                        <div id="spinner-block"></div>
                        <button id="show-more" class="btn btn-accent" style="display: block;">show more</button>
                    </div>
                @endif
            </div>
        </div>
    </section>

    @include('front.elements.plan_trip')

    <!-- Trip of the month -->
    <div class="py-10 text-white bg-primary">
        <div class="container">

            <p class="mb-2 text-2xl text-white font-handwriting">This doesn't get any better</p>

            <div class="flex">
                <h2 class="relative pr-10 text-3xl font-bold uppercase lg:text-5xl font-display">
                    Trip of the Activities
                    <div class="absolute right-0 w-6 h-1 rounded-sm top-1/2 bg-accent"></div>
                </h2>
            </div>

            <div class="flex justify-end gap-4 trips-month-slider-controls">
                <button class="p-2 rounded-lg bg-light">
                    <svg class="w-6 h-6 text-accent">
                        <use xlink:href="{{ asset('assets/front/img/sprite.svg#arrownarrowleft') }}" />
                    </svg>
                </button>
                <button class="p-2 rounded-lg bg-light">
                    <svg class="w-6 h-6 text-accent">
                        <use xlink:href="{{ asset('assets/front/img/sprite.svg#arrownarrowright') }}" />
                    </svg>
                </button>
            </div>

            <div class="trips-month-slider">
                @forelse ($block_3_trips as $block3tour)
                    @include('front.elements.tour_card_slider', ['tour' => $block3tour])
                @empty
                @endforelse
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/tiny-slider@2.9.3/dist/tiny-slider.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script type="text/javascript">
        //     let xhr;
        //     let typingTimer;
        //     const debounceTime = 500;
        let totalPage = "{{ $activities->total() }}";
        let nextPage = "{{ $activities->nextPageUrl() }}"
        let currentPage = "{{ $activities->currentPage() }}";
        //     $('html, body').animate({
        //         scrollTop: $("#searchDiv").offset().top
        //     }, "fast");

        //   $(".custom-select").on('change', function(event) {
        //     filter();
        //   });

        //   $("#search-keyword").on('keyup', function(event) {
        //     handleKeyDown();
        //   });

        //   function handleKeyDown() {
        //     clearTimeout(typingTimer);
        //     typingTimer = setTimeout(performSearch, debounceTime);
        // }

        function performSearch() {
            if (xhr && xhr.readyState !== 4) {
                // If there is an ongoing AJAX request, abort it
                xhr.abort();
            }

            filter();
        }

        $("#show-more").on('click', async function(event) {
            event.preventDefault();
            if (nextPage) {
                currentPage++;
                await paginate(currentPage);
                if (!nextPage) {
                    $("#show-more").hide();
                }
            }
        });

        async function paginate(page) {
            return new Promise((resolve, reject) => {
                const url = "{!! route('front.activities.index') !!}" + "?page=" + page;
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                    async: "false",
                    beforeSend: function(xhr) {
                        var spinner = '<button style="margin:0 auto;" class="text-white btn btn-sm btn-primary" type="button" disabled>\
                                                                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>\
                                                                                Loading Activities...\
                                                                                </button>';
                        $("#spinner-block").html(spinner);
                        $("#show-more").hide();
                    },
                    success: function(res) {
                        if (res.success) {
                            $("#activity-card-block").append(res.data);
                            nextPage = res.pagination.next_page;
                        }
                    }
                }).done(function(data) {
                    $("#spinner-block").html('');
                    $("#show-more").show();
                    resolve(true);
                });
            });
        }

        const monthSlider = tns({
            container: '.trips-month-slider',
            nav: false,
            controlsContainer: '.trips-month-slider-controls',
            autoplay: true,
            autoplayButtonOutput: false
        })

        function filter() {
            var keyword = $("#search-keyword").val();
            // var activity_id = $("#select-activity").val();
            // var sortBy = $("#select-sort").val();
            // var url_query = "keyword=" + activity_id + "&act=" + activity_id + "&price=" + sortBy;
            var url_query = "keyword=" + keyword;

            var filter_url = '{{ route('front.activities.search') }}' + '?' + url_query;
            // window.location.href = filter_url;
            const url = "{!! route('front.activities.search') !!}" + "?" + url_query;
            xhr = $.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                async: "false",
                beforeSend: function(xhr) {
                    var spinner = '<button style="margin:0 auto;" class="text-white btn btn-sm btn-primary" type="button" disabled>\
                                                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>\
                                                                            Loading Destinations...\
                                                                            </button>';
                    $("#spinner-block").html(spinner);
                    $("#show-more").hide();
                },
                success: function(res) {
                    if (res.success) {
                        $("#activity-card-block").html(res.data);
                        totalPage = res.pagination.total;
                        currentPage = res.pagination.current_page;
                        nextPage = res.pagination.next_page;
                    }

                }
            }).done(function(data) {
                $("#spinner-block").html('');
                if (!nextPage) {
                    $("#show-more").hide();
                } else {

                    $("#show-more").show();
                }
            });
        }
    </script>
@endpush
