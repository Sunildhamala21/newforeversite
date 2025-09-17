<?php

use App\Http\Controllers\Front\ActivityController;
use App\Http\Controllers\Front\BlogCategoryController;
use App\Http\Controllers\Front\BlogController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\DestinationController;
use App\Http\Controllers\Front\DocumentController;
use App\Http\Controllers\Front\EmailSubscriberController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\PageController;
use App\Http\Controllers\Front\PaymentController;
use App\Http\Controllers\Front\PlanTripController;
use App\Http\Controllers\Front\RegionController;
use App\Http\Controllers\Front\TeamController;
use App\Http\Controllers\Front\TripController;
use App\Http\Controllers\Front\TripDepartureController;
use App\Http\Controllers\Front\TripReviewController;
use Illuminate\Support\Facades\Route;

// not working with minify
Route::get('cart', [CartController::class, 'index'])->name('cart.index');

Route::group(['middleware' => 'minify'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::post('/subscribe', [EmailSubscriberController::class, 'store'])->name('front.email-subscribers.store');
    Route::get('/gallery', [TripController::class, 'allTripGallery'])->name('front.trips.all-gallery');
    Route::get('/gallery/{slug}', [TripController::class, 'gallery'])->name('front.trips.galleries');
    Route::get('/legal-documents', [DocumentController::class, 'index'])->name('front.documents.index');
    Route::get('/faqs', [HomeController::class, 'faqs'])->name('front.faqs.index');
    Route::get('/contact-us', [HomeController::class, 'contact'])->name('front.contact.index');
    Route::post('/contact', [HomeController::class, 'contactStore'])->name('front.contact.store');

    // review routes
    Route::get('/reviews', [HomeController::class, 'reviews'])->name('front.reviews.index');
    Route::get('/reviews/create', [TripReviewController::class, 'create'])->name('front.reviews.create');
    Route::post('/reviews', [TripReviewController::class, 'store'])->name('front.reviews.store');

    Route::get('/print/{slug}', [TripController::class, 'print'])->name('front.trips.print');
    Route::get('/trips/filter/{region?}/{destination_id?}/{activity_id?}/{srotBy?}', [TripController::class, 'filter']);
    Route::get('/search', [TripController::class, 'search'])->name('front.trips.search');
    Route::post('/search-ajax', [TripController::class, 'searchAjax'])->name('front.trips.search-ajax');
    Route::get('/trips', [TripController::class, 'index'])->name('front.trips.index');
    Route::get('/trips/{trip:slug}', [TripController::class, 'show'])->name('front.trips.show');
    Route::get('/trips/{trip:slug}/departure-booking/{id}', [TripController::class, 'departureBooking'])->name('front.trips.departure-booking');
    Route::get('/trips/{trip:slug}/booking', [TripController::class, 'booking'])->name('front.trips.booking');
    Route::get('/trips/{slug}/customize', [TripController::class, 'customize'])->name('front.trips.customize');
    Route::post('/trips/departure-booking', [TripController::class, 'departureBookingStore'])->name('front.trips.departure-booking.store');
    Route::get('/trip-departures/filter/{month?}', [TripDepartureController::class, 'filter'])->name('front.trip-departures.filter');
    Route::post('/trips/{trip:slug}/booking', [TripController::class, 'bookingStore'])->name('front.trips.booking.store');
    Route::post('/trips/customize', [TripController::class, 'customizeStore'])->name('front.trips.customize.store');
    Route::get('/fixed-departures', [TripDepartureController::class, 'index'])->name('front.trip-departures.index');
    Route::get('/destinations', [DestinationController::class, 'index'])->name('front.destinations.index');
    Route::get('/destinations/search', [DestinationController::class, 'search'])->name('front.destinations.search');
    Route::get('/destinations/trips', [DestinationController::class, 'getTrips'])->name('front.destinations.gettrips');
    Route::get('/destinations/{destination:slug}', [DestinationController::class, 'show'])->name('front.destinations.show');
    Route::get('/activities', [ActivityController::class, 'index'])->name('front.activities.index');
    Route::get('/activities/search', [ActivityController::class, 'search'])->name('front.activities.search');
    Route::get('/activities/{activity:slug}', [ActivityController::class, 'show'])->name('front.activities.show');
    Route::get('/regions/{region:slug}', [RegionController::class, 'show'])->name('front.regions.show');

    Route::get('/blogs', [BlogController::class, 'index'])->name('front.blogs.index');
    Route::get('/blogs/tags/{tag}', [BlogController::class, 'listTagged'])->name('front.blogs.tags');
    Route::get('/blogs/categories', [BlogCategoryController::class, 'index'])->name('front.blogCategories.index');
    Route::get('/blogs/categories/{blogCategory:slug}', [BlogCategoryController::class, 'show'])->name('front.blogCategories.show');
    Route::get('/blogs/{slug}', [BlogController::class, 'show'])->name('front.blogs.show');

    Route::get('/teams', [TeamController::class, 'index'])->name('front.teams.index');
    Route::get('/teams/{slug}', [TeamController::class, 'show'])->name('front.teams.show');
    Route::get('plan-my-trip', [PlanTripController::class, 'index'])->name('front.plantrip');
    Route::post('plan-my-trip/create', [PlanTripController::class, 'store'])->name('front.plantrip.create');
    Route::get('plan-my-trip/thank-you', [PlanTripController::class, 'thankYou'])->name('front.plantrip.thank-you');
    Route::get('plan-my-trip/{slug}', [PlanTripController::class, 'createForTrip'])->name('front.plantrip.createfortrip');

    Route::get('checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('checkout', [CartController::class, 'storeCheckout'])->name('cart.storeCheckout');

    if (config('hbl.paymentEnabled')) {
        Route::get('/make-a-payment', [HomeController::class, 'makePayment'])->name('front.makeapayment');
        Route::post('/make-a-payment', [PaymentController::class, 'processManualPayment'])->name('front.manual_payment');
        Route::get('/hbl/success-callback', [PaymentController::class, 'successCallback'])->name('hbl.payment.successCallback');
        Route::get('/hbl/payment/success', [PaymentController::class, 'paymentSuccess'])->name('hbl.payment.success');
        Route::get('/hbl/manual-payment/success', [PaymentController::class, 'manualPaymentSuccess'])->name('hbl.manualPayment.success');
        Route::get('/hbl/payment/canceled', [PaymentController::class, 'paymentCanceled'])->name('hbl.payment.canceled');
        Route::get('/hbl/payment/failed', [PaymentController::class, 'paymentFailed'])->name('hbl.payment.failed');
    }

    Route::get('{slug}', [PageController::class, 'show'])->name('front.pages.show');
});
