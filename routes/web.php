<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\CommonPages\AdminViewController;

use App\Http\Controllers\Backend\SiteSettingsController;

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UsersController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'resource.maker',
    'auth.acl',
])->group(function () {
    Route::get('/dashboard', [AdminViewController::class, 'dashboard'])->name('dashboard');


    Route::resources([
        'site-settings' => SiteSettingsController::class,
    ]);
    Route::post('site-settings/theme', [SiteSettingsController::class, 'saveTheme'])->name('site-settings.theme');

    Route::prefix('admin')->middleware('resource.maker','auth.acl')->group(function () {
        Route::resource('/roles',RoleController::class);
        Route::resource('/users',UsersController::class);
    });

});

