@extends('layouts.admin')
@push('styles')
    <link href="./assets/vendors/general/summernote/dist/summernote.css"
          rel="stylesheet"
          type="text/css" />
    <link href="./assets/vendors/bootstrap-rating-master/bootstrap-rating.css" rel="stylesheet">
@endpush
@section('content')
    <div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col">
                <!--begin::Portlet-->
                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <span class="kt-portlet__head-icon">
                                <i class="kt-font-brand flaticon2-location"></i>
                            </span>
                            <h3 class="kt-portlet__head-title">
                                Add Trip
                            </h3>
                        </div>
                        <div class="mt-3 kt-form__actions">
                            <a href="{{ route('admin.trips.index') }}" class="btn btn-sm btn-secondary">Cancel</a>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <div class="kt-portlet__body">
                        <ul class="nav nav-tabs"
                            id="tripTab"
                            role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active"
                                   data-toggle="tab"
                                   href="#kt_tabs_1_1">
                                    <i class="la la-map-pin"></i> General
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link disabled"
                                   data-toggle="tab"
                                   href="#kt_tabs_1_2">
                                    <i class="la la-map-signs"></i> Trip Info
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link disabled"
                                   data-toggle="tab"
                                   href="#kt_tabs_1_3">
                                    <i class="la la-list-alt"></i> Package Includes/Excludes
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link disabled"
                                   data-toggle="tab"
                                   href="#kt_tabs_1_4">
                                    <i class="la la-magic"></i> Meta
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link disabled"
                                   data-toggle="tab"
                                   href="#kt_tabs_1_5">
                                    <i class="la la-list-ul"></i> Itinerary
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link disabled"
                                   data-toggle="tab"
                                   href="#kt_tabs_1_6">
                                    <i class="la la-file-image-o"></i> Sliders
                                </a>
                            </li>
                        </ul>

                        <form class="kt-form"
                              id="add-trip-form-page"
                              enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="tab-content trip-tab-form">
                                <div class="tab-pane active"
                                     id="kt_tabs_1_1"
                                     role="tabpanel">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Trip Name</label>
                                        <div class="col-lg-7">
                                            <input type="text"
                                                   id="input-trip-name"
                                                   class="form-control form-control-sm"
                                                   name="name"
                                                   required>
                                            {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Trip Location</label>
                                        <div class="col-lg-7">
                                            <input type="text"
                                                   id="input-trip-location"
                                                   class="form-control form-control-sm"
                                                   name="location">
                                            {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Trip Code</label>
                                        <div class="col-lg-7">
                                            <input type="text"
                                                   id="input-trip-name"
                                                   class="form-control form-control-sm"
                                                   name="trip_code">
                                            {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Trip Duration (in days)</label>
                                        <div class="col-lg-7">
                                            <input type="text"
                                                   class="form-control form-control-sm"
                                                   name="duration">
                                            {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Maximum Altitude(in meters)</label>
                                        <div class="col-lg-7">
                                            <input type="text"
                                                   class="form-control form-control-sm"
                                                   name="max_altitude">
                                            {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Group Size</label>
                                        <div class="col-lg-7">
                                            <input type="text"
                                                   class="form-control form-control-sm"
                                                   name="group_size">
                                            {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Cost</label>
                                        <div class="col-lg-7">
                                            <input type="text"
                                                   class="form-control form-control-sm"
                                                   name="cost">
                                            {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Offer Price</label>
                                        <div class="col-lg-7">
                                            <input type="text"
                                                   class="form-control form-control-sm"
                                                   name="offer_price">
                                            {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Best Value</label>
                                        <div class="col-lg-7">
                                            <input type="text"
                                                   class="form-control form-control-sm"
                                                   name="best_value">
                                            {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Difficulty Grade</label>
                                        <div class="col-lg-7">
                                            <select name="difficulty_grade" class="custom-select form-control form-control-sm">
                                                <option value="" selected="">--Select Difficulty Grade--</option>
                                                <option value="1">Beginner</option>
                                                <option value="2">Easy</option>
                                                <option value="3">Moderate</option>
                                                <option value="4">Difficult</option>
                                                <option value="5">Advance</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Starting Point</label>
                                        <div class="col-lg-7">
                                            <input type="text"
                                                   class="form-control form-control-sm"
                                                   name="starting_point">
                                            {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Ending Point</label>
                                        <div class="col-lg-7">
                                            <input type="text"
                                                   class="form-control form-control-sm"
                                                   name="ending_point">
                                            {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Destination</label>
                                        <div class="col-lg-7">
                                            <select class="custom-select form-control form-control-sm" name="destination_id">
                                                <option selected="" value="">--Select Destination--</option>
                                                @foreach ($destinations as $country)
                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Region</label>
                                        <div class="col-lg-7">
                                            <select class="custom-select form-control form-control-sm" name="region_id">
                                                <option selected="" value="">--Select Region--</option>
                                                @foreach ($regions as $region)
                                                    <option value="{{ $region->id }}">{{ $region->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label>Activities</label>
                                        <div class="kt-checkbox-list">
                                            @if (iterator_count($activities))
                                                @foreach ($activities as $activity)
                                                    <label class="kt-checkbox kt-checkbox--brand">
                                                        <input type="checkbox"
                                                               name="activities[]"
                                                               value="{{ $activity->id }}"> {{ $activity->name }}
                                                        <span></span>
                                                    </label>
                                                @endforeach
                                            @else
                                                <p>No activity added.</p>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label>Choose Similar Trips</label>
                                        <div class="kt-checkbox-list">
                                            @if (iterator_count($trips))
                                                @foreach ($trips as $trip)
                                                    <label class="kt-checkbox kt-checkbox--brand">
                                                        <input type="checkbox"
                                                               name="similar_trips[]"
                                                               value="{{ $trip->id }}"> {{ $trip->name }}
                                                        <span></span>
                                                    </label>
                                                @endforeach
                                            @else
                                                <p>No trips added.</p>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label>Choose Addon Trips</label>
                                        <div class="kt-checkbox-list">
                                            @if (iterator_count($trips))
                                                @foreach ($trips as $trip)
                                                    <label class="kt-checkbox kt-checkbox--brand">
                                                        <input type="checkbox"
                                                               name="addon_trips[]"
                                                               value="{{ $trip->id }}"> {{ $trip->name }}
                                                        <span></span>
                                                    </label>
                                                @endforeach
                                            @else
                                                <p>No trips added.</p>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Map File</label>
                                        <div class="col-lg-7">
                                            <div>
                                                <p><span id="map_file_name">choose file</span><button id="remove-map-file-btn" class="btn btn-sm text-danger"><i class="fa fa-times"></i></button></p>
                                            </div>
                                            <div>
                                                <button type="button"
                                                        class="btn btn-sm btn-secondary btn-wide"
                                                        onclick="document.getElementById('map_file').click();"> Upload Map Image
                                                </button>
                                            </div>
                                            <input type="file"
                                                   style="display: none;"
                                                   id="map_file"
                                                   class="form-control form-control-sm"
                                                   name="map_file_name">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Map Iframe</label>
                                        <div class="col-lg-7">
                                            <textarea class="form-control form-control-sm"
                                                      name="iframe"
                                                      id=""
                                                      cols="30"
                                                      rows="10"></textarea>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">PDF File</label>
                                        <div class="col-lg-7">
                                            <div>
                                                <p><span id="pdf_file_name">choose file</span><button id="remove-pdf-file-btn" class="btn btn-sm text-danger"><i class="fa fa-times"></i></button></p>
                                            </div>
                                            <div>
                                                <input type="button"
                                                       class="btn btn-sm btn-secondary btn-wide"
                                                       value="Upload Pdf"
                                                       onclick="document.getElementById('pdf_file').click();" />
                                            </div>
                                            <input type="file"
                                                   style="display: none;"
                                                   id="pdf_file"
                                                   class="form-control form-control-sm"
                                                   name="pdf_file_name">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group row">
                                        <label class="col-2 col-form-label">Rating</label>
                                        <div class="col-3">
                                            <input type="hidden"
                                                   id="trip-rating"
                                                   value="5"
                                                   name="rating"
                                                   class="rating"
                                                   data-filled="fas fa-star fa-2x"
                                                   data-empty="far fa-star fa-2x" />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-2 col-form-label">Show/Hide</label>
                                        <div class="col-3">
                                            <span class="kt-switch kt-switch--sm kt-switch--icon">
                                                <label>
                                                    <input type="checkbox" name="show_status">
                                                    <span></span>
                                                </label>
                                            </span>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="kt-form__actions">
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="flaticon2-arrow-up"></i>
                                            Publish</button>
                                        <button id="trip-save-continue" class="btn btn-sm btn-success">
                                            Save and Continue <i class="la la-long-arrow-right"></i></button>
                                    </div>
                                </div>

                                {{-- Trip Info --}}

                                <div class="tab-pane"
                                     data-index="2"
                                     id="kt_tabs_1_2"
                                     role="tabpanel">
                                    <div class="form-group">
                                        <label class="form-label">Accomodation</label>
                                        <div id="summernote-accomodation" class="summernote"></div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label class="form-label">Meals</label>
                                        <div id="summernote-meals" class="summernote"></div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label class="form-label">Transportation</label>
                                        <div id="summernote-transportation" class="summernote"></div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label class="form-label">Overview</label>
                                        <div id="summernote-overview" class="summernote"></div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label class="form-label">Highlights</label>
                                        <div id="summernote-highlights" class="summernote"></div>
                                    </div>
                                    <hr>
                                    <div class="kt-form__actions">
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="flaticon2-arrow-up"></i>
                                            Publish</button>
                                        <button id="info-save-continue" class="btn btn-sm btn-success form-continue">
                                            Continue to Package Include/ Exclude <i class="la la-long-arrow-right"></i></button>
                                    </div>
                                </div>

                                {{-- Package includes and excludes --}}

                                <div class="tab-pane"
                                     data-index="3"
                                     id="kt_tabs_1_3"
                                     role="tabpanel">
                                    <div class="form-group">
                                        <label class="form-label">Include</label>
                                        <div id="summernote-include" class="summernote"></div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label class="form-label">Exclude</label>
                                        <div id="summernote-exclude" class="summernote"></div>
                                    </div>
                                    <hr>
                                    <div class="kt-form__actions">
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="flaticon2-arrow-up"></i>
                                            Publish</button>
                                        <button id="include-save-continue" class="btn btn-sm btn-success form-continue">
                                            Continue to Meta <i class="la la-long-arrow-right"></i></button>
                                    </div>
                                </div>

                                {{-- Meta --}}

                                <div class="tab-pane"
                                     data-index="4"
                                     id="kt_tabs_1_4"
                                     role="tabpanel">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Canonical Url</label>
                                        <div class="col-lg-7">
                                            <input type="text"
                                                   id="input-trip-name"
                                                   class="form-control form-control-sm"
                                                   name="trip_seo[canonical_url]">
                                            {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Meta Title</label>
                                        <div class="col-lg-7">
                                            <textarea name="trip_seo[meta_title]"
                                                      class="form-control form-control-sm"
                                                      id=""
                                                      cols="30"
                                                      rows="2"></textarea>
                                            {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Meta Keywords</label>
                                        <div class="col-lg-7">
                                            <textarea name="trip_seo[meta_keywords]"
                                                      class="form-control form-control-sm"
                                                      id=""
                                                      cols="30"
                                                      rows="2"></textarea>
                                            {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Og Image</label>
                                        <div class="col-lg-7">
                                            <div>
                                                <p id="og_file_name">choose file</p>
                                            </div>
                                            <div>
                                                <button type="button"
                                                        class="btn btn-sm btn-secondary btn-wide"
                                                        onclick="document.getElementById('og_file').click();"> Upload Og Image
                                                </button>
                                            </div>
                                            <input type="file"
                                                   style="display: none;"
                                                   id="og_file"
                                                   class="form-control form-control-sm"
                                                   name="trip_seo[og_image]">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Meta Description</label>
                                        <div class="col-lg-7">
                                            <textarea name="trip_seo[meta_description]"
                                                      class="form-control form-control-sm"
                                                      id=""
                                                      cols="30"
                                                      rows="2"></textarea>
                                            {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        {{-- originally about leader --}}
                                        <label class="col-lg-2 col-form-label">Equipment List</label>
                                        <div class="col-lg-7">
                                            <div id="summernote-leader" class="summernote"></div>
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="kt-form__actions">
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="flaticon2-arrow-up"></i>
                                            Publish</button>
                                        <button id="include-save-continue" class="btn btn-sm btn-success form-continue">
                                            Continue to Itinerary <i class="la la-long-arrow-right"></i></button>
                                    </div>
                                </div>

                                {{-- Itinerary --}}
                                <div class="tab-pane"
                                     data-index="5"
                                     id="kt_tabs_1_5"
                                     role="tabpanel">
                                    <div class="row">
                                        <div class="mb-5 col-lg-9">
                                            <div class="mb-3 row">
                                                <div class="col">
                                                    <button id="add-itinerary-btn" class="btn btn-sm btn-outline-brand pull-right"><i class="flaticon2-plus"></i>
                                                        Add Itinerary</button>
                                                </div>
                                            </div>

                                            <div id="itinerary-block" data-n="1">
                                                <div class="form-group itinerary-group">
                                                    <div class="kt-timeline-v2 travel-timeline">
                                                        <div class="kt-timeline-v2__items kt-padding-top-25 kt-padding-bottom-30">
                                                            <div class="kt-timeline-v2__item">
                                                                <span class="kt-timeline-v2__item-time">Day <span class="day-number">1</span></span>
                                                                <div class="kt-timeline-v2__item-cricle">
                                                                    <i class="fa fa-genderless kt-font-success"></i>
                                                                </div>
                                                                <div class="kt-timeline-v2__item-text kt-timeline-v2__item-text--bold">
                                                                    <div class="itinerary-block-action">
                                                                        <div>
                                                                            <button type="button"
                                                                                    title="remove"
                                                                                    class="btn btn-outline-danger btn-sm btn-elevate-hover btn-icon pull-right remove-itinerary"><i class="fa fa-times"></i></button>
                                                                            <div title="move" class="mr-1 btn btn-outline-brand btn-sm btn-elevate-hover btn-icon pull-right move-itinerary">
                                                                                <i class="la la-unsorted"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <input type="text"
                                                                           name="trip_itineraries[][name]"
                                                                           id="input-trip-name"
                                                                           class="mb-3 form-control form-control-sm"
                                                                           name="trip_seo[canonical_url]"
                                                                           placeholder="Title">
                                                                    <div class="itinerary-description-block">
                                                                        <div id="summernote-itinerary-1" class="summernote"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="kt-form__actions">
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="flaticon2-arrow-up"></i>
                                            Publish</button>
                                        <button id="include-save-continue" class="btn btn-sm btn-success form-continue">
                                            Continue to Sliders <i class="la la-long-arrow-right"></i></button>
                                    </div>
                                </div>

                                <div class="tab-pane"
                                     data-index="6"
                                     id="kt_tabs_1_6"
                                     role="tabpanel">
                                    <div class="mb-3">
                                        <button type="button"
                                                class="btn btn-bold btn-label-brand btn-sm pull-right"
                                                data-toggle="modal"
                                                data-target="#kt_modal_4">Add Image</button>
                                    </div>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Image</th>
                                                <th>Caption</th>
                                                <th>Alt Tag</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>Jhon</td>
                                                <td>Stone</td>
                                                <td>@jhon</td>
                                                <td>@jhon</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </form>
                    </div>
                    <!-- <div class="kt-portlet__foot">
                                              <div class="kt-form__actions">
                                                  {{-- <button type="submit" class="btn btn-success">Publish</button> --}}
                                                  {{-- <button type="reset" class="btn btn-secondary">Cancel</button> --}}
                                                  <button type="submit" class="btn btn-sm btn-primary">
                                                        <i class="flaticon2-arrow-up"></i>
                                                      Publish</button>
                                              </div>
                                          </div> -->
                    <!--end::Form-->
                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>
    <!--begin::Modal-->
    <div class="modal fade"
         id="kt_modal_4"
         tabindex="-1"
         role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Image</h5>
                    <button type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="recipient-name" class="form-control-label">Caption</label>
                            <input type="text"
                                   name=""
                                   class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="form-control-label">Message:</label>
                            <textarea class="form-control" id="message-text"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Send message</button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Modal-->
@endsection
@push('scripts')
    <script src="./assets/vendors/general/summernote/dist/summernote.js" type="text/javascript"></script>
    <script src="./assets/js/demo1/pages/crud/forms/widgets/summernote.js" type="text/javascript"></script>
    <script src="./assets/vendors/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="./assets/vendors/jquery-validation/dist/additional-methods.min.js"></script>
    <script src="./assets/vendors/bootstrap-rating-master/bootstrap-rating.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript">
        $(function() {
            $("#trip-rating").rating();

            function initItinerarySortable() {
                $("#itinerary-block").sortable({
                    handle: '.move-itinerary',
                    cursor: 'move',
                    scrollSpeed: 40,
                    placeholder: "sortable-placeholder",
                    start: function() {
                        Toast.fire({
                            type: 'info',
                            position: 'center',
                            timer: 2000,
                            title: 'Drag up or down to re-arrange the itinerary.'
                        });
                    },
                    update: function() {
                        rearrangeDay();
                    }
                });
            }

            // $('#tripTab li:nth-child(2) a').tab('show');
            $("#input-trip-name").on('change', function(e) {
                var val = $(this).val();
                if (val == "") {
                    disableAllTabs();
                }
            });
            $("#trip-save-continue").on('click', function(e) {
                var form = $("#add-trip-form-page");
                var valid = form.valid();
                if (valid) {
                    e.preventDefault();
                    handleTripAddForm(form, true);
                }
            });

            $(document).on('click', '.form-continue', function(e) {
                e.preventDefault();
                var tab_index = $(this).closest('.tab-pane').attr('data-index');
                $('#tripTab li:nth-child(' + (parseInt(tab_index) + 1) + ') a').tab("show");
            });

            function enableAllTabs() {
                $.each($("#tripTab li>a"), function(i, v) {
                    $('#tripTab li:nth-child(' + (i + 1) + ') a').removeClass("disabled");
                });
                $('#tripTab li:nth-child(2) a').tab('show');
            }

            function disableAllTabs() {
                $.each($("#tripTab li>a"), function(i, v) {
                    if (i != 0) {
                        $('#tripTab li:nth-child(' + (i + 1) + ') a').addClass("disabled");
                    }
                });
            }

            $(document).on('click', '.remove-itinerary', function(e) {
                // check if the div is greater than 1.
                if (parseInt($("#itinerary-block>.form-group").length) > 1) {
                    var div = $(this).closest('.itinerary-group').remove();
                    // reorder day.
                    rearrangeDay();
                }
            });

            function rearrangeDay() {
                $.each($("#itinerary-block>.form-group"), function(i, v) {
                    $(v).find('.day-number').text(i + 1);
                });
            }

            $(document).on('click', '#add-itinerary-btn', function(e) {
                e.preventDefault();
                var n = parseInt($("#itinerary-block>.form-group").length) + 1;

                var div = '\
                              <div class="form-group itinerary-group">\
                                <div class="kt-timeline-v2 travel-timeline">\
                                    <div class="kt-timeline-v2__items kt-padding-top-25 kt-padding-bottom-30">\
                                        <div class="kt-timeline-v2__item">\
                                            <span class="kt-timeline-v2__item-time">Day <span class="day-number">' + n + '</span></span>\
                                            <div class="kt-timeline-v2__item-cricle">\
                                                <i class="fa fa-genderless kt-font-success"></i>\
                                            </div>\
                                            <div class="kt-timeline-v2__item-text kt-timeline-v2__item-text--bold">\
                                              <div class="itinerary-block-action">\
                                                <div>\
                                                  <button type="button" title="remove" class="btn btn-outline-danger btn-sm btn-elevate-hover btn-icon pull-right remove-itinerary"><i class="fa fa-times"></i></button>\
                                                    <div title="move" class="mr-1 btn btn-outline-brand btn-sm btn-elevate-hover btn-icon pull-right move-itinerary"><i class="la la-unsorted"></i></div>\
                                                </div>\
                                              </div>\
                                              <input type="text" name="trip_itineraries[][name]" id="input-trip-name" class="mb-3 form-control form-control-sm" name="trip_seo[canonical_url]" placeholder="Title">\
                                              <div class="itinerary-description-block">\
                                                <div id="summernote-itinerary-' + n + '" class="summernote"></div>\
                                              </div>\
                                            </div>\
                                        </div>\
                                    </div>\
                                </div>\
                              </div>\
                              ';

                $("#itinerary-block").append(div);
                $('#summernote-itinerary-' + n).summernote({
                    height: 200
                });
                $("#itinerary-block").attr('data-n', n);
                initItinerarySortable();
            });

            // $(document).on('mousedown', '.move-itinerary', function(e) {
            //   if (parseInt($("#itinerary-block>.form-group").length) > 1) {
            //     $('.itinerary-description-block').hide();
            //     Toast.fire({
            //       type: 'info',
            //       position: 'top',
            //       timer: 1500,
            //       title: 'Drag up or down to reorder the itinerary'
            //     });
            //   }
            // }).on('mouseup', '.move-itinerary', function(e) {
            //     $('.itinerary-description-block').show();
            // });

            // $(document).on('mouseup', function(e) {
            //   $('.itinerary-description-block').show();
            // });

            var validation_rules = {
                pdf_file_name: {
                    extension: "pdf"
                },
                map_file_name: {
                    extension: "jpeg|jpg|png|gif"
                },
                "trip_seo[og_image]": {
                    extension: "jpeg|jpg|png|gif"
                },
                cost: {
                    number: true
                },
                max_altitude: {
                    number: true
                },
                offer_price: {
                    number: true
                }
            };
            var validation_messages = {
                pdf_file_name: {
                    extension: "Only pdf is allowed."
                },
                map_file_name: {
                    extension: "Only image files is allowed."
                }
            };

            $("#og_file").on('change', function(e) {
                var fileName = e.target.files[0].name;
                $("#og_file_name").html(fileName);
            });

            $("#map_file").on('change', function(e) {
                var fileName = e.target.files[0].name;
                $("#map_file_name").html(fileName);
            });

            $("#pdf_file").on('change', function(e) {
                var fileName = e.target.files[0].name;
                $("#pdf_file_name").html(fileName);
            });

            $("#remove-map-file-btn").on('click', function(event) {
                event.preventDefault();
                $("#map_file").val('');
                $("#map_file_name").html("choose file");
                validator.resetForm();
            });

            $("#remove-pdf-file-btn").on('click', function(event) {
                event.preventDefault();
                $("#pdf_file").val('');
                $("#pdf_file_name").html("choose file");
                validator.resetForm();
            });

            var validator = $("#add-trip-form-page").validate({
                ignore: "",
                submitHandler: function(form, event) {
                    event.preventDefault();
                    // var btn = $(form).find('button[type=submit]').attr('disabled', true).html('Publishing...');
                    handleTripAddForm(form);
                },
                rules: validation_rules,
                messages: validation_messages
            });

            $("#add-info-form-page, #add-include-form-page").on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var btn = form.find('button[type=submit]').attr('disabled', true).html('Publishing...');
                handleTripAddForm($("#add-trip-form-page"));
            });

            var cropped = false;
            const image = document.getElementById('cropper-image');
            var cropper = "";

            function handleTripAddForm(form, cont = false) {

                var form = $(form);
                var formData = new FormData(form[0]);

                if (!$('#tripTab li:nth-child(2) a').hasClass("disabled")) {
                    var trip_info = "";

                    trip_info = {
                        'accomodation': $('#summernote-accomodation').summernote('code'),
                        'meals': $('#summernote-meals').summernote('code'),
                        'transportation': $('#summernote-transportation').summernote('code'),
                        'overview': $('#summernote-overview').summernote('code'),
                        'highlights': $('#summernote-highlights').summernote('code')
                    };

                    formData.append('trip_info', JSON.stringify(trip_info));
                }

                if (!$('#tripTab li:nth-child(3) a').hasClass("disabled")) {
                    var trip_include = "";

                    trip_include = {
                        'include': $('#summernote-include').summernote('code'),
                        'exclude': $('#summernote-exclude').summernote('code'),
                    };

                    formData.append('trip_include_exclude', JSON.stringify(trip_include));
                }

                if (!$('#tripTab li:nth-child(4) a').hasClass("disabled")) {
                    var trip_leader = $('#summernote-leader').summernote('code');
                    formData.append('trip_seo[about_leader]', trip_leader);
                }

                if (!$('#tripTab li:nth-child(5) a').hasClass("disabled")) {

                    $.each($("#itinerary-block>.itinerary-group").find('.summernote'), function(i, v) {
                        var desc = $(v).summernote('code');
                        formData.append('trip_itineraries[' + i + '][day]', i + 1);
                        formData.append('trip_itineraries[' + i + '][display_order]', i + 1);
                        formData.append('trip_itineraries[' + i + '][description]', desc);
                    });
                }

                $.ajax({
                    url: "{{ route('admin.trips.store') }}",
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    async: false,
                    success: function(res) {
                        if (res.status === 1) {
                            if (cont) {
                                if (typeof(Storage) !== "undefined") {
                                    // Store
                                    sessionStorage.setItem("save-and-continue", true);
                                }

                                location.href = '{{ url('/admin/trips/edit') }}' + '/' + res.trip.id;
                            } else {
                                location.href = '{{ route('admin.trips.index') }}';
                            }
                        }
                    }
                });
            }

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#cropper-image').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#cropper-upload").change(function() {
                readURL(this);
            });

            initItinerarySortable();
        });
    </script>
@endpush
