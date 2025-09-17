<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $trip->name }}</title>
    <style>
        body {
            font-family: 'Poppins', Arial, Sans-serif;
            font-size: 15px;
            margin: 1rem;
            line-height: 1.3;
        }

        section {
            margin-bottom: 2rem;
        }

        h1,
        h2,
        h3 {
            color: #2170a5;
            page-break-before: avoid;
            break-after: avoid;
        }

        h2 {
            border-bottom: 1px solid #2170a5;
        }

        h3 {
            margin: 0 0 .3rem;
        }

        p {
            margin: 0 0 1rem;
        }

        p.controls {
            background: #eee;
            padding: 1rem;
        }

        table {
            border-top: 1px solid #2170a5;
            border-left: 1px solid #2170a5;
            border-right: 1px solid #2170a5;
        }

        table tr td {
            border-bottom: 1px solid #2170a5;
            padding: .8rem 1rem;
        }

        table tr td {
            border-bottom: 1px solid #2170a5;
            padding: .5rem 1rem;
        }

        .overview-table tr td:first-child {
            border-right: 1px solid #2170a5;
            color: #2170a5;
            font-weight: 600;
        }

        button {
            background: #2170a5;
            padding: .5rem 1rem;
            border-radius: .2rem;
            color: #ffffff;
            border: none;
            cursor: pointer;
            margin-right: 1rem;
        }

        a {
            color: #2170a5;
            text-decoration: none;
            margin-right: 1rem;
        }

        ul,
        ol {
            margin: 0 0 1rem;
        }

        @media print {
            p.controls {
                display: none;
            }
        }
    </style>
</head>

<body>
    <p class="controls">
        <a class="back" href="{{ route('front.trips.show', $trip) }}">Go back</a>
        <button onclick="window.print()">Print</button>
    </p>
    <h1>{{ $trip->name }}</h1>
    <section class="overview-table">
        <table cellspacing="0">
            <tbody>
                <tr>
                    <td>Trip code</td>
                    <td>{{ $trip->trip_code }}</td>
                </tr>
                <tr>
                    <td>Package name</td>
                    <td>{{ $trip->name }}</td>
                </tr>
                <tr>
                    <td>Duration</td>
                    <td>{{ $trip->duration }}</td>
                </tr>
                <tr>
                    <td>Max. elevation</td>
                    <td>{{ $trip->max_altitude }} m</td>
                </tr>
                <tr>
                    <td>Level</td>
                    <td>{{ $trip->difficulty_grade_value }}</td>
                </tr>
                <tr>
                    <td>Transportation</td>
                    <td>{{ $trip->trip_info->transportation ?? '' }}</td>
                </tr>
                <tr>
                    <td>Accomodation</td>
                    <td><?= $trip->trip_info->accomodation ?? '' ?></td>
                </tr>
                <tr>
                    <td>Starts at</td>
                    <td>{{ $trip->starting_point }}</td>
                </tr>
                <tr>
                    <td>Ends at</td>
                    <td>{{ $trip->ending_point }}</td>
                </tr>
                <tr>
                    <td>Trip route</td>
                    <td>{{ $trip->trip_info->trip_route ?? '' }}</td>
                </tr>
                <tr>
                    <td>Cost</td>
                    <td>USD {{ number_format($trip->offer_price) }} per person</td>
                </tr>
            </tbody>
        </table>
    </section>

    @if ($trip->trip_info)
        <section class="highlights">
            <h2>Highlights</h2>
            <ul class="highlights" style="padding: 0px;">
                <?= $trip->trip_info->highlights ?? '' ?>
            </ul>
        </section>
    @endif

    <section class="overview">
        <h2>Overview</h2>
        <p>
            <?= $trip->trip_info->overview ?? '' ?>
        </p>
    </section>

    <section class="itinerary">
        <h2>Trip Itinerary</h2>
        @foreach ($trip->trip_itineraries as $itinerary)
            <h3>Day {{ $itinerary->day }} : {{ $itinerary->name }}</h3>
            <p><?= $itinerary->description ?></p>
        @endforeach
    </section>
    <section class="inclusions">
        <h2>Inclusions</h2>
        <h3>What is included?</h3>
        <ul class="includes" style="padding: 0px;">
            <?= $trip->trip_include_exclude->include ?? '' ?>
        </ul>
        <h3>What isn't included?</h3>
        <ul class="excludes" style="padding: 0px;">
            <?= $trip->trip_include_exclude->exclude ?? '' ?>
        </ul>
        <h3>Complimentary</h3>
        <ul class="complimentary" style="padding: 0px;">
            <?= $trip->trip_include_exclude->complimentary ?? '' ?>
        </ul>
    </section>
    <p class="controls">
        <a class="back" href="{{ route('front.trips.show', $trip) }}">Go back</a>
        <button onclick="window.print()">Print</button>
        <a class="top" href="" onclick="window.scrollTo(0,0)">Go to top</a>
    </p>
</body>

</html>
