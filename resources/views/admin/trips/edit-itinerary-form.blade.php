@if (iterator_count($trip->trip_itineraries))
    @foreach ($trip->trip_itineraries as $itinerary)
        <div class="form-group itinerary-group">
            <div class="kt-timeline-v2 travel-timeline">
                <div class="kt-timeline-v2__items  kt-padding-top-25 kt-padding-bottom-30">
                    <div class="kt-timeline-v2__item">
                        <span class="kt-timeline-v2__item-time">Day <span class="day-number"><input type="number" required
                                    value="{{ $itinerary->day }}" class="form-control form-control-sm"
                                    style="width: 83px;"></span></span>
                        <div class="kt-timeline-v2__item-cricle">
                            <i class="fa fa-genderless kt-font-success"></i>
                        </div>
                        <div class="kt-timeline-v2__item-text">
                            <div class="itinerary-block-action">
                                <div>
                                    <button type="button" title="remove"
                                        class="btn btn-outline-danger btn-sm btn-elevate-hover btn-icon pull-right remove-itinerary"><i
                                            class="fa fa-times"></i></button>
                                    <div title="move"
                                        class="btn btn-outline-brand btn-sm btn-elevate-hover btn-icon pull-right move-itinerary mr-1">
                                        <i class="la la-unsorted"></i>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="input-trip-itinerary-id" name="itinerary_id"
                                value="{{ $itinerary->id }}">
                            <div class="row">
                                <div class="col-12 form-group">
                                    <label>Title</label>
                                    <input type="text" name="trip_itineraries[][name]" id="input-trip-name"
                                        value="{{ $itinerary->name }}" class="form-control form-control-sm">
                                </div>
                                <div class="col-4 form-group">
                                    <label>Max. Altitude</label>
                                    <input type="text" id="input-trip-max-altitude"
                                        value="{{ $itinerary->max_altitude }}" class="form-control form-control-sm">
                                    {{-- accomodation --}}
                                </div>
                                <div class="col-4 form-group">
                                    <label>Accommodation</label>
                                    <input type="text" id="input-trip-accomodation"
                                        value="{{ $itinerary->accomodation }}" class="form-control form-control-sm">
                                    {{-- meals --}}
                                </div>
                                <div class="col-4 form-group">
                                    <label>Meals</label>
                                    <input type="text" id="input-trip-meals" value="{{ $itinerary->meals }}"
                                        class="form-control form-control-sm">
                                    {{-- place --}}
                                </div>
                                <div class="col-4 form-group">
                                    <label>Place</label>
                                    <input type="text" id="input-trip-place" value="{{ $itinerary->place }}"
                                        class="form-control form-control-sm">
                                </div>
                                {{-- image --}}
                                @if ($itinerary->image_name)
                                    <div class="col-4 form-group">
                                        <img src="{{ $itinerary->imageUrl }}" class="tbl-img" alt="">
                                        <label>
                                            <input class="delete-image" type="checkbox">
                                            Remove Photo
                                        </label>
                                    </div>
                                @endif
                                <div class="col-4 form-group">
                                    <label>Photo</label>
                                    <input type="file" id="input-trip-image" name="itinerary_image"
                                        class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="itinerary-description-block">
                                <div id="summernote-itinerary-{{ $itinerary->day }}" class="summernote-itinerary">
                                    <?= $itinerary->description ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="form-group itinerary-group">
        <div class="kt-timeline-v2 travel-timeline">
            <div class="kt-timeline-v2__items  kt-padding-top-25 kt-padding-bottom-30">
                <div class="kt-timeline-v2__item">
                    <span class="kt-timeline-v2__item-time">Day <span class="day-number"><input type="number" required
                                class="form-control form-control-sm" style="width: 83px;"></span></span>
                    <div class="kt-timeline-v2__item-cricle">
                        <i class="fa fa-genderless kt-font-success"></i>
                    </div>
                    <div class="kt-timeline-v2__item-text">
                        <div class="itinerary-block-action">
                            <div>
                                <button type="button" title="remove"
                                    class="btn btn-outline-danger btn-sm btn-elevate-hover btn-icon pull-right remove-itinerary"><i
                                        class="fa fa-times"></i></button>
                                <div title="move"
                                    class="btn btn-outline-brand btn-sm btn-elevate-hover btn-icon pull-right move-itinerary mr-1">
                                    <i class="la la-unsorted"></i>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 form-group">
                                <label>Title</label>
                                <input type="text" name="trip_itineraries[][name]" id="input-trip-name"
                                    class="form-control form-control-sm">
                            </div>
                            <div class="col-4 form-group">
                                <label>Max. Altitude</label>
                                <input type="text" id="input-trip-max-altitude" class="form-control form-control-sm">
                            </div>
                            <div class="col-4 form-group">
                                <label>Accommodation</label>
                                <input type="text" id="input-trip-accomodation" class="form-control form-control-sm">
                            </div>
                            <div class="col-4 form-group">
                                <label>Meals</label>
                                <input type="text" id="input-trip-meals" class="form-control form-control-sm">
                            </div>
                            <div class="col-4 form-group">
                                <label>Place</label>
                                <input type="text" id="input-trip-place" class="form-control form-control-sm">
                            </div>
                            <div class="col-4 form-group">
                                <label>Photo</label>
                                <input type="file" id="input-trip-image" name="itinerary_image"
                                    class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="itinerary-description-block">
                            <div id="summernote-itinerary-1" class="summernote-itinerary"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
