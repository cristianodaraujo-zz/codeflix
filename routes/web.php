<?php

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

Route::get('/', function () {
    return view('welcome');
});

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

// Password Change
Route::get('password/change', 'Auth\ChangePasswordController@edit')->name('password.edit');
Route::put('password/change', 'Auth\ChangePasswordController@update')->name('password.update');

// E-mail Verification
Route::get('email-verification/error', 'EmailVerificationController@getVerificationError')->name('email-verification.error');
Route::get('email-verification/check/{token}', 'EmailVerificationController@getVerification')->name('email-verification.check');


Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin\\'], function () {
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');

    Route::group(['middleware' => ['verified', 'can:admin']], function () {
        Route::post('logout', 'Auth\LoginController@logout')->name('logout');
        Route::get('dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');
        Route::resource('users', 'UsersController');
        Route::resource('categories', 'CategoriesController');

        Route::get('playlists/{playlist}/thumbnail-path', 'PlaylistsController@thumbnailPath')
            ->name('playlists.thumbnail-path');
        Route::get('playlists/{playlist}/thumbnail-small-path', 'PlaylistsController@thumbnailSmallPath')
            ->name('playlists.thumbnail-small-path');
        Route::resource('playlists', 'PlaylistsController');

        Route::group(['prefix' => 'videos', 'as' => 'videos.'], function () {
            Route::get('{video}/relations', 'VideoRelationsController@edit')->name('relations.edit');
            Route::post('{video}/relations', 'VideoRelationsController@update')->name('relations.update');
            Route::get('{video}/uploads', 'VideoUploadsController@edit')->name('uploads.edit');
            Route::post('{video}/uploads', 'VideoUploadsController@update')->name('uploads.update');
        });
        Route::get('videos/{video}/archive-path', 'VideosController@archivePath')
            ->name('videos.archive-path');
        Route::get('videos/{video}/thumbnail-path', 'VideosController@thumbnailPath')
            ->name('videos.thumbnail-path');
        Route::get('videos/{video}/thumbnail-small-path', 'VideosController@thumbnailSmallPath')
            ->name('videos.thumbnail-small-path');
        Route::resource('videos', 'VideosController');
        Route::resource('plans', 'PlansController');
        Route::resource('web-profiles', 'WebProfilesController');
        Route::get('subscriptions', 'SubscriptionsController@index')->name('subscriptions.index');
    });
});
