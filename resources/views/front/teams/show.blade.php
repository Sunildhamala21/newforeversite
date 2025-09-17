@extends('layouts.front_inner')
@section('content')
    <x-hero :title="$team->name" :breadcrumbs="[['url' => route('front.teams.index'), 'name' => 'Our Team']]" />

    <section class="py-5">
        <div class="container">

            <div class="tour-details-section team-member">

                <div class="row">
                    <div class="col-sm-4 col-md-3 col-lg-2">
                        <div>
                            <img class="img-fluid"
                                 src="{{ $team->imageUrl }}"
                                 alt="{{ $team->name }}"
                                 style="height: 349px; padding-top: 29px;">
                        </div>
                        <h2 class="fs-xl text-primary">{{ $team->name }}</h2>
                        <p class="fs-lg">{{ $team->position }}</p>
                        <div class="lim">
                            <?= $team->description ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
