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
Route::get('/page/{page-slug}',[PageViewController::class,'pageView'])->name('page-slug');

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
    ]);
    Route::post('site-settings/theme', [SiteSettingsController::class, 'saveTheme'])->name('site-settings.theme');

    Route::prefix('admin')->middleware('resource.maker','auth.acl')->group(function () {
        Route::resource('/roles',RoleController::class);
        Route::resource('/users',UsersController::class);
    });

});

