<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\CommonPages\AdminViewController;

use App\Http\Controllers\Backend\SiteSettingsController;

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Backend\NewsEvent\NewsEventCategoryController;
use App\Http\Controllers\Backend\NewsEvent\NewsEventController;
use App\Http\Controllers\Backend\CompanyServiceController;
use App\Http\Controllers\Backend\PageController;
use App\Http\Controllers\Frontend\PageViewController;

Route::get('/',[PageViewController::class,'home'])->name('home');
Route::get('/contact-us',[PageViewController::class,'contactUs'])->name('contact-us');
Route::post('/new-appointment',[PageViewController::class,'newAppointment'])->name('new-appointment');
Route::get('/service-categories',[PageViewController::class,'serviceCategories'])->name('service-categories');
Route::get('/news-event',[PageViewController::class,'newsEvents'])->name('news-event-category');
Route::get('/service/{companyServiceSlug}',[PageViewController::class,'serviceDetails'])->name('service-details');
Route::get('/news/{newsEventSlug}',[PageViewController::class,'newsEventDetails'])->name('news-event-details');
Route::get('/page/{pageSlug}',[PageViewController::class,'pageView'])->name('page-details');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'resource.maker',
    'auth.acl',
])->group(function () {
    Route::get('/dashboard', [AdminViewController::class, 'dashboard'])->name('dashboard');


    Route::resources([
        'site-settings'     => SiteSettingsController::class,
        'news-categories'   => NewsEventCategoryController::class,
        'news-events'       => NewsEventController::class,
        'company-services'  => CompanyServiceController::class,
        'pages'             => PageController::class,
        'appointments'      => \App\Http\Controllers\Backend\AppointmentController::class,
    ]);
    Route::post('site-settings/theme', [SiteSettingsController::class, 'saveTheme'])->name('site-settings.theme');

    Route::prefix('admin')->middleware('resource.maker','auth.acl')->group(function () {
        Route::resource('/roles',RoleController::class);
        Route::resource('/users',UsersController::class);
    });

});

Route::get('/clear-all', function () { \Illuminate\Support\Facades\Artisan::call('optimize:clear'); return \Illuminate\Support\Facades\Artisan::output(); });
Route::get('/optimize', function () { \Illuminate\Support\Facades\Artisan::call('optimize'); return \Illuminate\Support\Facades\Artisan::output(); });
Route::get('/migrate-seed', function () { \Illuminate\Support\Facades\Artisan::call('migrate:fresh --seed'); return 'success'; });
