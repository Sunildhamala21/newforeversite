@if ($essential_trip_informations)
<div class="mb-3 essential-info" style="background: #ffecc7; padding: 15px;">
    <h3>Essential Trip Information</h3>
    <ul class="essential-links" style="font-size: 17px;">
        @foreach ($essential_trip_informations as $trip_info)
        <li style="padding: 5px 0px;">
            <a href="{!! ($trip_info->link)?$trip_info->link:'javascript:;' !!}" target="_blank" class="flex">
            <svg class="w-6 h-6 mr-1 mt-1 shrink-0">
                <use xlink:href="{{ asset('assets/front/img/sprite.svg#arrownarrowright') }}" /></svg>

            {{ $trip_info->name }} </a>
        </li>
        @endforeach
    </ul>
</div>
@endif