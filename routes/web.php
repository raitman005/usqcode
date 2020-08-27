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

// Frontpage
Route::get('/', 'FrontPage\FrontPageController@index')->name('homepage');

// Static pages
Route::get('/terms', 'FrontPage\FrontPageController@terms')->name('terms');

// Search Pages
Route::get('/search', 'FrontPage\ListingController@searchView')->name('listing.search.ui');
Route::post('/search', 'FrontPage\ListingController@performSearch')->name('listing.search');

// Send inquiry pages
Route::get('/sendalisting', 'FrontPage\FrontPageController@listingCreate')->name('listing.create');
Route::get('/contact', 'FrontPage\FrontPageController@contact')->name('contact');
Route::post('/sendalisting', 'FrontPage\FrontPageController@listingCreateSend')->name('listing.create.send');
Route::post('/contact', 'FrontPage\FrontPageController@contactSend')->name('contact.send');

// Listing details pages
Route::get('/listing/{apartment}', 'FrontPage\ListingController@listing')->name('listing');
Route::post('/listing/send', 'FrontPage\ListingController@sendInquiry')->name('listing.send');

// Auth pages
Route::get('loginbyaccesstoken', 'Auth\LoginController@loginByAccessToken')->name('login.access_token');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('registerlogin', 'Auth\LoginController@registerlogin')->name('register.or.login.submit');
Route::post('login', 'Auth\LoginController@login')->name('login.submit');
Route::post('setpassword', 'Auth\SetPasswordController@setpassword')->name('setpassword.submit');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
// Route::get('register', 'Auth\RegisterController@index')->name('register');
// Route::post('register', 'Auth\RegisterController@register')->name('register.submit');

Route::middleware(['auth'])->group(function() {
    // profile
    Route::get('/profile', 'User\UserController@profile')->name('user.profile');
    Route::post('/profile', 'User\UserController@update')->name('user.profile.update');
    Route::post('/profile/avatar/update', 'User\UserController@updateAvatar')->name('user.profile.update.avatar');
    Route::post('/password/change', 'User\UserController@changePassword')->name('user.password.change');

    // manage listing
    Route::get('/agent/listings', 'Agent\ListingController@listings')->name('agent.listings');
    Route::get('/agent/listing/new', 'Agent\ListingController@new')->name('agent.listings.new');
    Route::get('/agent/listing/edit/{apartment}', 'Agent\ListingController@edit')->name('agent.listings.edit');
    Route::get('/agent/listing/setstatus/{apartment}', 'Agent\ListingController@setStatus')->name('agent.listings.setstatus');
    Route::post('/agent/listing/updatestatus', 'Agent\ListingController@updateStatus')->name('agent.listing.updatestatus');
    Route::post('/agent/listings', 'Agent\ListingController@store')->name('agent.listings.store');
    Route::post('/agent/listing/photos/upload', 'Agent\ListingController@uploadPhoto')->name('agent.listings.photos.upload');
    Route::post('/agent/listing/photos/reorder', 'Agent\ListingController@reorder')->name('agent.listings.photos.reorder');
    Route::post('/agent/listing/photos/delete', 'Agent\ListingController@deletePhoto')->name('agent.listings.photos.delete');
    Route::put('/agent/listing/update', 'Agent\ListingController@update')->name('agent.listings.update');

    Route::get('/agent/phototest', 'Agent\ListingController@phototest')->name('agent.photo.test');
    Route::get('/agent/testaddress', 'Agent\ListingController@test')->name('agent.address.test');

    //admin
    Route::get('/admin/index', 'Admin\AdminController@index')->name('admin.info');
    Route::get('/admin/accounts', 'Admin\AdminController@accounts')->name('admin.accounts');
    Route::get('/admin/listings', 'Admin\AdminController@listings')->name('admin.listings');
    Route::get('/admin/userlistings', 'Admin\AdminController@userlistings')->name('admin.user.listings');
});
