<?php

use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\AlbumController;
use App\Http\Controllers\Admin\AlbumMediaController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DescriptionImageController;
use App\Http\Controllers\Admin\DestinationController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\EmailSubscriberController;
use App\Http\Controllers\Admin\EnquiryController;
use App\Http\Controllers\Admin\FaqCategoryController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\IconController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\RegionController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\TripController;
use App\Http\Controllers\Admin\TripDepartureController;
use App\Http\Controllers\Admin\TripFaqController;
use App\Http\Controllers\Admin\TripReviewController;
use App\Http\Controllers\Admin\TripSliderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WhyChooseController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\SitemapImageController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::view('mycms', 'admin_login')->name('admin.login');
});

Route::post('login', [LoginController::class, 'login'])->name('auth.login');
Route::get('logout', [LoginController::class, 'logout'])->name('auth.logout');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('pages', [PageController::class, 'index'])->name('pages.index');
    Route::get('pages/edit/{id}', [PageController::class, 'edit'])->name('pages.edit');
    Route::post('pages/update', [PageController::class, 'update'])->name('pages.update');
    Route::get('pages/add', [PageController::class, 'create'])->name('pages.add');
    Route::get('pages/list', [PageController::class, 'pageList']);
    Route::post('pages', [PageController::class, 'store'])->name('pages.store');
    Route::delete('pages/delete/{id}', [PageController::class, 'destroy'])->name('pages.delete');

    Route::resource('blog-categories', BlogCategoryController::class)->except('show');
    Route::get('blog-categories/list', [BlogCategoryController::class, 'list']);

    Route::get('blogs', [BlogController::class, 'index'])->name('blogs.index');
    Route::get('blogs/edit/{id}', [BlogController::class, 'edit'])->name('blogs.edit');
    Route::post('blogs/update', [BlogController::class, 'update'])->name('blogs.update');
    Route::get('blogs/add', [BlogController::class, 'create'])->name('blogs.add');
    Route::get('blogs/list', [BlogController::class, 'blogList']);
    Route::post('blogs', [BlogController::class, 'store'])->name('blogs.store');
    Route::delete('blogs/delete/{id}', [BlogController::class, 'destroy'])->name('blogs.delete');

    Route::resource('albums', AlbumController::class)->except('create', 'show', 'edit');
    Route::group(['prefix' => 'albums/{album}', 'as' => 'albums.'], function () {
        Route::resource('media', AlbumMediaController::class)->except('create', 'show', 'edit');
    });

    Route::get('faqs', [FaqController::class, 'index'])->name('faqs.index');
    Route::post('faqs/update-category/{id}', [FaqController::class, 'updateCategory'])->name('faqs.update-category');
    Route::get('faqs/edit/{id}', [FaqController::class, 'edit'])->name('faqs.edit');
    Route::post('faqs/update', [FaqController::class, 'update'])->name('faqs.update');
    Route::get('faqs/add', [FaqController::class, 'create'])->name('faqs.add');
    Route::get('faqs/list', [FaqController::class, 'faqList']);
    Route::post('faqs', [FaqController::class, 'store'])->name('faqs.store');
    Route::delete('faqs/delete/{id}', [FaqController::class, 'destroy'])->name('faqs.delete');

    Route::get('subscribers', [EmailSubscriberController::class, 'index'])->name('subscribers.index');
    Route::get('subscribers/export-to-excel', [EmailSubscriberController::class, 'exportToExcel'])->name('subscribers.export-excel');
    Route::get('subscribers/list', [EmailSubscriberController::class, 'subscriberList']);
    Route::delete('subscribers/delete/{id}', [EmailSubscriberController::class, 'destroy'])->name('subscribers.delete');

    Route::get('teams', [TeamController::class, 'index'])->name('teams.index');
    Route::get('teams/edit/{id}', [TeamController::class, 'edit'])->name('teams.edit');
    Route::post('teams/update', [TeamController::class, 'update'])->name('teams.update');
    Route::get('teams/add', [TeamController::class, 'create'])->name('teams.add');
    Route::get('teams/list', [TeamController::class, 'teamList']);
    Route::post('teams', [TeamController::class, 'store'])->name('teams.store');
    Route::delete('teams/delete/{id}', [TeamController::class, 'destroy'])->name('teams.delete');

    // banner routes
    Route::get('banners', [BannerController::class, 'index'])->name('banners.index');
    Route::get('banners/edit/{id}', [BannerController::class, 'edit'])->name('banners.edit');
    Route::post('banners/update', [BannerController::class, 'update'])->name('banners.update');
    Route::get('banners/add', [BannerController::class, 'create'])->name('banners.add');
    Route::get('banners/list', [BannerController::class, 'bannerList']);
    Route::post('banners', [BannerController::class, 'store'])->name('banners.store');
    Route::delete('banners/delete/{id}', [BannerController::class, 'destroy'])->name('banners.delete');

    // destination routes
    Route::get('destinations', [DestinationController::class, 'index'])->name('destinations.index');
    Route::get('destinations/edit/{id}', [DestinationController::class, 'edit'])->name('destinations.edit');
    Route::post('destinations/update', [DestinationController::class, 'update'])->name('destinations.update');
    Route::get('destinations/add', [DestinationController::class, 'create'])->name('destinations.add');
    Route::get('destinations/list', [DestinationController::class, 'destinationList']);
    Route::post('destinations', [DestinationController::class, 'store'])->name('destinations.store');
    Route::delete('destinations/delete/{id}', [DestinationController::class, 'destroy'])->name('destinations.delete');

    // activity routes
    Route::get('activities', [ActivityController::class, 'index'])->name('activities.index');
    Route::get('activities/edit/{id}', [ActivityController::class, 'edit'])->name('activities.edit');
    Route::post('activities/update', [ActivityController::class, 'update'])->name('activities.update');
    Route::get('activities/add', [ActivityController::class, 'create'])->name('activities.add');
    Route::get('activities/list', [ActivityController::class, 'activityList']);
    Route::post('activities', [ActivityController::class, 'store'])->name('activities.store');
    Route::delete('activities/delete/{id}', [ActivityController::class, 'destroy'])->name('activities.delete');

    // region routes
    Route::get('regions', [RegionController::class, 'index'])->name('regions.index');
    Route::get('regions/edit/{id}', [RegionController::class, 'edit'])->name('regions.edit');
    Route::post('regions/update', [RegionController::class, 'update'])->name('regions.update');
    Route::get('regions/add', [RegionController::class, 'create'])->name('regions.add');
    Route::get('regions/list', [RegionController::class, 'regionList']);
    Route::post('regions', [RegionController::class, 'store'])->name('regions.store');
    Route::delete('regions/delete/{id}', [RegionController::class, 'destroy'])->name('regions.delete');

    // trip-reviews routes
    Route::get('trip-reviews', [TripReviewController::class, 'index'])->name('trip-reviews.index');
    Route::get('trip-reviews/edit/{id}', [TripReviewController::class, 'edit'])->name('trip-reviews.edit');
    Route::post('trip-reviews/update', [TripReviewController::class, 'update'])->name('trip-reviews.update');
    Route::get('trip-reviews/add', [TripReviewController::class, 'create'])->name('trip-reviews.add');
    Route::get('trip-reviews/list', [TripReviewController::class, 'reviewsList']);
    Route::post('trip-reviews', [TripReviewController::class, 'store'])->name('trip-reviews.store');
    Route::delete('trip-reviews/delete/{id}', [TripReviewController::class, 'destroy'])->name('trip-reviews.delete');
    Route::get('trip-reviews/publish/{id}', [TripReviewController::class, 'publish'])->name('trip-reviews.pusblish');
    Route::post('trip-faqs/update-category/{id}', [TripFaqController::class, 'updateCategory'])->name('trip-faqs.update-category');

    // trip-reviews routes
    Route::get('why-choose-us', [WhyChooseController::class, 'index'])->name('why-chooses.index');
    Route::get('why-choose-us/edit/{id}', [WhyChooseController::class, 'edit'])->name('why-chooses.edit');
    Route::post('why-choose-us/update', [WhyChooseController::class, 'update'])->name('why-chooses.update');
    Route::get('why-choose-us/add', [WhyChooseController::class, 'create'])->name('why-chooses.add');
    Route::get('why-chooses/list', [WhyChooseController::class, 'whyChooseList']);
    Route::post('why-choose-us', [WhyChooseController::class, 'store'])->name('why-chooses.store');
    Route::delete('why-choose-us/delete/{id}', [WhyChooseController::class, 'destroy'])->name('why-chooses.delete');
    Route::get('why-chooses/publish/{id}', [WhyChooseController::class, 'publish'])->name('why-chooses.pusblish');

    // trip-faq routes
    Route::get('trip-faqs', [TripFaqController::class, 'index'])->name('trip-faqs.index');
    Route::get('trip-faqs/trip-list', [TripFaqController::class, 'tripList'])->name('trip-faqs.trip-list');
    Route::get('trip-faqs/{tripId}/list', [TripFaqController::class, 'faqs'])->name('trip-faqs.faqs');
    Route::get('trip-faqs/add', [TripFaqController::class, 'create'])->name('trip-faqs.add');
    Route::get('trip-faqs/{tripId}', [TripFaqController::class, 'faqList'])->name('trip-faqs.list');
    Route::get('trip-faqs/edit/{id}', [TripFaqController::class, 'edit'])->name('trip-faqs.edit');
    Route::post('trip-faqs/update', [TripFaqController::class, 'update'])->name('trip-faqs.update');
    Route::get('trip-faqs/list', [TripFaqController::class, 'faqsList']);
    Route::post('trip-faqs', [TripFaqController::class, 'store'])->name('trip-faqs.store');
    Route::delete('trip-faqs/delete/{id}', [TripFaqController::class, 'destroy'])->name('trip-faqs.delete');
    Route::delete('trips/faqs/delete/{id}', [TripFaqController::class, 'destroyAllTripFaqs'])->name('trips.faqs.delete');
    Route::get('trip-faqs/publish/{id}', [TripFaqController::class, 'publish'])->name('trip-faqs.pusblish');

    // trip-reviews routes
    Route::get('trip-departures', [TripDepartureController::class, 'index'])->name('trip-departures.index');
    Route::get('trip-departures/edit/{id}', [TripDepartureController::class, 'edit'])->name('trip-departures.edit');
    Route::post('trip-departures/update', [TripDepartureController::class, 'update'])->name('trip-departures.update');
    Route::get('trip-departures/add', [TripDepartureController::class, 'create'])->name('trip-departures.add');
    Route::get('trip-departures/list', [TripDepartureController::class, 'departureList']);
    Route::post('trip-departures', [TripDepartureController::class, 'store'])->name('trip-departures.store');
    Route::delete('trip-departures/delete/{id}', [TripDepartureController::class, 'destroy'])->name('trip-departures.delete');

    // region routes
    Route::get('trips', [TripController::class, 'index'])->name('trips.index');
    Route::get('trips/edit/{id}', [TripController::class, 'edit'])->name('trips.edit');
    Route::post('trips/update', [TripController::class, 'update'])->name('trips.update');
    Route::post('trips/info/update', [TripController::class, 'updateTripInfo'])->name('trips.info.update');
    Route::post('trips/includes/update', [TripController::class, 'updateTripIncludes'])->name('trips.includes.update');
    Route::post('trips/meta/update', [TripController::class, 'updateTripMeta'])->name('trips.meta.update');
    Route::post('trips/itineraries/update', [TripController::class, 'updateTripItineraries'])->name('trips.itineraries.update');
    Route::get('trips/slider/edit/{id}', [TripController::class, 'editSlider'])->name('trips.slider.edit');
    Route::post('trips/galleries/update', [TripController::class, 'updateTripGallery'])->name('trips.galleries.update');
    Route::post('trips/galleries', [TripController::class, 'storeTripGallery'])->name('trips.galleries.store');
    Route::get('trips/{trip_id}/galleries', [TripController::class, 'getAllTripGallery'])->name('trips.galleries.get-all-galleries');
    Route::delete('trip/gallery/delete/{id}', [TripController::class, 'deleteTripImage'])->name('trips.galleries.delete');

    Route::get('trips/gallery/edit/{id}', [TripSliderController::class, 'editSlider'])->name('trips.gallery.edit');
    Route::post('trips/sliders/update', [TripSliderController::class, 'updateTripSlider'])->name('trips.sliders.update');
    Route::post('trips/sliders', [TripSliderController::class, 'storeTripGallery'])->name('trips.sliders.store');
    Route::get('trips/{trip_id}/sliders', [TripSliderController::class, 'getAllTripGallery'])->name('trips.sliders.get-all-sliders');
    Route::delete('trip/slider/delete/{id}', [TripSliderController::class, 'deleteTripImage'])->name('trips.sliders.delete');
    Route::post('trips/price-range/update', [TripController::class, 'updateTripPriceRange'])->name('trips.pricerange.update');

    Route::get('trips/slider/edit/{id}', [TripController::class, 'editSlider'])->name('trips.slider.edit');
    Route::post('trips/galleries/update', [TripController::class, 'updateTripGallery'])->name('trips.galleries.update');
    Route::post('trips/galleries', [TripController::class, 'storeTripGallery'])->name('trips.galleries.store');
    Route::get('trips/{trip_id}/galleries', [TripController::class, 'getAllTripGallery'])->name('trips.galleries.get-all-galleries');
    Route::delete('trip/gallery/delete/{id}', [TripController::class, 'deleteTripImage'])->name('trips.galleries.delete');

    Route::get('/trips/update-feature/{id}', [TripController::class, 'updateFeaturedStatus']);
    Route::get('/trips/update-block1/{id}', [TripController::class, 'updateBlock1Status']);
    Route::get('/trips/update-block2/{id}', [TripController::class, 'updateBlock2Status']);
    Route::get('/trips/update-block3/{id}', [TripController::class, 'updateBlock3Status']);

    Route::get('trips/add', [TripController::class, 'create'])->name('trips.add');
    Route::get('trips/list', [TripController::class, 'tripList']);
    Route::post('trips', [TripController::class, 'store'])->name('trips.store');
    Route::delete('trips/delete/{id}', [TripController::class, 'destroy'])->name('trips.delete');

    // menu routes
    Route::get('menus', [MenuController::class, 'index'])->name('menus.index');
    Route::get('menus/edit/{id}', [MenuController::class, 'edit'])->name('menus.edit');
    Route::post('menus/update', [MenuController::class, 'update'])->name('menus.update');
    Route::get('menus/add', [MenuController::class, 'create'])->name('menus.add');
    Route::get('menus/list', [MenuController::class, 'menuList']);
    Route::post('menus', [MenuController::class, 'store'])->name('menus.store');
    Route::delete('menus/delete/{id}', [MenuController::class, 'destroy'])->name('menus.delete');

    Route::get('general', [SiteSettingController::class, 'general'])->name('settings.general');
    Route::post('general/store', [SiteSettingController::class, 'generalStore'])->name('settings.general.store');
    Route::post('social-media/store', [SiteSettingController::class, 'socialMediaStore'])->name('settings.socialmedia.store');
    Route::post('home-page/store', [SiteSettingController::class, 'homePageStore'])->name('settings.home-page.store');
    Route::post('contact-us/store', [SiteSettingController::class, 'contactUsStore'])->name('settings.contact-us.store');
    Route::post('third-party-sources/store', [SiteSettingController::class, 'thirdPartySourcesStore'])->name('settings.thirdPartySources.store');
    Route::get('seo-manager', [SiteSettingController::class, 'seoManager'])->name('settings.seo-manager');
    Route::post('seo-manager', [SiteSettingController::class, 'seoManagerStore'])->name('settings.seo-manager.store');

    // documents routes
    Route::get('legal-documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::get('documents/list', [DocumentController::class, 'documentList']);
    Route::post('documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::delete('documents/delete/{id}', [DocumentController::class, 'destroy'])->name('documents.delete');

    // faq category routes
    Route::get('faq-categories', [FaqCategoryController::class, 'index'])->name('faq-categories.index');
    Route::post('faq-categories', [FaqCategoryController::class, 'store'])->name('faq-categories.store');
    Route::get('faq-categories/list', [FaqCategoryController::class, 'list'])->name('faq-categories.list');
    Route::put('faq-categories/{faqCategory}', [FaqCategoryController::class, 'update'])->name('faq-categories.update');
    Route::delete('faq-categories/{faqCategory}', [FaqCategoryController::class, 'destroy'])->name('faq-categories.delete');

    Route::get('/icons', IconController::class)->name('icons');

    Route::get('/admin-setting', [UserController::class, 'setting'])->name('user-setting');
    Route::post('/admin-setting', [UserController::class, 'updateSetting'])->name('user-setting.update');

    Route::post('description-images/save', [DescriptionImageController::class, 'saveDescImage'])->name('description.save.image');
    Route::post('description-images/delete', [DescriptionImageController::class, 'deleteDescImage'])->name('description.delete.image');

    Route::get('bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::delete('bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');

    Route::get('enquiries', [EnquiryController::class, 'index'])->name('enquiries.index');
    Route::get('enquiries/{enquiry}', [EnquiryController::class, 'show'])->name('enquiries.show');
    Route::delete('enquiries/{enquiry}', [EnquiryController::class, 'destroy'])->name('enquiries.destroy');
});

Route::group(['as' => 'admin.', 'middleware' => 'admin'], function () {
    Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.index');
    Route::get('/generate-sitemap', [SitemapController::class, 'generate'])->name('generate-sitemap');
    Route::get('/sitemap-images.xml', [SitemapImageController::class, 'index'])->name('sitemapimage.index');
    Route::get('/generate-sitemap-image', [SitemapImageController::class, 'generate'])->name('generate-sitemapimage');
});

Route::get('/system-clear-cache', function () {
    Artisan::call('optimize:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    
    // Artisan::call('migrate');
    // Artisan::call('db:seed');
    // Artisan::call('storage:link');
    Artisan::call('migrate --force');
    return 'Cache is cleared';
});

// front end routes
require __DIR__.'/auth.php';
require __DIR__.'/front.php';
