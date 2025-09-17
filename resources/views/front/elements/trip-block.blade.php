@forelse ($trips as $tour)
@include('front.elements.tour-card')
@empty
    <p>No Trips</p>
@endforelse

